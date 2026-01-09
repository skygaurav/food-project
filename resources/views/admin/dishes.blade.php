@extends('admin.layout')

@section('title','All Dishes')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">All Dishes</h1>
            <p class="page-subtitle">View and manage all dishes across restaurants</p>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="search-bar" style="margin-bottom: 0; flex: 1;">
                <div class="search-input-wrapper">
                    <input type="text" id="search-input" class="search-input" placeholder="Search by name, restaurant, comment...">
                </div>
                <select id="status-filter" class="form-control" style="width: auto; min-width: 150px;">
                    <option value="">All Statuses</option>
                    <option value="approved">Approved</option>
                    <option value="pending">Pending</option>
                    <option value="rejected">Rejected</option>
                </select>
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
                        <input type="checkbox" data-column="image" checked> Image
                    </label>
                    <label class="column-toggle-item">
                        <input type="checkbox" data-column="name" checked> Name
                    </label>
                    <label class="column-toggle-item">
                        <input type="checkbox" data-column="slug"> Slug
                    </label>
                    <label class="column-toggle-item">
                        <input type="checkbox" data-column="restaurant" checked> Restaurant
                    </label>
                    <label class="column-toggle-item">
                        <input type="checkbox" data-column="comment" checked> Comment
                    </label>
                    <label class="column-toggle-item">
                        <input type="checkbox" data-column="status" checked> Status
                    </label>
                    <label class="column-toggle-item">
                        <input type="checkbox" data-column="meal_cost"> Meal Cost
                    </label>
                    <label class="column-toggle-item">
                        <input type="checkbox" data-column="date_spot"> Date Spot
                    </label>
                    <label class="column-toggle-item">
                        <input type="checkbox" data-column="reservation"> Reservation
                    </label>
                    <label class="column-toggle-item">
                        <input type="checkbox" data-column="phone"> Phone
                    </label>
                    <label class="column-toggle-item">
                        <input type="checkbox" data-column="website"> Website
                    </label>
                    <label class="column-toggle-item">
                        <input type="checkbox" data-column="created_at"> Created At
                    </label>
                </div>
            </div>
        </div>
        
        <div class="data-grid">
            <table class="data-table" id="dishes-table">
                <thead>
                    <tr>
                        <th data-col="id" class="sortable" data-sort="id">ID</th>
                        <th data-col="image">Image</th>
                        <th data-col="name" class="sortable" data-sort="name">Name</th>
                        <th data-col="slug" class="hidden">Slug</th>
                        <th data-col="restaurant" class="sortable" data-sort="restaurant_name">Restaurant</th>
                        <th data-col="comment">Comment</th>
                        <th data-col="status" class="sortable" data-sort="status">Status</th>
                        <th data-col="meal_cost" class="hidden sortable" data-sort="meal_cost">Meal Cost</th>
                        <th data-col="date_spot" class="hidden">Date Spot</th>
                        <th data-col="reservation" class="hidden">Reservation</th>
                        <th data-col="phone" class="hidden">Phone</th>
                        <th data-col="website" class="hidden">Website</th>
                        <th data-col="created_at" class="hidden sortable" data-sort="created_at">Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="dishes-body">
                    <tr><td colspan="10" style="text-align: center; padding: 2rem;">Loading...</td></tr>
                </tbody>
            </table>
        </div>
        
        <div class="pagination">
            <div class="pagination-info" id="pagination-info">Showing 0 of 0 entries</div>
            <div class="pagination-controls" id="pagination-controls"></div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
const GRID_ID = 'dishes';
let allData = [];
let filteredData = [];
let currentPage = 1;
const perPage = 10;
let sortColumn = 'id';
let sortDir = 'desc';
let statusFilter = '';

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
document.getElementById('search-input').addEventListener('input', applyFilters);
document.getElementById('status-filter').addEventListener('change', (e) => {
    statusFilter = e.target.value;
    applyFilters();
});

function applyFilters() {
    const q = document.getElementById('search-input').value.toLowerCase();
    filteredData = allData.filter(d => {
        const matchesSearch = (
            (d.name && d.name.toLowerCase().includes(q)) ||
            (d.restaurant_name && d.restaurant_name.toLowerCase().includes(q)) ||
            (d.comment && d.comment.toLowerCase().includes(q))
        );
        const matchesStatus = !statusFilter || d.status === statusFilter;
        return matchesSearch && matchesStatus;
    });
    currentPage = 1;
    render();
}

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

