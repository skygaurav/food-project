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
                    <textarea id="content" name="content" class="form-control tinymce-editor" rows="15" 
                              placeholder="Enter page content here.">{{ $page->content ?? '' }}</textarea>
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
                
                <h3 style="font-size: 1rem; font-weight: 600; margin: 1.5rem 0 1rem; color: #475569; border-top: 1px solid #e2e8f0; padding-top: 1.5rem;">
                    <svg class="icon icon-sm" style="margin-right: 0.5rem;"><use href="#icon-search"></use></svg>
                    SEO Settings (Optional)
                </h3>
                <p class="form-hint" style="margin-bottom: 1rem;">Leave empty to use default site SEO settings.</p>
                
                <div class="form-group">
                    <label for="meta_title" class="form-label">Meta Title</label>
                    <input type="text" id="meta_title" name="meta_title" class="form-control" 
                           value="{{ $page->meta_title ?? '' }}" placeholder="Page-specific title for search engines">
                    <small class="form-hint">Recommended: 50-60 characters</small>
                </div>
                
                <div class="form-group">
                    <label for="meta_description" class="form-label">Meta Description</label>
                    <textarea id="meta_description" name="meta_description" class="form-control" rows="2" 
                              placeholder="Brief description for search engine results">{{ $page->meta_description ?? '' }}</textarea>
                    <small class="form-hint">Recommended: 150-160 characters</small>
                </div>
                
                <div class="form-group">
                    <label for="meta_keywords" class="form-label">Meta Keywords</label>
                    <input type="text" id="meta_keywords" name="meta_keywords" class="form-control" 
                           value="{{ $page->meta_keywords ?? '' }}" placeholder="keyword1, keyword2, keyword3">
                    <small class="form-hint">Comma-separated keywords</small>
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
    
    /* TinyMCE container styling */
    .tox-tinymce {
        border-radius: 8px !important;
        border: 1px solid #e2e8f0 !important;
    }
    
    .tox .tox-toolbar__primary {
        background-color: #f8fafc !important;
    }
</style>
@endpush

@push('scripts')
<!-- TinyMCE CDN -->
<script src="https://cdn.tiny.cloud/1/rxsdvv03vcxqh4km0pvu0sdyvvd7s1acmiw4zznzm3j95h02/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
// Initialize TinyMCE
tinymce.init({
    selector: '.tinymce-editor',
    height: 400,
    menubar: true,
    plugins: [
        'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
        'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
        'insertdatetime', 'media', 'table', 'help', 'wordcount'
    ],
    toolbar: 'undo redo | blocks | ' +
        'bold italic forecolor backcolor | alignleft aligncenter ' +
        'alignright alignjustify | bullist numlist outdent indent | ' +
        'link image media | table | removeformat code | help',
    content_style: 'body { font-family: Inter, -apple-system, BlinkMacSystemFont, sans-serif; font-size: 14px; line-height: 1.6; }',
    branding: false,
    promotion: false,
    license_key: 'gpl',
    setup: function(editor) {
        editor.on('change', function() {
            tinymce.triggerSave();
        });
    }
});

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
    
    // Ensure TinyMCE content is synced to textarea
    tinymce.triggerSave();
    
    const submitBtn = form.querySelector('button[type="submit"]');
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<svg class="icon icon-spin"><use href="#icon-loader"></use></svg> Saving...';
    
    const data = {
        title: document.getElementById('title').value,
        slug: document.getElementById('slug').value,
        content: tinymce.get('content').getContent(),
        sort_order: parseInt(document.getElementById('sort_order').value) || 0,
        show_in_footer: document.querySelector('input[name="show_in_footer"]:checked').value === '1',
        is_active: document.querySelector('input[name="is_active"]:checked').value === '1',
        meta_title: document.getElementById('meta_title').value.trim() || null,
        meta_description: document.getElementById('meta_description').value.trim() || null,
        meta_keywords: document.getElementById('meta_keywords').value.trim() || null,
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
