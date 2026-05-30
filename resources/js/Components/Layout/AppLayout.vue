<script setup>
import Topbar from './Topbar.vue';
import Header from './Header.vue';
import Footer from './Footer.vue';
</script>

<template>
    <div class="min-h-screen flex flex-col">
        <!-- A11y: skip-to-content link (muncul saat focus dengan Tab) -->
        <a href="#main-content" class="skip-link">Lewati ke konten utama</a>

        <Topbar />
        <Header />

        <main id="main-content" class="flex-1" tabindex="-1">
            <slot />
        </main>

        <Footer />
    </div>
</template>
