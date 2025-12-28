<?php $__env->startSection('title','Restaurants'); ?>

<?php $__env->startSection('content'); ?>
    <div class="page-header">
        <div>
            <h1 class="page-title">Restaurants</h1>
            <p class="page-subtitle">Manage restaurants and their details</p>
        </div>
        <a href="/admin/restaurants/create" class="btn btn-primary">
            <span>+</span> Add Restaurant
        </a>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="search-bar" style="margin-bottom: 0; flex: 1;">
                <div class="search-input-wrapper">
                    <input type="text" id="search-input" class="search-input" placeholder="Search by name, address, city, region...">
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
                        <input type="checkbox" data-column="address" checked> Address
                    </label>
                    <label class="column-toggle-item">
                        <input type="checkbox" data-column="city" checked> City
                    </label>
                    <label class="column-toggle-item">
                        <input type="checkbox" data-column="region"> Region
                    </label>
                    <label class="column-toggle-item">
                        <input type="checkbox" data-column="country"> Country
                    </label>
                    <label class="column-toggle-item">
                        <input type="checkbox" data-column="postcode"> Postcode
                    </label>
                    <label class="column-toggle-item">
                        <input type="checkbox" data-column="website"> Website
                    </label>
                    <label class="column-toggle-item">
                        <input type="checkbox" data-column="opening_hours"> Opening Hours
                    </label>
                    <label class="column-toggle-item">
                        <input type="checkbox" data-column="categories" checked> Categories
                    </label>
                    <label class="column-toggle-item">
                        <input type="checkbox" data-column="created_at"> Created At
                    </label>
                </div>
            </div>
        </div>
        
        <div class="data-grid">
            <table class="data-table" id="restaurants-table">
                <thead>
                    <tr>
                        <th data-col="id" class="sortable" data-sort="id">ID</th>
                        <th data-col="name" class="sortable" data-sort="name">Name</th>
                        <th data-col="address" class="sortable" data-sort="address">Address</th>
                        <th data-col="city" class="sortable" data-sort="city">City</th>
                        <th data-col="region" class="hidden sortable" data-sort="region">Region</th>
                        <th data-col="country" class="hidden sortable" data-sort="country">Country</th>
                        <th data-col="postcode" class="hidden sortable" data-sort="postcode">Postcode</th>
                        <th data-col="website" class="hidden">Website</th>
                        <th data-col="opening_hours" class="hidden">Hours</th>
                        <th data-col="categories">Categories</th>
                        <th data-col="created_at" class="hidden sortable" data-sort="created_at">Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="restaurants-body">
                    <tr><td colspan="12" style="text-align: center; padding: 2rem;">Loading...</td></tr>
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
const GRID_ID = 'restaurants';
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
    filteredData = allData.filter(r => 
        (r.name && r.name.toLowerCase().includes(q)) ||
        (r.address && r.address.toLowerCase().includes(q)) ||
        (r.city && r.city.toLowerCase().includes(q)) ||
        (r.region && r.region.toLowerCase().includes(q)) ||
        (r.country && r.country.toLowerCase().includes(q)) ||
        (r.postcode && r.postcode.toLowerCase().includes(q))
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
    const tbody = document.getElementById('restaurants-body');
    const start = (currentPage - 1) * perPage;
    const pageData = filteredData.slice(start, start + perPage);
    
    if (!pageData.length) {
        tbody.innerHTML = '<tr><td colspan="12" style="text-align: center; padding: 2rem;">No restaurants found</td></tr>';
    } else {
        tbody.innerHTML = pageData.map(r => {
            const cats = (r.categories || []).map(c => 
                `<span class="badge badge-info">${c.name}</span>`
            ).join(' ');
            
            return `
            <tr>
                <td data-col="id">${r.id}</td>
                <td data-col="name"><strong>${r.name}</strong></td>
                <td data-col="address">${r.address || '—'}</td>
                <td data-col="city">${r.city || '—'}</td>
                <td data-col="region" class="hidden">${r.region || '—'}</td>
                <td data-col="country" class="hidden">${r.country || '—'}</td>
                <td data-col="postcode" class="hidden">${r.postcode || '—'}</td>
                <td data-col="website" class="hidden">${r.website ? `<a href="${r.website}" target="_blank" style="color: var(--primary);">Visit</a>` : '—'}</td>
                <td data-col="opening_hours" class="hidden">${r.opening_hours || '—'}</td>
                <td data-col="categories">${cats || '<span class="text-muted">None</span>'}</td>
                <td data-col="created_at" class="hidden">${formatDate(r.created_at)}</td>
                <td class="actions">
                    <a href="/admin/restaurants/${r.id}/edit" class="btn btn-secondary btn-sm">Edit</a>
                    <a href="/admin/restaurants/${r.id}/dishes" class="btn btn-secondary btn-sm">Dishes</a>
                    <button class="btn btn-danger btn-sm" onclick="deleteRestaurant(${r.id})">Delete</button>
                </td>
            </tr>
        `}).join('');
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
    for (let i = 1; i <= Math.min(totalPages, 5); i++) {
        paginationHtml += `<button class="pagination-btn ${i === currentPage ? 'active' : ''}" onclick="goToPage(${i})">${i}</button>`;
    }
    if (totalPages > 5) {
        paginationHtml += '<span style="padding: 0 0.5rem;">...</span>';
        paginationHtml += `<button class="pagination-btn ${totalPages === currentPage ? 'active' : ''}" onclick="goToPage(${totalPages})">${totalPages}</button>`;
    }
    paginationHtml += `<button class="pagination-btn" ${currentPage === totalPages || totalPages === 0 ? 'disabled' : ''} onclick="goToPage(${currentPage + 1})">→</button>`;
    document.getElementById('pagination-controls').innerHTML = paginationHtml;
}

window.goToPage = function(page) {
    currentPage = page;
    render();
};

window.deleteRestaurant = async function(id) {
    if (!confirm('Are you sure you want to delete this restaurant? This will also delete all associated dishes.')) return;
    try {
        await adminFetch('DELETE', `/admin/api/restaurants/${id}`);
        allData = allData.filter(r => r.id !== id);
        filteredData = filteredData.filter(r => r.id !== id);
        render();
    } catch (e) {
        alert('Failed to delete restaurant');
    }
};

async function loadRestaurants() {
    try {
        allData = await adminFetch('GET', '/admin/api/restaurants') || [];
        filteredData = [...allData];
        sortData();
        render();
    } catch (e) {
        document.getElementById('restaurants-body').innerHTML = 
            '<tr><td colspan="12" style="text-align: center; padding: 2rem; color: #ef4444;">Failed to load restaurants</td></tr>';
    }
}

initColumnVisibility();
loadRestaurants();
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/restaurants.blade.php ENDPATH**/ ?>