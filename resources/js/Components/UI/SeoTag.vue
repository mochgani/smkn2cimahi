<script setup>
import { Head, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    // Title page (akan di-append dengan nama sekolah)
    title:       { type: String, default: '' },
    // Description max 160 char (untuk SERP & social preview)
    description: { type: String, default: '' },
    // URL canonical (default ke URL saat ini)
    canonical:   { type: String, default: '' },
    // OG image (path absolut, fallback ke logo sekolah)
    image:       { type: String, default: '' },
    // Type: 'website' (default), 'article' untuk berita
    type:        { type: String, default: 'website' },
    // Article-specific (hanya kalau type='article')
    publishedAt: { type: String, default: '' },
    author:      { type: String, default: '' },
    section:     { type: String, default: '' }, // kategori berita
    // Tambahan JSON-LD schema (raw object)
    schema:      { type: Object, default: null },
});

const page = usePage();
const school = computed(() => page.props.schoolSetting ?? {});

const schoolName = computed(() => school.value.school_name || 'SMK Negeri 2 Cimahi');
const tagline    = computed(() => school.value.tagline || 'BMW: Bekerja · Melanjutkan · Wirausaha');

const fullTitle = computed(() =>
    props.title ? `${props.title} — ${schoolName.value}` : schoolName.value
);

const metaDesc = computed(() => {
    const desc = props.description || tagline.value;
    return desc.length > 160 ? desc.slice(0, 157) + '...' : desc;
});

const origin = computed(() => {
    if (typeof window !== 'undefined') return window.location.origin;
    return '';
});

const canonicalUrl = computed(() => {
    if (props.canonical) return props.canonical;
    if (typeof window !== 'undefined') return window.location.href.split('?')[0];
    return '';
});

const ogImage = computed(() => {
    if (props.image) {
        return props.image.startsWith('http') ? props.image : `${origin.value}${props.image}`;
    }
    // Fallback ke logo sekolah
    const logo = school.value.logo ? `/storage/${school.value.logo}` : '/images/logo.png';
    return `${origin.value}${logo}`;
});

const schemaJson = computed(() => {
    if (props.schema) {
        return JSON.stringify(props.schema);
    }

    // Default: EducationalOrganization untuk sekolah
    if (props.type === 'website') {
        return JSON.stringify({
            '@context': 'https://schema.org',
            '@type': 'EducationalOrganization',
            name: schoolName.value,
            url: origin.value || '',
            logo: ogImage.value,
            description: tagline.value,
        });
    }

    return null;
});
</script>

<template>
    <Head :title="fullTitle">
        <meta name="description" :content="metaDesc" />
        <link rel="canonical" :href="canonicalUrl" />

        <!-- Open Graph (Facebook, WhatsApp, LinkedIn) -->
        <meta property="og:site_name" :content="schoolName" />
        <meta property="og:type" :content="type" />
        <meta property="og:title" :content="fullTitle" />
        <meta property="og:description" :content="metaDesc" />
        <meta property="og:url" :content="canonicalUrl" />
        <meta property="og:image" :content="ogImage" />
        <meta property="og:image:width" content="1200" />
        <meta property="og:image:height" content="630" />
        <meta property="og:locale" content="id_ID" />

        <!-- Twitter Card -->
        <meta name="twitter:card" content="summary_large_image" />
        <meta name="twitter:title" :content="fullTitle" />
        <meta name="twitter:description" :content="metaDesc" />
        <meta name="twitter:image" :content="ogImage" />

        <!-- Article meta (jika type=article) -->
        <template v-if="type === 'article'">
            <meta v-if="publishedAt" property="article:published_time" :content="publishedAt" />
            <meta v-if="author" property="article:author" :content="author" />
            <meta v-if="section" property="article:section" :content="section" />
        </template>

        <!-- JSON-LD Schema.org -->
        <component
            v-if="schemaJson"
            :is="'script'"
            type="application/ld+json"
            v-html="schemaJson"
        />
    </Head>
</template>