function getStatusBadge(status) {
    if (status === 'approved') return '<span class="badge badge-success">Approved</span>';
    if (status === 'pending') return '<span class="badge badge-warning">Pending</span>';
    return '<span class="badge badge-danger">' + (status ? status.charAt(0).toUpperCase() + status.slice(1) : 'Unknown') + '</span>';
}

function render() {
    const tbody = document.getElementById('dishes-body');
    const start = (currentPage - 1) * perPage;
    const pageData = filteredData.slice(start, start + perPage);
    
    if (!pageData.length) {
        tbody.innerHTML = '<tr><td colspan="14" style="text-align: center; padding: 2rem;">No dishes found</td></tr>';
    } else {
        tbody.innerHTML = pageData.map(d => {
            const imgHtml = d.image_url 
                ? `<img src="${d.image_url}" alt="" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">`
                : `<div style="width: 50px; height: 50px; background: #f1f5f9; border-radius: 4px; display: flex; align-items: center; justify-content: center;"><svg class="icon icon-xl icon-muted"><use href="#icon-dish"></use></svg></div>`;
            
            return `
            <tr>
                <td data-col="id">${d.id}</td>
                <td data-col="image">${imgHtml}</td>
                <td data-col="name"><strong>${d.name}</strong></td>
                <td data-col="slug" class="hidden"><code style="font-size: 0.75rem;">${d.slug || '—'}</code></td>
                <td data-col="restaurant">
                    <a href="/admin/restaurants/${d.restaurant_id}/dishes" style="color: var(--primary);">${d.restaurant_name || '—'}</a>
                </td>
                <td data-col="comment" style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">${d.comment || '—'}</td>
                <td data-col="status">${getStatusBadge(d.status)}</td>
                <td data-col="meal_cost" class="hidden">${d.meal_cost ? '$' + parseFloat(d.meal_cost).toFixed(2) : '—'}</td>
                <td data-col="date_spot" class="hidden">${d.good_date_spot ? '<span class="badge badge-success">Yes</span>' : '<span class="text-muted">No</span>'}</td>
                <td data-col="reservation" class="hidden">${d.reservation ? '<span class="badge badge-success">Yes</span>' : '<span class="text-muted">No</span>'}</td>
                <td data-col="phone" class="hidden">${d.phone || '—'}</td>
                <td data-col="website" class="hidden">${d.website ? `<a href="${d.website}" target="_blank" style="color: var(--primary);">Link</a>` : '—'}</td>
                <td data-col="created_at" class="hidden">${formatDate(d.created_at)}</td>
                <td class="actions">
                    <a href="/admin/dishes/${d.id}" class="btn btn-secondary btn-sm">View</a>
                    ${d.status === 'pending' ? `
                        <button class="btn btn-success btn-sm" onclick="approveDish(${d.id})">Approve</button>
                        <button class="btn btn-danger btn-sm" onclick="rejectDish(${d.id})">Reject</button>
                    ` : `
                        <button class="btn btn-warning btn-sm" onclick="setPendingDish(${d.id})" title="Set to Pending">⏱ Pending</button>
                    `}
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

window.approveDish = async function(id) {
    try {
        await adminFetch('POST', `/admin/api/dishes/${id}/approve`);
        const dish = allData.find(d => d.id === id);
        if (dish) dish.status = 'approved';
        applyFilters();
    } catch (e) {
        alert('Failed to approve dish');
    }
};

window.rejectDish = async function(id) {
    const reason = prompt('Enter rejection reason (optional):');
    try {
        await adminFetch('POST', `/admin/api/dishes/${id}/disapprove`, { reason });
        const dish = allData.find(d => d.id === id);
        if (dish) dish.status = 'rejected';
        applyFilters();
    } catch (e) {
        alert('Failed to reject dish');
    }
};

window.setPendingDish = async function(id) {
    if (!confirm('Set this dish back to pending status?')) return;
    try {
        await adminFetch('POST', `/admin/api/dishes/${id}/set-pending`);
        const dish = allData.find(d => d.id === id);
        if (dish) dish.status = 'pending';
        applyFilters();
    } catch (e) {
        alert('Failed to update dish status');
    }
};

async function loadDishes() {
    try {
        const data = await adminFetch('GET', '/admin/api/dishes') || [];
        allData = data;
        filteredData = [...allData];
        sortData();
        render();
    } catch (e) {
        document.getElementById('dishes-body').innerHTML = 
            '<tr><td colspan="10" style="text-align: center; padding: 2rem; color: #ef4444;">Failed to load dishes</td></tr>';
    }
}

initColumnVisibility();
loadDishes();
</script>
@endpush
