<script>
(function () {
    const searchInput    = document.getElementById('search-input');
    const searchClear    = document.getElementById('search-clear');
    const categoryFilter = document.getElementById('filter-category');
    const supplierFilter = document.getElementById('filter-supplier');
    const tableContainer = document.getElementById('table-container');
    const baseUrl = @json($baseUrl);
    let debounceTimer;

    function currentParams() {
        const params = new URLSearchParams();
        const search = searchInput ? searchInput.value.trim() : '';
        const category = categoryFilter ? categoryFilter.value : '';
        const supplier = supplierFilter ? supplierFilter.value : '';

        if (search) params.set('search', search);
        if (category) params.set('category_id', category);
        if (supplier) params.set('supplier_id', supplier);

        return params;
    }

    function fetchResults(pushState = true) {
        const params = currentParams();
        const query = params.toString();
        const url = query ? `${baseUrl}?${query}` : baseUrl;

        fetch(url, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(res => res.text())
        .then(html => {
            tableContainer.innerHTML = html;
            if (pushState) {
                window.history.replaceState({}, '', url);
            }
            if (searchClear) {
                searchClear.classList.toggle('hidden', !params.get('search'));
            }
        })
        .catch(() => {
            // gagal fetch, biarkan tabel lama tetap tampil
        });
    }

    if (searchInput) {
        searchInput.addEventListener('input', () => {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => fetchResults(), 400);
        });
    }

    if (searchClear) {
        searchClear.addEventListener('click', () => {
            searchInput.value = '';
            fetchResults();
        });
    }

    if (categoryFilter) {
        categoryFilter.addEventListener('change', () => fetchResults());
    }

    if (supplierFilter) {
        supplierFilter.addEventListener('change', () => fetchResults());
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