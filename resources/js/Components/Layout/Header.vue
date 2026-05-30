<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const page = usePage();

const navigation = computed(() => page.props.navigation ?? []);
const schoolSetting = computed(() => page.props.schoolSetting ?? {});
const logoUrl = computed(() => schoolSetting.value.logo ? `/storage/${schoolSetting.value.logo}` : '/images/logo.png');

const openMenu = ref(null);
const setOpen = (idx) => { openMenu.value = idx; };
const setClose = () => { openMenu.value = null; };

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
    <header class="sticky top-0 z-50 bg-bg/90 backdrop-blur border-b border-line">
        <div class="container-page flex items-center justify-between h-[70px] gap-8">
            <Link href="/" class="flex items-center gap-3.5 shrink-0">
                <img :src="logoUrl" :alt="`Logo ${schoolSetting.school_name ?? 'SMKN 2 Cimahi'}`" class="w-12 h-12 object-contain" />
                <div>
                    <div class="text-sm font-bold text-ink leading-tight">{{ schoolSetting.school_name ?? 'SMKN 2 Cimahi' }}</div>
                    <div class="font-mono text-[10px] text-muted tracking-mono mt-0.5">EST. {{ schoolSetting.tahun_berdiri ?? '2007' }} / KOTA CIMAHI</div>
                </div>
            </Link>

            <nav class="flex gap-5 lg:gap-7 items-center flex-wrap" aria-label="Menu utama">
                <template v-for="(item, idx) in navigation" :key="idx">
                    <!-- Item dengan children: render dropdown -->
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
                            <span class="text-[10px] transition-transform" :class="{ 'rotate-180': openMenu === idx }" aria-hidden="true">▾</span>
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

                    <!-- Item tanpa children: render link langsung -->
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

        </div>
    </header>
</template>
