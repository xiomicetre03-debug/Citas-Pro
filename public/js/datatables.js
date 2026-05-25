(function () {
    function normalize(value) {
        return value.toString().toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, '');
    }

    function buildDataTable(table) {
        const originalRows = Array.from(table.querySelectorAll('tbody tr'));
        const tbody = table.querySelector('tbody');
        const wrapper = document.createElement('div');
        const toolbar = document.createElement('div');
        const search = document.createElement('input');
        const info = document.createElement('span');
        const pager = document.createElement('div');
        const prev = document.createElement('button');
        const next = document.createElement('button');
        const pageSize = Number(table.dataset.pageSize || 8);
        let page = 1;
        let sortIndex = -1;
        let sortDirection = 1;
        let rows = originalRows.slice();

        wrapper.className = 'datatable';
        toolbar.className = 'datatable-toolbar';
        search.className = 'datatable-search';
        search.type = 'search';
        search.placeholder = 'Buscar...';
        info.className = 'datatable-info';
        pager.className = 'datatable-pager';
        prev.className = 'btn small';
        next.className = 'btn small';
        prev.type = 'button';
        next.type = 'button';
        prev.textContent = 'Anterior';
        next.textContent = 'Siguiente';

        table.parentNode.insertBefore(wrapper, table);
        wrapper.appendChild(toolbar);
        toolbar.appendChild(search);
        toolbar.appendChild(info);
        wrapper.appendChild(table);
        wrapper.appendChild(pager);
        pager.appendChild(prev);
        pager.appendChild(next);

        table.querySelectorAll('thead th').forEach((th, index) => {
            th.classList.add('datatable-sortable');
            th.addEventListener('click', () => {
                sortDirection = sortIndex === index ? sortDirection * -1 : 1;
                sortIndex = index;
                page = 1;
                render();
            });
        });

        search.addEventListener('input', () => {
            page = 1;
            render();
        });

        prev.addEventListener('click', () => {
            page = Math.max(1, page - 1);
            render();
        });

        next.addEventListener('click', () => {
            page += 1;
            render();
        });

        function render() {
            const term = normalize(search.value);
            rows = originalRows.filter(row => normalize(row.textContent).includes(term));

            if (sortIndex >= 0) {
                rows.sort((a, b) => {
                    const aText = normalize(a.children[sortIndex]?.textContent || '');
                    const bText = normalize(b.children[sortIndex]?.textContent || '');
                    return aText.localeCompare(bText, 'es', { numeric: true }) * sortDirection;
                });
            }

            const pages = Math.max(1, Math.ceil(rows.length / pageSize));
            page = Math.min(page, pages);
            const start = (page - 1) * pageSize;
            const visibleRows = rows.slice(start, start + pageSize);

            tbody.replaceChildren(...visibleRows);
            info.textContent = `${rows.length} registros · pagina ${page} de ${pages}`;
            prev.disabled = page <= 1;
            next.disabled = page >= pages;
        }

        render();
    }

    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('table[data-datatable]').forEach(buildDataTable);
    });
})();