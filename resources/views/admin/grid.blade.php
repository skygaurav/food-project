@extends('admin.layout')

@section('title','Overview')

@section('content')
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem">
        <h2 class="text-2xl font-semibold">Overview</h2>
        <div>
            <a href="/admin/restaurants" class="rounded border border-slate-400 px-4 py-2 mr-2">New Restaurant</a>
            <a href="/admin/categories" class="rounded border border-slate-400 px-4 py-2">New Category</a>
        </div>
    </div>

    <div class="form-row" style="align-items:flex-start">
        <div class="form-col">
            <h3 class="font-semibold mb-2">Restaurants ({{ $restaurants->count() }})</h3>
            <div>
                @forelse($restaurants as $r)
                    <div class="p-3 mb-2 border rounded flex justify-between items-center">
                        <div>
                            <div class="font-semibold">{{ $r->name }}</div>
                            <div class="text-sm text-slate-600">{{ $r->address ?? '—' }}</div>
                            <div class="text-xs text-slate-500">Categories: {{ $r->categories->pluck('name')->join(', ') }}</div>
                        </div>
                        <div style="display:flex;gap:.5rem">
                            <button class="edit-restaurant" data-id="{{ $r->id }}">Edit</button>
                            <button class="del-restaurant" data-id="{{ $r->id }}">Delete</button>
                        </div>
                    </div>
                @empty
                    <div class="p-3">No restaurants yet</div>
                @endforelse
            </div>
        </div>

        <div class="form-col">
            <h3 class="font-semibold mb-2">Categories ({{ $categories->count() }})</h3>
            <div>
                @forelse($categories as $c)
                    <div class="p-3 mb-2 border rounded flex justify-between items-center">
                        <div>{{ $c->name }}</div>
                        <div style="display:flex;gap:.5rem">
                            <button class="edit-category" data-id="{{ $c->id }}">Edit</button>
                            <button class="del-category" data-id="{{ $c->id }}">Delete</button>
                        </div>
                    </div>
                @empty
                    <div class="p-3">No categories yet</div>
                @endforelse
            </div>
        </div>

        <div style="width:360px">
            <h3 class="font-semibold mb-2">Pending Dishes ({{ $pendingDishes->count() }})</h3>
            <div>
                @forelse($pendingDishes as $d)
                    <div class="p-3 mb-2 border rounded">
                        <div class="font-semibold">{{ $d->name }}</div>
                        <div class="text-sm text-slate-600">By: {{ $d->restaurant->name ?? '—' }}</div>
                        <div class="mt-2" style="display:flex;gap:.5rem">
                            <button class="approve-dish" data-id="{{ $d->id }}">Approve</button>
                            <button class="disapprove-dish" data-id="{{ $d->id }}">Disapprove</button>
                        </div>
                    </div>
                @empty
                    <div class="p-3">No pending dishes</div>
                @endforelse
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

async function api(method, url, body){
    const opts = {method, credentials:'same-origin', headers:{'X-CSRF-TOKEN':token}};
    if(body){ opts.headers['Content-Type']='application/json'; opts.body = JSON.stringify(body); }
    const res = await fetch(url, opts);
    if(!res.ok) throw new Error('Request failed');
    return res.json().catch(()=>null);
}

function findHeader(name){
    return Array.from(document.querySelectorAll('h3')).find(h=>h.innerText.trim().toLowerCase().startsWith(name.toLowerCase()));
}

function setCount(headerEl, count){
    const base = headerEl.innerText.replace(/\s*\(.+\)\s*$/,'');
    headerEl.innerText = `${base} (${count})`;
}

