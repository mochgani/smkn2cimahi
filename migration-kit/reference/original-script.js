/* ============================================
   SMKN 2 CIMAHI — Interactivity
   ============================================ */

// ===== Hero Slider Data =====
const slides = [
  {
    tag: 'KEGIATAN',
    title: 'Pesantren Ekologi: Tiga Tahap Aksi Nyata Peduli Lingkungan',
    desc: 'Program bertahap 23 Februari – 13 Maret 2026, membentuk karakter peserta didik yang peduli terhadap lingkungan sekolah dan sekitar.',
    cta: 'Baca Selengkapnya',
    date: '04.03.2026',
    badge: 'PESANTREN EKOLOGI'
  },
  {
    tag: 'PRESTASI',
    title: 'Vidika, Pivot Muda Raih Juara 3 AAFI 2025',
    desc: 'Siswa kelas X Mekatronika A meraih Juara 3 Nasional Grand Champion Asosiasi Akademi Futsal Indonesia putaran nasional 2025.',
    cta: 'Lihat Prestasi',
    date: '05.12.2025',
    badge: 'JUARA NASIONAL'
  },
  {
    tag: 'PENGUMUMAN',
    title: 'Pendaftaran SPMB 2026/2027 Telah Dibuka',
    desc: 'Bergabunglah dengan SMK Negeri 2 Cimahi. Enam kompetensi keahlian, fasilitas lengkap, dan lulusan yang siap kerja.',
    cta: 'Daftar Sekarang',
    date: '01.04.2026',
    badge: 'SPMB 2026'
  }
];

let currentSlide = 0;

// ===== Slide elements =====
const heroDate = document.getElementById('hero-date');
const heroTag = document.getElementById('hero-tag');
const heroTitle = document.getElementById('hero-title');
const heroDesc = document.getElementById('hero-desc');
const heroCta = document.getElementById('hero-cta');
const heroBadge = document.querySelector('.badge-value');
const slideDots = document.querySelectorAll('.slide-dot');
const prevBtn = document.getElementById('prev-slide');
const nextBtn = document.getElementById('next-slide');

// ===== Update slide content =====
function showSlide(index) {
  const slide = slides[index];
  if (!slide) return;

  // Fade out, then update content
  heroTitle.style.opacity = '0';
  heroDesc.style.opacity = '0';

  setTimeout(() => {
    heroDate.textContent = slide.date;
    heroTag.textContent = slide.tag;
    heroTitle.textContent = slide.title;
    heroDesc.textContent = slide.desc;
    heroCta.firstChild.textContent = slide.cta + ' ';
    if (heroBadge) heroBadge.textContent = slide.badge;

    heroTitle.style.opacity = '1';
    heroDesc.style.opacity = '1';
  }, 200);

  // Update active dot
  slideDots.forEach((dot, i) => {
    dot.classList.toggle('active', i === index);
  });

  currentSlide = index;
}

// ===== Slide navigation =====
slideDots.forEach((dot) => {
  dot.addEventListener('click', () => {
    const index = parseInt(dot.dataset.slide);
    showSlide(index);
  });
});

if (prevBtn) {
  prevBtn.addEventListener('click', () => {
    const newIndex = (currentSlide - 1 + slides.length) % slides.length;
    showSlide(newIndex);
  });
}

if (nextBtn) {
  nextBtn.addEventListener('click', () => {
    const newIndex = (currentSlide + 1) % slides.length;
    showSlide(newIndex);
  });
}

// ===== Auto-advance slider =====
let autoplayInterval = setInterval(() => {
  const newIndex = (currentSlide + 1) % slides.length;
  showSlide(newIndex);
}, 6000);

// Pause on hover
const hero = document.querySelector('.hero');
if (hero) {
  hero.addEventListener('mouseenter', () => clearInterval(autoplayInterval));
  hero.addEventListener('mouseleave', () => {
    autoplayInterval = setInterval(() => {
      const newIndex = (currentSlide + 1) % slides.length;
      showSlide(newIndex);
    }, 6000);
  });
}

// ===== Smooth transitions for hero text =====
[heroTitle, heroDesc].forEach(el => {
  if (el) el.style.transition = 'opacity 0.3s ease';
});

// ===== Active nav on scroll =====
const sections = document.querySelectorAll('section[id]');
const navLinks = document.querySelectorAll('.nav-link');

function updateActiveNav() {
  const scrollPos = window.scrollY + 150;

  sections.forEach(section => {
    const top = section.offsetTop;
    const bottom = top + section.offsetHeight;
    const id = section.getAttribute('id');

    if (scrollPos >= top && scrollPos < bottom) {
      navLinks.forEach(link => {
        link.classList.remove('active');
        if (link.getAttribute('href') === '#' + id) {
          link.classList.add('active');
        }
      });
    }
  });
}

window.addEventListener('scroll', updateActiveNav);

// ===== Smooth scroll for anchor links =====
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
  anchor.addEventListener('click', function(e) {
    const href = this.getAttribute('href');
    if (href === '#') return;

    const target = document.querySelector(href);
    if (target) {
      e.preventDefault();
      const offset = 80;
      const top = target.getBoundingClientRect().top + window.scrollY - offset;
      window.scrollTo({ top, behavior: 'smooth' });
    }
  });
});

console.log('SMKN 2 Cimahi — Website ready');
