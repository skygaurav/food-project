@extends('admin.layout')

@section('title','Restaurants')

@section('content')
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem">
        <h2 class="text-2xl font-semibold">Restaurants</h2>
        <a href="/admin/restaurants" class="rounded border border-slate-400 px-4 py-2">Refresh</a>
    </div>

    <form id="add-restaurant" class="mb-4 form-row">
        <div class="form-col">
            <input name="name" placeholder="Name" class="rounded border border-slate-300 px-3 py-2 w-full" />
        </div>
        <div class="form-col">
            <input name="address" placeholder="Address" class="rounded border border-slate-300 px-3 py-2 w-full" />
        </div>
        <div style="width:140px">
            <button type="submit" class="rounded border border-slate-500 px-4 py-2">Create</button>
        </div>
    </form>

    <div id="restaurants-list">Loading...</div>

@endsection

@push('scripts')
<script>
function createRestaurantElement(r){
    const div = document.createElement('div');
    div.className = 'p-3 mb-2 border rounded flex justify-between items-center';
    div.dataset.id = r.id || '';
    div.innerHTML = `<div><div class="font-semibold">${r.name}</div><div class="text-sm text-slate-600">${r.address||'—'}</div></div><div style="display:flex;gap:.5rem"><button class="edit-restaurant" data-id="${r.id||''}" data-name="${r.name}">Edit</button><button class="del-restaurant" data-id="${r.id||''}">Delete</button></div>`;
    return div;
}

async function loadRestaurants(){
    const res = await fetch('/admin/api/restaurants', {credentials:'same-origin'});
    const data = res.ok? await res.json(): [];
    const el = document.getElementById('restaurants-list');
    el.innerHTML = '';
    if(!data.length){ el.innerHTML = '<p>No restaurants yet</p>'; return; }
    data.forEach(r=> el.appendChild(createRestaurantElement(r)));
    attachRestaurantHandlers();
}

document.getElementById('add-restaurant').addEventListener('submit', async function(e){
    e.preventDefault();
    const data = { name: this.name.value.trim(), address: this.address.value.trim() };
    if(!data.name){ alert('Name required'); return; }

    // optimistic add
    const tempId = 'temp-' + Date.now();
    const temp = {id: tempId, ...data};
    const el = document.getElementById('restaurants-list');
    const node = createRestaurantElement(temp);
    el.insertBefore(node, el.firstChild);
    attachRestaurantHandlers();
    this.reset();

    try{
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const res = await fetch('/admin/api/restaurants', {method:'POST',credentials:'same-origin',headers:{'Content-Type':'application/json','X-CSRF-TOKEN': token},body:JSON.stringify(data)});
        if(!res.ok) throw new Error('create-failed');
        const created = await res.json();
        node.dataset.id = created.id;
        node.querySelectorAll('button').forEach(b=>{ b.dataset.id = created.id; b.dataset.name = created.name; });
    }catch(e){ node.remove(); alert('Create failed'); }
});

function attachRestaurantHandlers(){
    document.querySelectorAll('.del-restaurant').forEach(b=>{
        if(b._attached) return; b._attached = true;
        b.addEventListener('click', async ev=>{
            const id = ev.target.dataset.id; if(!id) return; if(!confirm('Delete restaurant?')) return;
            const container = ev.target.closest('.p-3'); const parent = container.parentNode; parent.removeChild(container);
            try{
                const r = await fetch('/admin/api/restaurants/'+id,{method:'DELETE',credentials:'same-origin',headers:{'X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').getAttribute('content')}});
                if(!r.ok) throw new Error('delete-failed');
            }catch(err){ parent.insertBefore(container, parent.firstChild); alert('Delete failed'); }
        });
    });

    document.querySelectorAll('.edit-restaurant').forEach(b=>{
        if(b._attached) return; b._attached = true;
        b.addEventListener('click', async ev=>{
            const id = ev.target.dataset.id; const current = ev.target.dataset.name||''; const newName = prompt('Name', current); if(newName===null) return; const newAddress = prompt('Address');
            const container = ev.target.closest('.p-3'); const nameNode = container.querySelector('.font-semibold'); const oldName = nameNode.innerText; const addrNode = container.querySelector('.text-sm'); const oldAddr = addrNode.innerText;
            nameNode.innerText = newName; addrNode.innerText = newAddress||'—';
            try{
                const r = await fetch('/admin/api/restaurants/'+id,{method:'PUT',credentials:'same-origin',headers:{'Content-Type':'application/json','X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').getAttribute('content')},body:JSON.stringify({name:newName,address:newAddress})});
                if(!r.ok) throw new Error('update-failed');
                const updated = await r.json(); ev.target.dataset.name = updated.name;
            }catch(e){ nameNode.innerText = oldName; addrNode.innerText = oldAddr; alert('Update failed'); }
        });
    });
}

loadRestaurants();
</script>
@endpush
