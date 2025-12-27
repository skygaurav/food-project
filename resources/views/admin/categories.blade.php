@extends('admin.layout')

@section('title','Categories')

@section('content')
    <h2 class="text-2xl font-semibold mb-2">Add / Manage Categories</h2>
    <p class="text-slate-600 mb-4">Create and manage categories for restaurants.</p>

    <form id="add-category" class="space-y-4">
        <div class="form-row">
            <div class="form-col">
                <label class="block text-sm font-medium mb-1">Name</label>
                <input name="name" class="rounded border border-slate-300 px-3 py-2 w-full" />
            </div>
            <div style="width:160px;display:flex;align-items:flex-end">
                <button type="submit" class="rounded border border-slate-500 px-4 py-2">Create</button>
            </div>
        </div>
        <div id="cat-msg" style="display:none;padding:.5rem;border-radius:6px"></div>
    </form>

    <hr class="my-4">
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
    div.innerHTML = `<div>${cat.name}</div><div style="display:flex;gap:.5rem"><button class="edit-cat" data-id="${cat.id||''}" data-name="${cat.name}">Edit</button><button class="del-cat" data-id="${cat.id||''}">Delete</button></div>`;
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

document.getElementById('add-category').addEventListener('submit', async function(e){
    e.preventDefault();
    const input = this.querySelector('[name="name"]');
    const name = input.value.trim();
    const msg = document.getElementById('cat-msg');
    if(!name){ msg.style.display='block'; msg.style.background='#fee'; msg.innerText='Name required'; return; }

    // optimistic add
    const tempId = 'temp-' + Date.now();
    const tempCat = {id: tempId, name};
    const el = document.getElementById('categories-list');
    const node = createCategoryElement(tempCat);
    el.insertBefore(node, el.firstChild);
    attachCategoryHandlers();
    input.value = '';

    try{
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const res = await fetch('/admin/api/categories', {method:'POST',credentials:'same-origin',headers:{'Content-Type':'application/json','X-CSRF-TOKEN': token},body:JSON.stringify({name})});
        if(!res.ok) throw new Error('create-failed');
        const created = await res.json();
        // replace temp node id and buttons
        node.dataset.id = created.id;
        node.querySelectorAll('button').forEach(b=>{ b.dataset.id = created.id; b.dataset.name = created.name; });
        msg.style.display='block'; msg.style.background='#efe'; msg.innerText='Created';
    }catch(err){
        // rollback
        node.remove();
        msg.style.display='block'; msg.style.background='#fee'; msg.innerText='Create failed';
    }
});

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

    document.querySelectorAll('.edit-cat').forEach(b=>{
        if(b._attached) return; b._attached = true;
        b.addEventListener('click', async ev=>{
            const id = ev.target.dataset.id; const current = ev.target.dataset.name||'';
            const newName = prompt('New name', current); if(newName===null) return;
            const container = ev.target.closest('.p-3');
            const nameNode = container.querySelector('div');
            const oldName = nameNode.innerText;
            // optimistic update
            nameNode.innerText = newName;
            try{
                const r = await fetch('/admin/api/categories/'+id,{method:'PUT',credentials:'same-origin',headers:{'Content-Type':'application/json','X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').getAttribute('content')},body:JSON.stringify({name:newName})});
                if(!r.ok) throw new Error('update-failed');
                const updated = await r.json();
                ev.target.dataset.name = updated.name;
            }catch(e){
                // rollback
                nameNode.innerText = oldName;
                alert('Update failed');
            }
        });
    });
}

loadCategories();
</script>
@endpush
