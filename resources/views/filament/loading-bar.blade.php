<div
    id="smkn2-loading-bar"
    style="position: fixed; top: 0; left: 0; height: 3px; width: 0%; z-index: 9999;
           background: #0d6e3f; opacity: 0; transition: width 0.2s ease, opacity 0.2s ease;"
></div>

<script>
    document.addEventListener('livewire:init', () => {
        const bar = document.getElementById('smkn2-loading-bar');
        let activeRequests = 0;
        let hideTimeout;

        const showBar = () => {
            clearTimeout(hideTimeout);
            activeRequests++;
            bar.style.opacity = '1';
            bar.style.width = '10%';
            requestAnimationFrame(() => {
                bar.style.width = '70%';
            });
        };

        const hideBar = () => {
            activeRequests = Math.max(0, activeRequests - 1);
            if (activeRequests > 0) return;

            bar.style.width = '100%';
            hideTimeout = setTimeout(() => {
                bar.style.opacity = '0';
                setTimeout(() => { bar.style.width = '0%'; }, 200);
            }, 150);
        };

        // Menangkap SEMUA request Livewire: pagination, filter, sort,
        // search, approve/reject, dst — bukan cuma navigasi antar halaman.
        Livewire.hook('request', ({ start, succeed, fail }) => {
            start(() => showBar());
            succeed(() => hideBar());
            fail(() => hideBar());
        });
    });
</script>
