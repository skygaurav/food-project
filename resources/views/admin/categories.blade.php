@extends('admin.layout')

@section('title','Categories')

@section('content')
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem">
        <div>
            <h2 class="text-2xl font-semibold mb-2">Categories</h2>
            <p class="text-slate-600 mb-4">Manage categories for restaurants.</p>
        </div>
        <div>
            <a href="/admin/categories/create" class="rounded border border-slate-400 px-4 py-2">New Category</a>
        </div>
    </div>

    <div>
        <h3 class="font-semibold mb-2">Existing Categories</h3>
        <div id="categories-list">Loading...</div>
    </div>
@endsection

@push('scripts')
<script>
function createCategoryElement(cat){
    const div = document.createElement('div');
    div.className = 'p-3 mb-2 border rounded flex justify-between items-center';
    div.dataset.id = cat.id || '';
    const editLink = `<a class="rounded border px-2 py-1" href="/admin/categories/${cat.id||''}/edit">Edit</a>`;
    div.innerHTML = `<div>${cat.name}</div><div style="display:flex;gap:.5rem">${editLink}<button class="del-cat" data-id="${cat.id||''}">Delete</button></div>`;
    return div;
}

async function loadCategories(){
    const res = await fetch('/admin/api/categories', {credentials:'same-origin'});
    const data = res.ok? await res.json(): [];
    const el = document.getElementById('categories-list');
    el.innerHTML = '';
    if(!data.length){ el.innerHTML = '<p>No categories yet</p>'; return; }
    data.forEach(c=> el.appendChild(createCategoryElement(c)));
    attachCategoryHandlers();
}

// creation is handled on a separate page; only deletion handled here

function attachCategoryHandlers(){
    document.querySelectorAll('.del-cat').forEach(b=>{
        if(b._attached) return; b._attached = true;
        b.addEventListener('click', async ev=>{
            const id = ev.target.dataset.id;
            if(!id) return;
            const container = ev.target.closest('.p-3');
            // optimistic remove
            const removedNode = container; const parent = container.parentNode; parent.removeChild(container);
            try{
                const r = await fetch('/admin/api/categories/'+id,{method:'DELETE',credentials:'same-origin',headers:{'X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').getAttribute('content')}});
                if(!r.ok) throw new Error('delete-failed');
            }catch(e){
                // rollback
                parent.insertBefore(removedNode, parent.firstChild);
                alert('Delete failed');
            }
        });
    });
}

loadCategories();
</script>
@endpush
