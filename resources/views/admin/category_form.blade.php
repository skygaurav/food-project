@extends('admin.layout')

@section('title', isset($category) ? 'Edit Category' : 'New Category')

@section('content')
    <div class="breadcrumb">
        <a href="/admin">Dashboard</a>
        <span>›</span>
        <a href="/admin/categories">Categories</a>
        <span>›</span>
        <span>{{ isset($category) ? 'Edit' : 'New' }}</span>
    </div>

    <div class="page-header">
        <div>
            <h1 class="page-title">{{ isset($category) ? 'Edit Category' : 'Create New Category' }}</h1>
            <p class="page-subtitle">{{ isset($category) ? 'Update category details' : 'Add a new food category' }}</p>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form id="category-form">
                <input type="hidden" name="id" value="{{ $category->id ?? '' }}" />
                
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Name <span style="color: #ef4444;">*</span></label>
                        <input type="text" name="name" value="{{ $category->name ?? '' }}" class="form-control" placeholder="e.g., Italian, Mexican, Asian" required />
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Slug</label>
                        <input type="text" name="slug" value="{{ $category->slug ?? '' }}" class="form-control" placeholder="auto-generated from name" />
                        <small class="text-muted text-sm">Leave empty to auto-generate from name</small>
                    </div>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <span>💾</span> {{ isset($category) ? 'Update Category' : 'Create Category' }}
                    </button>
                    <a href="/admin/categories" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
const form = document.getElementById('category-form');

// Auto-generate slug from name
form.name.addEventListener('input', () => {
    if (!form.id.value && !form.slug.dataset.manual) {
        form.slug.value = form.name.value
            .toLowerCase()
            .replace(/[^a-z0-9]+/g, '-')
            .replace(/^-|-$/g, '');
    }
});

form.slug.addEventListener('input', () => {
    form.slug.dataset.manual = 'true';
});

form.addEventListener('submit', async e => {
    e.preventDefault();
    const id = form.id.value;
    const payload = {
        name: form.name.value.trim(),
        slug: form.slug.value.trim() || form.name.value.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '')
    };
    
    if (!payload.name) {
        alert('Name is required');
        return;
    }
    
    try {
        if (id) {
            await adminFetch('PUT', '/admin/api/categories/' + id, payload);
        } else {
            await adminFetch('POST', '/admin/api/categories', payload);
        }
        location.href = '/admin/categories';
    } catch (err) {
        alert('Save failed: ' + err.message);
    }
});
</script>
@endpush
