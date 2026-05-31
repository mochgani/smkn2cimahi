<script setup>
import { Link, usePage, router } from '@inertiajs/vue3';
import { ref, computed, onMounted, onUnmounted, watch } from 'vue';

const page = usePage();

const navigation = computed(() => page.props.navigation ?? []);
const schoolSetting = computed(() => page.props.schoolSetting ?? {});
const logoUrl = computed(() => schoolSetting.value.logo ? `/storage/${schoolSetting.value.logo}` : '/images/logo.png');

// Desktop dropdown state
const openMenu = ref(null);
const setOpen = (idx) => { openMenu.value = idx; };
const setClose = () => { openMenu.value = null; };

// Mobile drawer state
const mobileOpen = ref(false);
const mobileExpanded = ref({}); // accordion state per item index

const toggleMobile = () => { mobileOpen.value = !mobileOpen.value; };
const closeMobile = () => { mobileOpen.value = false; };
const toggleExpanded = (idx) => {
    mobileExpanded.value[idx] = !mobileExpanded.value[idx];
};

// Lock body scroll saat drawer open
watch(mobileOpen, (open) => {
    if (typeof document !== 'undefined') {
        document.body.style.overflow = open ? 'hidden' : '';
    }
});

// Close mobile menu saat navigate ke page baru
onMounted(() => {
    router.on('navigate', () => closeMobile());
});

onUnmounted(() => {
    if (typeof document !== 'undefined') {
        document.body.style.overflow = '';
    }
});

const currentUrl = computed(() => page.url || '/');

const isActive = (item) => {
    if (item.url === '/') {
        return currentUrl.value === '/';
    }

    if (item.url && item.url !== '#' && currentUrl.value.startsWith(item.url)) {
        return true;
    }

    if (item.children?.length) {
        return item.children.some((c) => c.url && c.url !== '#' && currentUrl.value.startsWith(c.url));
    }

    return false;
};
</script>

