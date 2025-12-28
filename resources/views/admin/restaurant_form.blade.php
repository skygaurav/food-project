@extends('admin.layout')

@section('title', isset($restaurant) ? 'Edit Restaurant' : 'New Restaurant')

@section('content')
    <h2 class="text-2xl font-semibold mb-4">{{ isset($restaurant) ? 'Edit' : 'Create' }} Restaurant</h2>

    <form id="restaurant-form" class="space-y-4">
        <input type="hidden" name="id" value="{{ $restaurant->id ?? '' }}" />
        <label class="block">
            <div class="text-sm font-medium">Name</div>
            <input name="name" value="{{ $restaurant->name ?? '' }}" class="rounded border px-3 py-2 w-full" />
        </label>
        <label class="block">
            <div class="text-sm font-medium">Address</div>
            <input name="address" value="{{ $restaurant->address ?? '' }}" class="rounded border px-3 py-2 w-full" />
        </label>
        <label class="block">
            <div class="text-sm font-medium">Website</div>
            <input name="website" value="{{ $restaurant->website ?? '' }}" class="rounded border px-3 py-2 w-full" />
        </label>
        <div>
            <button type="submit" class="rounded border px-4 py-2">Save</button>
            <a href="/admin/restaurants" class="ml-2">Cancel</a>
        </div>
    </form>
@endsection

@push('scripts')
<script>
const form = document.getElementById('restaurant-form');
form.addEventListener('submit', async e=>{
    e.preventDefault();
    const id = form.id.value;
    const payload = { name: form.name.value.trim(), address: form.address.value.trim(), website: form.website.value.trim() };
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    try{
        if(id){
            await fetch('/admin/api/restaurants/'+id, {method:'PUT', credentials:'same-origin', headers:{'Content-Type':'application/json','X-CSRF-TOKEN':token}, body:JSON.stringify(payload)});
        } else {
            await fetch('/admin/api/restaurants', {method:'POST', credentials:'same-origin', headers:{'Content-Type':'application/json','X-CSRF-TOKEN':token}, body:JSON.stringify(payload)});
        }
        location.href = '/admin/restaurants';
    }catch(err){ alert('Save failed'); }
});
</script>
@endpush
