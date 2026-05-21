<script setup>
import Topbar from './Topbar.vue';
import Header from './Header.vue';
import Footer from './Footer.vue';
</script>

<template>
    <div class="min-h-screen flex flex-col">
        <Topbar />
        <Header />

        <main class="flex-1">
            <slot />
        </main>

        <Footer />
    </div>
</template>
