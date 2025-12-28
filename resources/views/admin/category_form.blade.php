@extends('admin.layout')

@section('title', isset($category) ? 'Edit Category' : 'New Category')

@section('content')
    <h2 class="text-2xl font-semibold mb-4">{{ isset($category) ? 'Edit' : 'Create' }} Category</h2>

    <form id="category-form" class="space-y-4">
        <input type="hidden" name="id" value="{{ $category->id ?? '' }}" />
        <label class="block">
            <div class="text-sm font-medium">Name</div>
            <input name="name" value="{{ $category->name ?? '' }}" class="rounded border px-3 py-2 w-full" />
        </label>
        <div>
            <button type="submit" class="rounded border px-4 py-2">Save</button>
            <a href="/admin/categories" class="ml-2">Cancel</a>
        </div>
    </form>
@endsection

@push('scripts')
<script>
const form = document.getElementById('category-form');
form.addEventListener('submit', async e=>{
    e.preventDefault();
    const id = form.id.value;
    const payload = { name: form.name.value.trim() };
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    try{
        if(id){
            await fetch('/admin/api/categories/'+id, {method:'PUT', credentials:'same-origin', headers:{'Content-Type':'application/json','X-CSRF-TOKEN':token}, body:JSON.stringify(payload)});
        } else {
            await fetch('/admin/api/categories', {method:'POST', credentials:'same-origin', headers:{'Content-Type':'application/json','X-CSRF-TOKEN':token}, body:JSON.stringify(payload)});
        }
        location.href = '/admin/categories';
    }catch(err){ alert('Save failed'); }
});
</script>
@endpush
