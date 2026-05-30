<script setup>
import { Link, useForm, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import AppLayout from '@/Components/Layout/AppLayout.vue';
import PageHeader from '@/Components/UI/PageHeader.vue';
import SectionLabel from '@/Components/UI/SectionLabel.vue';
import Callout from '@/Components/UI/Callout.vue';
import SeoTag from '@/Components/UI/SeoTag.vue';

const page = usePage();
const flashSuccess = computed(() => page.props.flash?.success);

const props = defineProps({
    maps_embed_url:     { type: String, default: '' },
    maps_address_short: { type: String, default: '' },
    maps_address_full:  { type: String, default: '' },
    kanal:              { type: Array, default: () => [] },
    bagian:             { type: Array, default: () => [] },
    social:             { type: Array, default: () => [] },
    kompetensiByBidang: { type: Array, default: () => [] },
});

const waKanal = computed(() => props.kanal.find(k => k.label === 'WHATSAPP'));
const emailKanal = computed(() => props.kanal.find(k => k.label === 'EMAIL'));

const form = useForm({
    nama: '',
    email: '',
    telepon: '',
    subjek: '',
    pesan: '',
});

const submit = () => {
    form.post('/kontak', {
        preserveScroll: true,
        onSuccess: () => form.reset(),
    });
};
</script>

<template>
    <SeoTag
        title="Kontak"
        description="Hubungi SMK Negeri 2 Cimahi via telepon, email, WhatsApp, atau kunjungi langsung. Senin - Jumat 07:00 - 16:00 WIB."
    />

    <AppLayout>
        <PageHeader
            :breadcrumbs="[
                { label: 'Beranda', href: '/' },
                { label: 'Kontak' },
            ]"
            meta="SENIN — JUMAT · 07:00 — 16:00 WIB"
            title="Mari berhubungan."
            lead="Tim SMKN 2 Cimahi siap menjawab pertanyaan Anda — dari informasi pendaftaran, kerja sama industri, hingga rekrutmen lulusan. Pilih kanal yang paling sesuai."
        />

        <!-- Kanal Kontak -->
        <section v-if="kanal.length" class="container-page py-12">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 border-t border-l border-line">
                <a
                    v-for="k in kanal"
                    :key="k.num"
                    :href="k.href"
                    :target="k.external ? '_blank' : undefined"
                    :rel="k.external ? 'noopener' : undefined"
                    class="block p-6 bg-white border-r border-b border-line transition-colors hover:bg-bg-alt group"
                >
                    <div class="font-mono text-[11px] text-accent tracking-mono mb-4">[{{ k.num }}]</div>
                    <div class="font-mono text-[10px] text-muted tracking-mono-wide uppercase mb-3">{{ k.label }}</div>
                    <div class="text-[16px] font-bold text-ink leading-tight tracking-tighter mb-4">{{ k.value }}</div>
                    <p class="text-[12px] text-muted leading-relaxed whitespace-pre-line mb-6">{{ k.detail }}</p>
                    <div class="font-mono text-[11px] text-ink tracking-mono group-hover:text-accent">{{ k.action }}</div>
                </a>
            </div>
        </section>

        <!-- Peta & Form -->
        <section class="container-page pt-12 pb-0">
            <SectionLabel num="2" title="Lokasi & Pesan" />
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 mb-10">
                <h2 class="section-h2">Kunjungi kami atau kirim pesan langsung.</h2>
                <p class="section-sub">Berlokasi strategis di Cimahi Utara, mudah diakses dengan kendaraan pribadi maupun transportasi umum.</p>
            </div>
        </section>

        <div class="container-page">
            <div class="grid grid-cols-1 lg:grid-cols-[1.2fr_1fr] border border-line">
                <!-- Peta -->
                <div class="relative min-h-[480px]">
                    <iframe
                        v-if="maps_embed_url"
                        :src="maps_embed_url"
                        class="absolute inset-0 w-full h-full"
                        style="border: 0"
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        allowfullscreen
                    />
                    <div v-else class="absolute inset-0 bg-line-soft flex items-center justify-center">
                        <span class="font-mono text-[12px] text-muted tracking-mono">PETA BELUM DIKONFIGURASI</span>
                    </div>
                    <div v-if="maps_address_short" class="absolute top-6 left-6 bg-white/95 px-5 py-4 border border-line max-w-[280px]">
                        <div class="font-mono text-[10px] text-accent tracking-mono-wide mb-2">📍 LOKASI SEKOLAH</div>
                        <div class="text-[15px] font-bold text-ink leading-tight tracking-tighter mb-2">SMK Negeri 2 Cimahi</div>
                        <p class="text-[12px] text-muted leading-relaxed mb-3">{{ maps_address_short }}</p>
                        <a
                            v-if="kanal.find(k => k.label === 'ALAMAT')"
                            :href="kanal.find(k => k.label === 'ALAMAT').href"
                            target="_blank"
                            rel="noopener"
                            class="font-mono text-[11px] text-ink tracking-mono hover:text-accent"
                        >
                            Petunjuk Arah →
                        </a>
                    </div>
                </div>

                <!-- Form -->
                <form @submit.prevent="submit" class="bg-white p-8 lg:p-10 border-l border-line">
                    <div class="mb-6">
                        <div class="font-mono text-[11px] text-accent tracking-mono-wide uppercase mb-2">KIRIM PESAN</div>
                        <h3 class="text-2xl font-bold text-ink tracking-tighter mb-1">Tulis pesan Anda</h3>
                        <p class="text-[13px] text-muted">Kami akan merespon dalam 1×24 jam kerja.</p>
                    </div>

                    <div
                        v-if="flashSuccess"
                        class="bg-accent/10 border border-accent text-accent-dark px-4 py-3 font-mono text-[12px] tracking-mono mb-5"
                    >
                        ✓ {{ flashSuccess }}
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="nama" class="form-label">Nama Lengkap *</label>
                            <input id="nama" v-model="form.nama" type="text" class="form-input" placeholder="Nama Anda" required />
                            <div v-if="form.errors.nama" class="font-mono text-[11px] text-red-600 mt-1">{{ form.errors.nama }}</div>
                        </div>
                        <div>
                            <label for="email" class="form-label">Email *</label>
                            <input id="email" v-model="form.email" type="email" class="form-input" placeholder="email@anda.com" required />
                            <div v-if="form.errors.email" class="font-mono text-[11px] text-red-600 mt-1">{{ form.errors.email }}</div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="telepon" class="form-label">No. Telepon</label>
                            <input id="telepon" v-model="form.telepon" type="tel" class="form-input" placeholder="+62 ..." />
                        </div>
                        <div>
                            <label for="subjek" class="form-label">Topik *</label>
                            <select id="subjek" v-model="form.subjek" class="form-input" required>
                                <option value="">Pilih topik</option>
                                <option value="ppdb">Penerimaan Murid Baru (SPMB)</option>
                                <option value="bkk">Kerja Sama Industri / BKK</option>
                                <option value="kemitraan">Kemitraan IDUKA</option>
                                <option value="alumni">Informasi Alumni</option>
                                <option value="kunjungan">Kunjungan Sekolah</option>
                                <option value="lain">Lainnya</option>
                            </select>
                            <div v-if="form.errors.subjek" class="font-mono text-[11px] text-red-600 mt-1">{{ form.errors.subjek }}</div>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label for="pesan" class="form-label">Pesan *</label>
                        <textarea id="pesan" v-model="form.pesan" class="form-input" rows="6" placeholder="Tulis pesan Anda di sini..." required />
                        <div v-if="form.errors.pesan" class="font-mono text-[11px] text-red-600 mt-1">{{ form.errors.pesan }}</div>
                    </div>

                    <div class="flex items-center justify-between flex-wrap gap-4">
                        <p class="font-mono text-[10px] text-muted tracking-mono">* Wajib diisi. Data Anda akan dijaga kerahasiaannya.</p>
                        <button type="submit" :disabled="form.processing" class="btn-primary disabled:opacity-50">
                            {{ form.processing ? 'Mengirim…' : 'Kirim Pesan →' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Kontak per Bagian -->
        <section v-if="bagian.length" class="container-page pt-16 pb-0">
            <SectionLabel num="3" title="Kontak per Bagian" />
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 mb-10">
                <h2 class="section-h2">Hubungi bagian yang tepat untuk respon lebih cepat.</h2>
                <p class="section-sub">Setiap unit kerja di SMKN 2 Cimahi memiliki tim khusus yang siap melayani sesuai bidang.</p>
            </div>
        </section>

        <div v-if="bagian.length" class="container-page">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 border-t border-l border-line">
                <div v-for="b in bagian" :key="b.num" class="bg-white p-7 border-r border-b border-line">
                    <div class="font-mono text-[24px] font-semibold text-accent leading-none tracking-tight mb-4">{{ b.num }}</div>
                    <h4 class="text-base font-bold text-ink leading-tight tracking-tighter mb-3">{{ b.name }}</h4>
                    <p class="text-[13px] text-muted-soft leading-relaxed mb-5">{{ b.desc }}</p>
                    <div>
                        <div class="font-mono text-[10px] text-muted tracking-mono-wide uppercase mb-1">{{ b.label }}</div>
                        <a :href="b.href" class="text-[13px] text-ink hover:text-accent break-all">{{ b.value }}</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bidang Studi (dari DB kompetensi) -->
        <section v-if="kompetensiByBidang.length" class="container-page pt-16 pb-0">
            <SectionLabel num="4" title="Bidang Studi Keahlian" />
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 mb-10">
                <h2 class="section-h2">{{ kompetensiByBidang.length }} bidang keahlian unggulan.</h2>
                <p class="section-sub">SMKN 2 Cimahi mencakup beberapa bidang studi keahlian dengan kompetensi unggulan.</p>
            </div>
        </section>

        <div v-if="kompetensiByBidang.length" class="container-page">
            <div class="grid grid-cols-1 md:grid-cols-3 border-t border-l border-line">
                <div v-for="(b, idx) in kompetensiByBidang" :key="idx" class="bg-white border-r border-b border-line p-7">
                    <div class="font-mono text-[11px] text-accent tracking-mono-wide uppercase mb-3">
                        BIDANG {{ String(idx + 1).padStart(2, '0') }}
                    </div>
                    <h3 class="text-lg font-bold text-ink leading-tight tracking-tighter mb-3">{{ b.name }}</h3>
                    <div class="space-y-2">
                        <Link
                            v-for="item in b.items"
                            :key="item.href"
                            :href="item.href"
                            class="flex items-center gap-3 py-2 border-t border-line hover:text-accent transition-colors group"
                        >
                            <span class="font-mono text-[11px] text-accent tracking-mono w-10">{{ item.code }}</span>
                            <span class="flex-1 text-[13px] text-ink group-hover:text-accent">{{ item.name }}</span>
                            <span class="font-mono text-[12px] text-ink group-hover:text-accent">→</span>
                        </Link>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sosial Media -->
        <section v-if="social.length" class="container-page pt-16 pb-0">
            <SectionLabel num="5" title="Sosial Media" />
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 mb-10">
                <h2 class="section-h2">Ikuti kami di sosial media.</h2>
                <p class="section-sub">Update kegiatan, prestasi, dan momen-momen penting di SMKN 2 Cimahi.</p>
            </div>
        </section>

        <div v-if="social.length" class="container-page">
            <div class="grid grid-cols-2 md:grid-cols-4 border-t border-l border-line">
                <a
                    v-for="s in social"
                    :key="s.num"
                    :href="s.href"
                    target="_blank"
                    rel="noopener"
                    class="block bg-white border-r border-b border-line p-6 transition-colors hover:bg-bg-alt group"
                >
                    <div class="font-mono text-[24px] font-semibold text-accent leading-none mb-4">{{ s.num }}</div>
                    <div class="font-mono text-[10px] text-muted tracking-mono-wide uppercase mb-2">{{ s.label }}</div>
                    <div class="text-[14px] font-bold text-ink leading-tight tracking-tighter mb-4">{{ s.handle }}</div>
                    <div class="font-mono text-[14px] text-ink group-hover:text-accent">→</div>
                </a>
            </div>
        </div>

        <div class="mt-16" />

        <Callout
            label="PERTANYAAN URGENT?"
            title="Hubungi kami langsung lewat WhatsApp."
        >
            Untuk pertanyaan yang membutuhkan respon cepat, silakan chat langsung ke WhatsApp
            <strong v-if="waKanal">{{ waKanal.value }}</strong>.
            Tim kami siap membantu di hari kerja Senin sampai Jumat, pukul 07:00 – 16:00 WIB.
            Untuk informasi non-urgent, gunakan formulir kontak di atas atau email ke
            <strong v-if="emailKanal">{{ emailKanal.value }}</strong>.
        </Callout>
    </AppLayout>
</template>
