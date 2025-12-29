<?php $__env->startSection('title','CMS Pages'); ?>

<?php $__env->startSection('content'); ?>
    <div class="page-header">
        <div>
            <h1 class="page-title">CMS Pages</h1>
            <p class="page-subtitle">Manage static content pages (About, Privacy, Terms, etc.)</p>
        </div>
        <a href="/admin/cms-pages/create" class="btn btn-primary">
            <span>+</span> Add Page
        </a>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="search-bar" style="margin-bottom: 0; flex: 1;">
                <div class="search-input-wrapper">
                    <input type="text" id="search-input" class="search-input" placeholder="Search by title or slug...">
                </div>
            </div>
            <div class="column-toggle">
                <button class="btn btn-secondary btn-sm" id="column-toggle-btn">
                    <svg class="icon icon-sm"><use href="#icon-info"></use></svg> Columns
                </button>
                <div class="column-toggle-menu" id="column-menu">
                    <label class="column-toggle-item">
                        <input type="checkbox" data-column="id" checked> ID
                    </label>
                    <label class="column-toggle-item">
                        <input type="checkbox" data-column="title" checked> Title
                    </label>
                    <label class="column-toggle-item">
                        <input type="checkbox" data-column="slug" checked> Slug
                    </label>
                    <label class="column-toggle-item">
                        <input type="checkbox" data-column="footer" checked> In Footer
                    </label>
                    <label class="column-toggle-item">
                        <input type="checkbox" data-column="status" checked> Status
                    </label>
                    <label class="column-toggle-item">
                        <input type="checkbox" data-column="sort_order"> Sort Order
                    </label>
                    <label class="column-toggle-item">
                        <input type="checkbox" data-column="created_at"> Created At
                    </label>
                </div>
            </div>
        </div>
        
        <div class="data-grid">
            <table class="data-table" id="cms-table">
                <thead>
                    <tr>
                        <th data-col="id" class="sortable" data-sort="id">ID</th>
                        <th data-col="title" class="sortable" data-sort="title">Title</th>
                        <th data-col="slug" class="sortable" data-sort="slug">Slug</th>
                        <th data-col="footer">In Footer</th>
                        <th data-col="status">Status</th>
                        <th data-col="sort_order" class="hidden" class="sortable" data-sort="sort_order">Sort Order</th>
                        <th data-col="created_at" class="hidden" class="sortable" data-sort="created_at">Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="cms-body">
                    <tr><td colspan="8" style="text-align: center; padding: 2rem;">Loading...</td></tr>
                </tbody>
            </table>
        </div>
        
        <div class="pagination">
            <div class="pagination-info" id="pagination-info">Showing 0 of 0 entries</div>
            <div class="pagination-controls" id="pagination-controls"></div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
const GRID_ID = 'cms_pages';
let allData = [];
let filteredData = [];
let currentPage = 1;
const perPage = 10;
let sortColumn = 'sort_order';
let sortDir = 'asc';

// Column visibility
function initColumnVisibility() {
    const saved = columnManager.get(GRID_ID);
    document.querySelectorAll('#column-menu input[data-column]').forEach(cb => {
        const col = cb.dataset.column;
        if (saved[col] !== undefined) {
            cb.checked = saved[col];
        }
        updateColumnVisibility(col, cb.checked);
        
        cb.addEventListener('change', () => {
            columnManager.toggle(GRID_ID, col, cb.checked);
            updateColumnVisibility(col, cb.checked);
        });
    });
}

function updateColumnVisibility(col, visible) {
    document.querySelectorAll(`[data-col="${col}"]`).forEach(el => {
        el.classList.toggle('hidden', !visible);
    });
}

// Toggle menu
document.getElementById('column-toggle-btn').addEventListener('click', (e) => {
    e.stopPropagation();
    document.getElementById('column-menu').classList.toggle('show');
});
document.addEventListener('click', () => {
    document.getElementById('column-menu').classList.remove('show');
});

// Search
document.getElementById('search-input').addEventListener('input', (e) => {
    const q = e.target.value.toLowerCase();
    filteredData = allData.filter(p => 
        (p.title && p.title.toLowerCase().includes(q)) ||
        (p.slug && p.slug.toLowerCase().includes(q))
    );
    currentPage = 1;
    render();
});

// Sorting
document.querySelectorAll('.sortable').forEach(th => {
    th.addEventListener('click', () => {
        const col = th.dataset.sort;
        if (sortColumn === col) {
            sortDir = sortDir === 'asc' ? 'desc' : 'asc';
        } else {
            sortColumn = col;
            sortDir = 'asc';
        }
        sortData();
        render();
    });
});