function attachGridHandlers(){
    // categories
    document.querySelectorAll('.del-category').forEach(b=>{
        if(b._attached) return; b._attached = true;
        b.addEventListener('click', async e=>{
            if(!confirm('Delete category?')) return; const id = e.target.dataset.id; const node = e.target.closest('.p-3'); const parent = node.parentNode; parent.removeChild(node);
            const header = findHeader('Categories'); setCount(header, parent.querySelectorAll('.p-3').length);
            try{ await api('DELETE','/admin/api/categories/'+id); }catch(err){ parent.insertBefore(node, parent.firstChild); setCount(header, parent.querySelectorAll('.p-3').length); alert('Delete failed'); }
        });
    });

    document.querySelectorAll('.edit-category').forEach(b=>{
        if(b._attached) return; b._attached = true;
        b.addEventListener('click', async e=>{
            const id = e.target.dataset.id; const current = e.target.closest('.p-3').querySelector('div').innerText; const name = prompt('New name', current); if(name===null) return; const node = e.target.closest('.p-3'); const nameNode = node.querySelector('div'); const old = nameNode.innerText; nameNode.innerText = name;
            try{ await api('PUT','/admin/api/categories/'+id,{name}); }catch(err){ nameNode.innerText = old; alert('Update failed'); }
        });
    });

    // restaurants
    document.querySelectorAll('.del-restaurant').forEach(b=>{
        if(b._attached) return; b._attached = true;
        b.addEventListener('click', async e=>{
            if(!confirm('Delete restaurant?')) return; const id = e.target.dataset.id; const node = e.target.closest('.p-3'); const parent = node.parentNode; parent.removeChild(node);
            const header = findHeader('Restaurants'); setCount(header, parent.querySelectorAll('.p-3').length);
            try{ await api('DELETE','/admin/api/restaurants/'+id); }catch(err){ parent.insertBefore(node, parent.firstChild); setCount(header, parent.querySelectorAll('.p-3').length); alert('Delete failed'); }
        });
    });

    document.querySelectorAll('.edit-restaurant').forEach(b=>{
        if(b._attached) return; b._attached = true;
        b.addEventListener('click', async e=>{
            const id = e.target.dataset.id; const node = e.target.closest('.p-3'); const nameNode = node.querySelector('.font-semibold'); const addrNode = node.querySelector('.text-sm'); const oldName = nameNode.innerText; const oldAddr = addrNode.innerText; const name = prompt('Name', oldName); if(name===null) return; const address = prompt('Address', oldAddr);
            nameNode.innerText = name; addrNode.innerText = address||'—';
            try{ await api('PUT','/admin/api/restaurants/'+id,{name,address}); }catch(err){ nameNode.innerText = oldName; addrNode.innerText = oldAddr; alert('Update failed'); }
        });
    });

    // dishes
    document.querySelectorAll('.approve-dish').forEach(b=>{
        if(b._attached) return; b._attached = true;
        b.addEventListener('click', async e=>{
            const id = e.target.dataset.id; const node = e.target.closest('.p-3'); const parent = node.parentNode; parent.removeChild(node);
            const header = findHeader('Pending Dishes'); setCount(header, parent.querySelectorAll('.p-3').length);
            try{ await api('POST','/admin/api/dishes/'+id+'/approve'); }catch(err){ parent.insertBefore(node, parent.firstChild); setCount(header, parent.querySelectorAll('.p-3').length); alert('Action failed'); }
        });
    });

    document.querySelectorAll('.disapprove-dish').forEach(b=>{
        if(b._attached) return; b._attached = true;
        b.addEventListener('click', async e=>{
            const id = e.target.dataset.id; const node = e.target.closest('.p-3'); const parent = node.parentNode; parent.removeChild(node);
            const header = findHeader('Pending Dishes'); setCount(header, parent.querySelectorAll('.p-3').length);
            try{ await api('POST','/admin/api/dishes/'+id+'/disapprove'); }catch(err){ parent.insertBefore(node, parent.firstChild); setCount(header, parent.querySelectorAll('.p-3').length); alert('Action failed'); }
        });
    });
}

attachGridHandlers();
</script>
@endpush
