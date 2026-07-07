<script>
(function () {
    const searchInput   = document.getElementById('search-input');
    const searchClear   = document.getElementById('search-clear');
    const tableContainer = document.getElementById('table-container');
    const baseUrl = @json($baseUrl);
    let debounceTimer;

    function fetchResults(query, pushState = true) {
        const url = query ? `${baseUrl}?search=${encodeURIComponent(query)}` : baseUrl;

        fetch(url, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(res => res.text())
        .then(html => {
            tableContainer.innerHTML = html;
            if (pushState) {
                window.history.replaceState({}, '', url);
            }
            searchClear.classList.toggle('hidden', !query);
        })
        .catch(() => {
            // gagal fetch, biarkan tabel lama tetap tampil
        });
    }

    if (searchInput) {
        searchInput.addEventListener('input', () => {
            clearTimeout(debounceTimer);
            const query = searchInput.value.trim();
            debounceTimer = setTimeout(() => fetchResults(query), 400);
        });
    }

    if (searchClear) {
        searchClear.addEventListener('click', () => {
            searchInput.value = '';
            fetchResults('');
        });
    }

    // Tangani klik pagination link di dalam hasil AJAX
    document.addEventListener('click', function (e) {
        const link = e.target.closest('#table-container a[href*="page="]');
        if (!link) return;
        e.preventDefault();

        fetch(link.href, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(res => res.text())
            .then(html => {
                tableContainer.innerHTML = html;
                window.history.replaceState({}, '', link.href);
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
    });
})();
</script>