function sortData() {
    filteredData.sort((a, b) => {
        let aVal = a[sortColumn] || '';
        let bVal = b[sortColumn] || '';
        if (typeof aVal === 'string') aVal = aVal.toLowerCase();
        if (typeof bVal === 'string') bVal = bVal.toLowerCase();
        if (aVal < bVal) return sortDir === 'asc' ? -1 : 1;
        if (aVal > bVal) return sortDir === 'asc' ? 1 : -1;
        return 0;
    });
}

function formatDate(dateStr) {
    if (!dateStr) return '—';
    return new Date(dateStr).toLocaleDateString('en-US', {
        year: 'numeric', month: 'short', day: 'numeric'
    });
}

function render() {
    const tbody = document.getElementById('cms-body');
    const start = (currentPage - 1) * perPage;
    const pageData = filteredData.slice(start, start + perPage);
    
    if (!pageData.length) {
        tbody.innerHTML = '<tr><td colspan="8" style="text-align: center; padding: 2rem;">No pages found</td></tr>';
    } else {
        tbody.innerHTML = pageData.map(p => `
            <tr>
                <td data-col="id">${p.id}</td>
                <td data-col="title"><strong>${p.title}</strong></td>
                <td data-col="slug"><code style="background: #f1f5f9; padding: 2px 6px; border-radius: 4px;">/page/${p.slug}</code></td>
                <td data-col="footer">
                    ${p.show_in_footer 
                        ? '<span style="color: #10b981;"><svg class="icon icon-sm"><use href="#icon-check"></use></svg> Yes</span>' 
                        : '<span style="color: #94a3b8;">No</span>'}
                </td>
                <td data-col="status">
                    ${p.is_active 
                        ? '<span class="badge badge-success">Active</span>' 
                        : '<span class="badge badge-secondary">Inactive</span>'}
                </td>
                <td data-col="sort_order" class="hidden">${p.sort_order}</td>
                <td data-col="created_at" class="hidden">${formatDate(p.created_at)}</td>
                <td class="actions">
                    <a href="/page/${p.slug}" target="_blank" class="btn btn-secondary btn-sm" title="View">👁</a>
                    <a href="/admin/cms-pages/${p.id}/edit" class="btn btn-secondary btn-sm">Edit</a>
                    <button class="btn btn-danger btn-sm" onclick="deletePage(${p.id})">Delete</button>
                </td>
            </tr>
        `).join('');
    }
    
    // Re-apply column visibility
    const saved = columnManager.get(GRID_ID);
    Object.keys(saved).forEach(col => updateColumnVisibility(col, saved[col]));
    
    // Pagination info
    document.getElementById('pagination-info').textContent = 
        `Showing ${filteredData.length ? start + 1 : 0}-${Math.min(start + perPage, filteredData.length)} of ${filteredData.length} entries`;
    
    // Pagination controls
    const totalPages = Math.ceil(filteredData.length / perPage);
    let paginationHtml = '';
    paginationHtml += `<button class="pagination-btn" ${currentPage === 1 ? 'disabled' : ''} onclick="goToPage(${currentPage - 1})">←</button>`;
    for (let i = 1; i <= totalPages; i++) {
        paginationHtml += `<button class="pagination-btn ${i === currentPage ? 'active' : ''}" onclick="goToPage(${i})">${i}</button>`;
    }
    paginationHtml += `<button class="pagination-btn" ${currentPage === totalPages || totalPages === 0 ? 'disabled' : ''} onclick="goToPage(${currentPage + 1})">→</button>`;
    document.getElementById('pagination-controls').innerHTML = paginationHtml;
}

window.goToPage = function(page) {
    currentPage = page;
    render();
};

window.deletePage = async function(id) {
    if (!confirm('Are you sure you want to delete this page?')) return;
    try {
        await adminFetch('DELETE', `/admin/api/cms-pages/${id}`);
        allData = allData.filter(p => p.id !== id);
        filteredData = filteredData.filter(p => p.id !== id);
        render();
    } catch (e) {
        alert('Failed to delete page');
    }
};

async function loadPages() {
    try {
        allData = await adminFetch('GET', '/admin/api/cms-pages') || [];
        filteredData = [...allData];
        sortData();
        render();
    } catch (e) {
        document.getElementById('cms-body').innerHTML = 
            '<tr><td colspan="8" style="text-align: center; padding: 2rem; color: #ef4444;">Failed to load pages</td></tr>';
    }
}

initColumnVisibility();
loadPages();
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/cms_pages.blade.php ENDPATH**/ ?>