<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage();
const kontakSetting  = computed(() => page.props.kontakSetting ?? {});
const schoolSetting  = computed(() => page.props.schoolSetting ?? {});
const topbarItems    = computed(() => page.props.navigation?.topbar ?? []);

const teleponKanal = computed(() => kontakSetting.value.kanal?.find(k => k.label === 'TELEPON'));
const emailKanal   = computed(() => kontakSetting.value.kanal?.find(k => k.label === 'EMAIL'));
</script>

<template>
    <div class="topbar">
        <!-- Kiri: nama sekolah / tagline -->
        <span class="truncate max-w-full">
            <span class="sm:hidden">{{ schoolSetting.school_name?.toUpperCase() ?? 'SMK NEGERI 2 CIMAHI' }}</span>
            <span class="hidden sm:inline">
                {{ schoolSetting.school_name?.toUpperCase() ?? 'SMK NEGERI 2 CIMAHI' }}
                · {{ schoolSetting.tagline?.toUpperCase() ?? 'BMW: BEKERJA · MELANJUTKAN · WIRAUSAHA' }}
            </span>
        </span>

        <!-- Kanan: topbar nav items (jika ada), fallback ke telepon/email -->
        <span class="hidden sm:flex items-center gap-3 shrink-0">
            <template v-if="topbarItems.length">
                <template v-for="item in topbarItems" :key="item.label">
                    <!-- Item dengan children: tampil sebagai dropdown -->
                    <span v-if="item.children && item.children.length" class="relative group">
                        <span class="topbar-link cursor-default">
                            {{ item.label }}
                            <span aria-hidden="true" class="opacity-60">▾</span>
                        </span>
                        <span class="absolute right-0 top-full pt-1 hidden group-hover:block z-50">
                            <span class="block bg-ink/90 py-1 min-w-[160px]">
                                <a
                                    v-for="child in item.children"
                                    :key="child.label"
                                    :href="child.url || '#'"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="block px-4 py-2 text-[11px] text-bg/80 hover:text-bg hover:bg-white/10 transition-colors"
                                >
                                    {{ child.label }} ↗
                                </a>
                            </span>
                        </span>
                    </span>

                    <!-- Link langsung -->
                    <template v-else>
                        <a
                            v-if="item.url && item.url.startsWith('http')"
                            :href="item.url"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="topbar-link"
                        >{{ item.label }} ↗</a>
                        <Link
                            v-else
                            :href="item.url || '#'"
                            class="topbar-link"
                        >{{ item.label }}</Link>
                    </template>
                </template>
            </template>

            <!-- Fallback: telepon + email jika tidak ada topbar nav items -->
            <template v-else>
                <template v-if="teleponKanal">{{ teleponKanal.value }}</template>
                <template v-if="teleponKanal && emailKanal"> · </template>
                <template v-if="emailKanal">{{ emailKanal.value }}</template>
            </template>
        </span>
    </div>
</template>
