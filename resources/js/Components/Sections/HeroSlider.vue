<script setup>
import { ref, onMounted, onUnmounted } from 'vue';

const props = defineProps({
    slides: { type: Array, default: () => [] },
    intervalMs: { type: Number, default: 10000 },
});

const currentSlide = ref(0);
let autoplayHandle = null;

const next = () => {
    currentSlide.value = (currentSlide.value + 1) % props.slides.length;
};

const prev = () => {
    currentSlide.value = (currentSlide.value - 1 + props.slides.length) % props.slides.length;
};

const goTo = (i) => {
    currentSlide.value = i;
};

const startAutoplay = () => {
    stopAutoplay();
    autoplayHandle = setInterval(next, props.intervalMs);
};

const stopAutoplay = () => {
    if (autoplayHandle) {
        clearInterval(autoplayHandle);
        autoplayHandle = null;
    }
};

onMounted(startAutoplay);
onUnmounted(stopAutoplay);
</script>

<template>
    <section
        class="container-page py-8 sm:py-12 lg:py-16 pb-6 sm:pb-8"
        @mouseenter="stopAutoplay"
        @mouseleave="startAutoplay"
    >
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-10 lg:gap-12 items-center">
            <div class="flex flex-col justify-center order-2 md:order-1">
                <div class="inline-flex items-center gap-2 bg-white border border-line px-3 py-1 mb-4 sm:mb-6 w-fit">
                    <span class="w-2 h-2 rounded-full bg-accent"></span>
                    <span class="font-mono text-[10px] sm:text-[11px] text-ink tracking-mono">{{ slides[currentSlide].date }}</span>
                    <span class="font-mono text-[10px] sm:text-[11px] text-ink tracking-mono"> / </span>
                    <span class="font-mono text-[10px] sm:text-[11px] text-ink tracking-mono">{{ slides[currentSlide].tag }}</span>
                </div>

                <h1 class="text-[32px] sm:text-4xl md:text-5xl lg:text-6xl font-extrabold leading-[1.05] tracking-tightest text-ink mb-4 sm:mb-6 max-w-xl">
                    {{ slides[currentSlide].title }}
                </h1>

                <p class="text-[14px] sm:text-base leading-relaxed text-muted-soft max-w-md mb-6 sm:mb-8">
                    {{ slides[currentSlide].desc }}
                </p>

                <div class="flex gap-3 flex-wrap">
                    <a :href="slides[currentSlide].ctaHref" class="btn-primary">
                        {{ slides[currentSlide].cta }} <span class="text-base">↗</span>
                    </a>
                </div>
            </div>

            <div class="relative aspect-[4/3] overflow-hidden bg-line-soft order-1 md:order-2">
                <!-- Gambar jika ada -->
                <img
                    v-if="slides[currentSlide].image"
                    :src="slides[currentSlide].image"
                    :alt="slides[currentSlide].title"
                    :loading="currentSlide === 0 ? 'eager' : 'lazy'"
                    fetchpriority="high"
                    decoding="async"
                    class="absolute inset-0 w-full h-full object-cover"
                />
                <!-- Fallback pattern jika tidak ada gambar -->
                <div
                    v-else
                    class="absolute inset-0"
                    style="background-image: repeating-linear-gradient(135deg, #e8e6e0 0 14px, #d4d0c5 14px 28px);"
                ></div>
                <div
                    class="absolute inset-0 pointer-events-none"
                    style="background: radial-gradient(circle at 30% 30%, rgba(13,110,63,0.15) 0%, transparent 50%), radial-gradient(circle at 70% 70%, rgba(13,110,63,0.08) 0%, transparent 50%);"
                ></div>
                <div class="absolute bottom-3 left-3 sm:bottom-6 sm:left-6 bg-white/95 px-3 sm:px-5 py-2 sm:py-3.5 border border-line">
                    <span class="block font-mono text-[9px] sm:text-[10px] text-muted tracking-mono-wide">FOKUS BULAN INI</span>
                    <span class="block font-mono text-[12px] sm:text-sm font-semibold text-ink tracking-mono">{{ slides[currentSlide].badge }}</span>
                </div>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 pt-4 border-t border-line mt-6 sm:mt-8">
            <div class="flex gap-1 overflow-x-auto -mx-2 px-2">
                <button
                    v-for="(_, i) in slides"
                    :key="i"
                    type="button"
                    @click="goTo(i)"
                    class="font-mono text-xs py-1.5 px-3 sm:px-4 transition-colors shrink-0"
                    :class="i === currentSlide ? 'text-accent' : 'text-muted hover:text-ink'"
                >
                    [{{ String(i + 1).padStart(2, '0') }}]
                </button>
            </div>
            <div class="flex gap-4">
                <button type="button" @click="prev" class="font-mono text-[13px] text-ink hover:text-accent">← Prev</button>
                <button type="button" @click="next" class="font-mono text-[13px] text-ink hover:text-accent">Next →</button>
            </div>
        </div>
    </section>
</template>
