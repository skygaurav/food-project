@extends('admin.layout')

@section('title', $page ? 'Edit Page' : 'Add Page')

@section('content')
    <nav class="breadcrumb">
        <a href="/admin/cms-pages">CMS Pages</a>
        <span>/</span>
        <span>{{ $page ? 'Edit Page' : 'Add Page' }}</span>
    </nav>

    <div class="page-header">
        <div>
            <h1 class="page-title">{{ $page ? 'Edit Page' : 'Add New Page' }}</h1>
            <p class="page-subtitle">{{ $page ? 'Update page content and settings' : 'Create a new static content page' }}</p>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form id="cms-form" class="form">
                <div class="form-row">
                    <div class="form-group" style="flex: 2;">
                        <label for="title" class="form-label">Page Title <span class="required">*</span></label>
                        <input type="text" id="title" name="title" class="form-control" 
                               value="{{ $page->title ?? '' }}" required placeholder="e.g. About Us, Privacy Policy">
                    </div>
                    <div class="form-group" style="flex: 1;">
                        <label for="slug" class="form-label">URL Slug</label>
                        <input type="text" id="slug" name="slug" class="form-control" 
                               value="{{ $page->slug ?? '' }}" placeholder="auto-generated if empty">
                        <small class="form-hint">Leave empty to auto-generate from title</small>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="content" class="form-label">Page Content</label>
                    <textarea id="content" name="content" class="form-control" rows="15" 
                              placeholder="Enter page content here. HTML is supported.">{{ $page->content ?? '' }}</textarea>
                    <small class="form-hint">You can use HTML tags for formatting</small>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="sort_order" class="form-label">Sort Order</label>
                        <input type="number" id="sort_order" name="sort_order" class="form-control" 
                               value="{{ $page->sort_order ?? 0 }}" min="0">
                        <small class="form-hint">Lower numbers appear first in footer</small>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Show in Footer</label>
                        <div class="toggle-group">
                            <label class="toggle-option">
                                <input type="radio" name="show_in_footer" value="1" 
                                       {{ ($page->show_in_footer ?? true) ? 'checked' : '' }}>
                                <span>Yes</span>
                            </label>
                            <label class="toggle-option">
                                <input type="radio" name="show_in_footer" value="0" 
                                       {{ isset($page) && !$page->show_in_footer ? 'checked' : '' }}>
                                <span>No</span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Status</label>
                        <div class="toggle-group">
                            <label class="toggle-option">
                                <input type="radio" name="is_active" value="1" 
                                       {{ ($page->is_active ?? true) ? 'checked' : '' }}>
                                <span>Active</span>
                            </label>
                            <label class="toggle-option">
                                <input type="radio" name="is_active" value="0" 
                                       {{ isset($page) && !$page->is_active ? 'checked' : '' }}>
                                <span>Inactive</span>
                            </label>
                        </div>
                    </div>
                </div>
                
                <div class="form-actions">
                    <a href="/admin/cms-pages" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">
                        <span>💾</span> {{ $page ? 'Update Page' : 'Create Page' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .form-hint {
        display: block;
        font-size: 0.75rem;
        color: #64748b;
        margin-top: 0.25rem;
    }
    
    .toggle-group {
        display: flex;
        gap: 1rem;
        padding-top: 0.5rem;
    }
    
    .toggle-option {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        cursor: pointer;
    }
    
    .toggle-option input {
        accent-color: var(--primary);
    }
    
    textarea.form-control {
        font-family: 'Monaco', 'Consolas', monospace;
        font-size: 0.875rem;
        line-height: 1.6;
    }
</style>
@endpush

@push('scripts')
<script>
const pageId = {{ $page->id ?? 'null' }};
const form = document.getElementById('cms-form');

// Auto-generate slug from title
document.getElementById('title').addEventListener('blur', function() {
    const slugField = document.getElementById('slug');
    if (!slugField.value && this.value) {
        slugField.value = this.value
            .toLowerCase()
            .replace(/[^a-z0-9]+/g, '-')
            .replace(/^-|-$/g, '');
    }
});

form.addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const submitBtn = form.querySelector('button[type="submit"]');
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span>⏳</span> Saving...';
    
    const data = {
        title: document.getElementById('title').value,
        slug: document.getElementById('slug').value,
        content: document.getElementById('content').value,
        sort_order: parseInt(document.getElementById('sort_order').value) || 0,
        show_in_footer: document.querySelector('input[name="show_in_footer"]:checked').value === '1',
        is_active: document.querySelector('input[name="is_active"]:checked').value === '1',
    };
    
    try {
        if (pageId) {
            await adminFetch('PUT', `/admin/api/cms-pages/${pageId}`, data);
        } else {
            await adminFetch('POST', '/admin/api/cms-pages', data);
        }
        window.location.href = '/admin/cms-pages';
    } catch (err) {
        alert('Error saving page: ' + (err.message || 'Unknown error'));
        submitBtn.disabled = false;
        submitBtn.innerHTML = '<span>💾</span> {{ $page ? "Update Page" : "Create Page" }}';
    }
});
</script>
@endpush
