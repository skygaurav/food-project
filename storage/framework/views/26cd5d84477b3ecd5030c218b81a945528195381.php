<?php $__env->startSection('title','Overview'); ?>

<?php $__env->startSection('content'); ?>
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem">
        <h2 class="text-2xl font-semibold">Overview</h2>
        <div>
            <a href="/admin/restaurants/create" class="rounded border border-slate-400 px-4 py-2 mr-2">New Restaurant</a>
            <a href="/admin/categories" class="rounded border border-slate-400 px-4 py-2 mr-2">New Category</a>
            <input id="admin-search" placeholder="Search..." class="rounded border px-2 py-1 ml-3" />
            <button id="col-toggle" class="rounded border px-2 py-1 ml-2">Columns</button>
        </div>
    </div>

    <div class="form-row" style="align-items:flex-start">
        <div class="form-col">
            <h3 class="font-semibold mb-2">Restaurants (<?php echo e($restaurants->count()); ?>)</h3>
            <div>
                <?php $__empty_1 = true; $__currentLoopData = $restaurants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="p-3 mb-2 border rounded flex justify-between items-center">
                        <div>
                            <div class="font-semibold"><?php echo e($r->name); ?></div>
                            <div class="text-sm text-slate-600"><?php echo e($r->address ?? '—'); ?></div>
                            <div class="text-xs text-slate-500">Categories: <?php echo e($r->categories->pluck('name')->join(', ')); ?></div>
                        </div>
                        <div style="display:flex;gap:.5rem">
                            <button class="edit-restaurant" data-id="<?php echo e($r->id); ?>">Edit</button>
                            <button class="del-restaurant" data-id="<?php echo e($r->id); ?>">Delete</button>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="p-3">No restaurants yet</div>
                <?php endif; ?>
            </div>
        </div>

        <div class="form-col">
            <h3 class="font-semibold mb-2">Categories (<?php echo e($categories->count()); ?>)</h3>
            <div>
                <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="p-3 mb-2 border rounded flex justify-between items-center">
                        <div><?php echo e($c->name); ?></div>
                        <div style="display:flex;gap:.5rem">
                            <a class="rounded border px-2 py-1" href="/admin/categories/<?php echo e($c->id); ?>/edit">Edit</a>
                            <button class="del-category" data-id="<?php echo e($c->id); ?>">Delete</button>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="p-3">No categories yet</div>
                <?php endif; ?>
            </div>
        </div>

        <div style="width:360px">
            <h3 class="font-semibold mb-2">Pending Dishes (<?php echo e($pendingDishes->count()); ?>)</h3>
            <div>
                <?php $__empty_1 = true; $__currentLoopData = $pendingDishes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="p-3 mb-2 border rounded">
                        <div class="font-semibold"><?php echo e($d->name); ?></div>
                        <div class="text-sm text-slate-600">By: <?php echo e($d->restaurant->name ?? '—'); ?></div>
                        <div class="mt-2" style="display:flex;gap:.5rem">
                            <button class="approve-dish" data-id="<?php echo e($d->id); ?>">Approve</button>
                            <button class="disapprove-dish" data-id="<?php echo e($d->id); ?>">Disapprove</button>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="p-3">No pending dishes</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
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
            const id = e.target.dataset.id; const current = e.target.closest('.p-3').querySelector('div').innerText;
            const html = `<h3 class="text-lg font-semibold mb-2">Edit Category</h3><div><label class="block"><div class="text-sm">Name</div><input id="modal-cat-name" value="${current}" class="rounded border px-2 py-1 w-full"/></label><div style="margin-top:.75rem;text-align:right"><button id="modal-cat-save" class="rounded border px-3 py-1">Save</button></div></div>`;
            window.adminModal.open(html);
            document.getElementById('modal-cat-save').addEventListener('click', async ()=>{
                const newName = document.getElementById('modal-cat-name').value.trim(); if(!newName) return alert('Required');
                const node = e.target.closest('.p-3'); const nameNode = node.querySelector('div'); const old = nameNode.innerText; nameNode.innerText = newName; window.adminModal.close();
                try{ await api('PUT','/admin/api/categories/'+id,{name:newName}); }catch(err){ nameNode.innerText = old; alert('Update failed'); }
            });
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
        b.addEventListener('click', e=>{
            const id = e.target.dataset.id; if(!id) return; window.location.href = '/admin/restaurants/'+id+'/edit';
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
// simple client-side search
document.getElementById('admin-search')?.addEventListener('input', function(e){
    const q = this.value.trim().toLowerCase();
    document.querySelectorAll('.form-col').forEach(col=>{
        col.querySelectorAll('.p-3').forEach(item=>{
            const text = item.innerText.toLowerCase();
            item.style.display = q === '' || text.includes(q) ? '' : 'none';
        });
    });
});

// column show/hide persisted via admin settings API
document.getElementById('col-toggle')?.addEventListener('click', async function(){
    const key = 'grid_columns';
    // open simple modal to toggle
    const current = window.adminSettings[key] ?? {restaurants:true,categories:true,dishes:true};
    const html = `<h3 class="text-lg font-semibold mb-2">Columns</h3><div style="display:flex;gap:.5rem"><label><input type="checkbox" id="col-rest" ${current.restaurants? 'checked':''}/> Restaurants</label><label><input type="checkbox" id="col-cat" ${current.categories? 'checked':''}/> Categories</label><label><input type="checkbox" id="col-dish" ${current.dishes? 'checked':''}/> Dishes</label></div><div style="text-align:right;margin-top:.75rem"><button id="col-save" class="rounded border px-3 py-1">Save</button></div>`;
    window.adminModal.open(html);
    document.getElementById('col-save').addEventListener('click', async ()=>{
        const cols = { restaurants: !!document.getElementById('col-rest').checked, categories: !!document.getElementById('col-cat').checked, dishes: !!document.getElementById('col-dish').checked };
        try{
            await adminFetch('POST','/admin/api/settings',{ key, value: cols });
            window.adminSettings[key] = cols;
            // apply
            const mapping = {restaurants:0,categories:1,dishes:2};
            Object.keys(mapping).forEach(n=>{ const idx = mapping[n]; const col = document.querySelectorAll('.form-row > .form-col, .form-row > [style]')[idx]; if(col) col.style.display = cols[n] ? '' : 'none'; });
            window.adminModal.close();
        }catch(e){ alert('Save failed'); }
    });
});

// apply saved settings when present
(function applySavedCols(){
    const key = 'grid_columns'; const cols = window.adminSettings[key];
    if(!cols) return;
    const mapping = {restaurants:0,categories:1,dishes:2};
    Object.keys(mapping).forEach(n=>{ const idx = mapping[n]; const col = document.querySelectorAll('.form-row > .form-col, .form-row > [style]')[idx]; if(col) col.style.display = cols[n] ? '' : 'none'; });
})();
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/grid.blade.php ENDPATH**/ ?>