<template>
    <header class="sticky top-0 z-50 bg-bg/95 backdrop-blur border-b border-line">
        <div class="container-page flex items-center justify-between h-[64px] lg:h-[70px] gap-4 lg:gap-8">
            <!-- Logo + Nama Sekolah -->
            <Link href="/" class="flex items-center gap-2.5 lg:gap-3.5 shrink-0 min-w-0" @click="closeMobile">
                <img
                    :src="logoUrl"
                    :alt="`Logo ${schoolSetting.school_name ?? 'SMKN 2 Cimahi'}`"
                    class="w-10 h-10 lg:w-12 lg:h-12 object-contain shrink-0"
                />
                <div class="min-w-0">
                    <div class="text-[13px] lg:text-sm font-bold text-ink leading-tight truncate">
                        {{ schoolSetting.school_name ?? 'SMKN 2 Cimahi' }}
                    </div>
                    <div class="hidden sm:block font-mono text-[10px] text-muted tracking-mono mt-0.5">
                        EST. {{ schoolSetting.tahun_berdiri ?? '2007' }} / KOTA CIMAHI
                    </div>
                </div>
            </Link>

            <!-- Desktop Navigation (≥ lg) -->
            <nav class="hidden lg:flex gap-5 xl:gap-7 items-center" aria-label="Menu utama">
                <template v-for="(item, idx) in navigation" :key="idx">
                    <div
                        v-if="item.children && item.children.length"
                        class="relative"
                        @mouseenter="setOpen(idx)"
                        @mouseleave="setClose"
                    >
                        <button
                            type="button"
                            :aria-expanded="openMenu === idx"
                            :aria-label="`Menu ${item.label}`"
                            class="text-[13px] font-medium text-ink-soft hover:text-accent inline-flex items-center gap-1 transition-colors"
                            :class="{ 'text-accent': isActive(item) }"
                        >
                            {{ item.label }}
                            <span
                                class="text-[10px] transition-transform"
                                :class="{ 'rotate-180': openMenu === idx }"
                                aria-hidden="true"
                            >▾</span>
                        </button>
                        <div
                            v-show="openMenu === idx"
                            role="menu"
                            class="absolute top-full -left-4 bg-white border border-line min-w-[240px] py-2 shadow-lg z-50"
                        >
                            <Link
                                v-for="child in item.children"
                                :key="child.url + child.label"
                                :href="child.url || '#'"
                                class="block px-5 py-2.5 text-[13px] text-ink-soft hover:bg-bg-alt hover:text-accent hover:pl-6 transition-all"
                            >
                                {{ child.label }}
                            </Link>
                        </div>
                    </div>

                    <Link
                        v-else
                        :href="item.url || '#'"
                        class="text-[13px] font-medium text-ink-soft hover:text-accent transition-colors"
                        :class="{ 'text-accent': isActive(item) }"
                    >
                        {{ item.label }}
                    </Link>
                </template>
            </nav>

            <!-- Mobile Hamburger Button (< lg) -->
            <button
                type="button"
                class="lg:hidden flex items-center justify-center w-10 h-10 text-ink hover:text-accent transition-colors shrink-0"
                :aria-expanded="mobileOpen"
                aria-label="Toggle menu"
                aria-controls="mobile-drawer"
                @click="toggleMobile"
            >
                <!-- Icon hamburger / close -->
                <svg
                    v-if="!mobileOpen"
                    xmlns="http://www.w3.org/2000/svg"
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="square"
                >
                    <line x1="3" y1="6"  x2="21" y2="6" />
                    <line x1="3" y1="12" x2="21" y2="12" />
                    <line x1="3" y1="18" x2="21" y2="18" />
                </svg>
                <svg
                    v-else
                    xmlns="http://www.w3.org/2000/svg"
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="square"
                >
                    <line x1="6" y1="6"  x2="18" y2="18" />
                    <line x1="6" y1="18" x2="18" y2="6" />
                </svg>
            </button>
        </div>

        <!-- Mobile Drawer Overlay -->
        <Transition
            enter-active-class="transition-opacity duration-200"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="transition-opacity duration-200"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <div
                v-if="mobileOpen"
                class="lg:hidden fixed inset-0 top-[64px] lg:top-[70px] bg-ink/40 z-40"
                @click="closeMobile"
            />
        </Transition>

        <!-- Mobile Drawer -->
        <Transition
            enter-active-class="transition-transform duration-300 ease-out"
            enter-from-class="-translate-y-full"
            enter-to-class="translate-y-0"
            leave-active-class="transition-transform duration-200 ease-in"
            leave-from-class="translate-y-0"
            leave-to-class="-translate-y-full"
        >
            <nav
                v-if="mobileOpen"
                id="mobile-drawer"
                class="lg:hidden fixed top-[64px] left-0 right-0 bg-bg border-b border-line z-40 max-h-[calc(100vh-64px)] overflow-y-auto"
                aria-label="Menu utama"
            >
                <div class="container-page py-4">
                    <template v-for="(item, idx) in navigation" :key="idx">
                        <!-- Item dengan children: accordion -->
                        <div v-if="item.children && item.children.length" class="border-b border-line">
                            <button
                                type="button"
                                class="w-full flex items-center justify-between py-4 text-left"
                                :class="{ 'text-accent': isActive(item) }"
                                :aria-expanded="mobileExpanded[idx] || false"
                                @click="toggleExpanded(idx)"
                            >
                                <span class="text-[15px] font-medium text-ink">{{ item.label }}</span>
                                <span
                                    class="text-[12px] transition-transform text-muted"
                                    :class="{ 'rotate-180': mobileExpanded[idx] }"
                                    aria-hidden="true"
                                >▾</span>
                            </button>
                            <Transition
                                enter-active-class="transition-all duration-200 ease-out"
                                enter-from-class="max-h-0 opacity-0"
                                enter-to-class="max-h-[800px] opacity-100"
                                leave-active-class="transition-all duration-150 ease-in"
                                leave-from-class="max-h-[800px] opacity-100"
                                leave-to-class="max-h-0 opacity-0"
                            >
                                <div
                                    v-if="mobileExpanded[idx]"
                                    class="overflow-hidden pb-3"
                                >
                                    <Link
                                        v-for="child in item.children"
                                        :key="child.url + child.label"
                                        :href="child.url || '#'"
                                        class="block py-2.5 pl-4 text-[14px] text-ink-soft hover:text-accent border-l-2 border-line ml-1 hover:border-accent transition-colors"
                                        @click="closeMobile"
                                    >
                                        {{ child.label }}
                                    </Link>
                                </div>
                            </Transition>
                        </div>

                        <!-- Item tanpa children -->
                        <Link
                            v-else
                            :href="item.url || '#'"
                            class="block py-4 text-[15px] font-medium text-ink hover:text-accent transition-colors border-b border-line"
                            :class="{ 'text-accent': isActive(item) }"
                            @click="closeMobile"
                        >
                            {{ item.label }}
                        </Link>
                    </template>
                </div>
            </nav>
        </Transition>
    </header>
</template>
