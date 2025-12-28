<?php $__env->startSection('title','Categories'); ?>

<?php $__env->startSection('content'); ?>
    <div class="page-header">
        <div>
            <h1 class="page-title">Categories</h1>
            <p class="page-subtitle">Manage food categories for restaurants</p>
        </div>
        <a href="/admin/categories/create" class="btn btn-primary">
            <span>+</span> Add Category
        </a>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="search-bar" style="margin-bottom: 0; flex: 1;">
                <div class="search-input-wrapper">
                    <input type="text" id="search-input" class="search-input" placeholder="Search by name or slug...">
                </div>
            </div>
            <div class="column-toggle">
                <button class="btn btn-secondary btn-sm" id="column-toggle-btn">
                    <span>⚙️</span> Columns
                </button>
                <div class="column-toggle-menu" id="column-menu">
                    <label class="column-toggle-item">
                        <input type="checkbox" data-column="id" checked> ID
                    </label>
                    <label class="column-toggle-item">
                        <input type="checkbox" data-column="name" checked> Name
                    </label>
                    <label class="column-toggle-item">
                        <input type="checkbox" data-column="slug" checked> Slug
                    </label>
                    <label class="column-toggle-item">
                        <input type="checkbox" data-column="created_at" checked> Created At
                    </label>
                    <label class="column-toggle-item">
                        <input type="checkbox" data-column="updated_at"> Updated At
                    </label>
                </div>
            </div>
        </div>
        
        <div class="data-grid">
            <table class="data-table" id="categories-table">
                <thead>
                    <tr>
                        <th data-col="id" class="sortable" data-sort="id">ID</th>
                        <th data-col="name" class="sortable" data-sort="name">Name</th>
                        <th data-col="slug" class="sortable" data-sort="slug">Slug</th>
                        <th data-col="created_at" class="sortable" data-sort="created_at">Created At</th>
                        <th data-col="updated_at" class="hidden" class="sortable" data-sort="updated_at">Updated At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="categories-body">
                    <tr><td colspan="6" style="text-align: center; padding: 2rem;">Loading...</td></tr>
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
const GRID_ID = 'categories';
let allData = [];
let filteredData = [];
let currentPage = 1;
const perPage = 10;
let sortColumn = 'name';
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
    filteredData = allData.filter(c => 
        (c.name && c.name.toLowerCase().includes(q)) ||
        (c.slug && c.slug.toLowerCase().includes(q))
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
    const tbody = document.getElementById('categories-body');
    const start = (currentPage - 1) * perPage;
    const pageData = filteredData.slice(start, start + perPage);
    
    if (!pageData.length) {
        tbody.innerHTML = '<tr><td colspan="6" style="text-align: center; padding: 2rem;">No categories found</td></tr>';
    } else {
        tbody.innerHTML = pageData.map(c => `
            <tr>
                <td data-col="id">${c.id}</td>
                <td data-col="name"><strong>${c.name}</strong></td>
                <td data-col="slug"><code style="background: #f1f5f9; padding: 2px 6px; border-radius: 4px;">${c.slug || '—'}</code></td>
                <td data-col="created_at">${formatDate(c.created_at)}</td>
                <td data-col="updated_at" class="hidden">${formatDate(c.updated_at)}</td>
                <td class="actions">
                    <a href="/admin/categories/${c.id}/edit" class="btn btn-secondary btn-sm">Edit</a>
                    <button class="btn btn-danger btn-sm" onclick="deleteCategory(${c.id})">Delete</button>
                </td>
            </tr>
        `).join('');
    }
    
    // Re-apply column visibility
    const saved = columnManager.get(GRID_ID);
    Object.keys(saved).forEach(col => updateColumnVisibility(col, saved[col]));
    
    // Pagination info
    document.getElementById('pagination-info').textContent = 
        `Showing ${start + 1}-${Math.min(start + perPage, filteredData.length)} of ${filteredData.length} entries`;
    
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

window.deleteCategory = async function(id) {
    if (!confirm('Are you sure you want to delete this category?')) return;
    try {
        await adminFetch('DELETE', `/admin/api/categories/${id}`);
        allData = allData.filter(c => c.id !== id);
        filteredData = filteredData.filter(c => c.id !== id);
        render();
    } catch (e) {
        alert('Failed to delete category');
    }
};

async function loadCategories() {
    try {
        allData = await adminFetch('GET', '/admin/api/categories') || [];
        filteredData = [...allData];
        sortData();
        render();
    } catch (e) {
        document.getElementById('categories-body').innerHTML = 
            '<tr><td colspan="6" style="text-align: center; padding: 2rem; color: #ef4444;">Failed to load categories</td></tr>';
    }
}

initColumnVisibility();
loadCategories();
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/categories.blade.php ENDPATH**/ ?>