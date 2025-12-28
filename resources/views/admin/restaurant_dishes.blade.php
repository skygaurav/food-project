@extends('admin.layout')

@section('title', 'Dishes for ' . ($restaurant->name ?? ''))

@section('content')
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem">
        <h2 class="text-2xl font-semibold">Dishes — {{ $restaurant->name }}</h2>
        <a href="/admin/restaurants" class="rounded border px-3 py-2">Back</a>
    </div>

    <div>
        @forelse($dishes as $d)
            <div class="p-3 mb-2 border rounded">
                <div class="font-semibold">{{ $d->name }}</div>
                <div class="text-sm text-slate-600">{{ $d->comment }}</div>
                <div class="text-xs text-slate-500">Meal cost: {{ $d->meal_cost ?? '—' }} | Good date spot: {{ $d->good_date_spot ? 'Yes' : 'No' }} | Website: {{ $d->website ?? '—' }}</div>
            </div>
        @empty
            <div>No dishes yet</div>
        @endforelse
    </div>
@endsection
