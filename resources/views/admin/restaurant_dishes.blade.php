@extends('admin.layout')

@section('title', 'Dishes for ' . ($restaurant->name ?? ''))

@section('content')
    <div class="breadcrumb">
        <a href="/admin">Dashboard</a>
        <span>›</span>
        <a href="/admin/restaurants">Restaurants</a>
        <span>›</span>
        <a href="/admin/restaurants/{{ $restaurant->id }}/edit">{{ $restaurant->name }}</a>
        <span>›</span>
        <span>Dishes</span>
    </div>

    <div class="page-header">
        <div>
            <h1 class="page-title">Dishes — {{ $restaurant->name }}</h1>
            <p class="page-subtitle">View all dishes submitted for this restaurant</p>
        </div>
        <a href="/admin/restaurants" class="btn btn-secondary">
            <span>←</span> Back to Restaurants
        </a>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="search-bar" style="margin-bottom: 0; flex: 1;">
                <div class="search-input-wrapper">
                    <input type="text" id="search-input" class="search-input" placeholder="Search dishes...">
                </div>
            </div>
        </div>
        
        <div class="data-grid">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Comment</th>
                        <th>Status</th>
                        <th>Meal Cost</th>
                        <th>Date Spot</th>
                        <th>Website</th>
                        <th>Created</th>
                    </tr>
                </thead>
                <tbody id="dishes-body">
                    @forelse($dishes as $d)
                        <tr data-name="{{ strtolower($d->name) }}" data-comment="{{ strtolower($d->comment ?? '') }}">
                            <td>{{ $d->id }}</td>
                            <td>
                                @if($d->images && $d->images->count())
                                    <img src="{{ $d->images->first()->url ?? '' }}" alt="" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                                @else
                                    <div style="width: 50px; height: 50px; background: #f1f5f9; border-radius: 4px; display: flex; align-items: center; justify-content: center;"><svg class="icon icon-xl icon-muted"><use href="#icon-dish"></use></svg></div>
                                @endif
                            </td>
                            <td><strong>{{ $d->name }}</strong></td>
                            <td style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ $d->comment ?? '—' }}</td>
                            <td>
                                @if($d->status === 'approved')
                                    <span class="badge badge-success">Approved</span>
                                @elseif($d->status === 'pending')
                                    <span class="badge badge-warning">Pending</span>
                                @else
                                    <span class="badge badge-danger">{{ ucfirst($d->status) }}</span>
                                @endif
                            </td>
                            <td>{{ $d->meal_cost ? '$' . number_format($d->meal_cost, 2) : '—' }}</td>
                            <td>
                                @if($d->good_date_spot)
                                    <span class="badge badge-success">Yes</span>
                                @else
                                    <span class="text-muted">No</span>
                                @endif
                            </td>
                            <td>
                                @if($d->website)
                                    <a href="{{ $d->website }}" target="_blank" style="color: var(--primary);">Visit</a>
                                @else
                                    —
                                @endif
                            </td>
                            <td class="text-sm text-muted">{{ $d->created_at->format('M d, Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" style="text-align: center; padding: 2rem;">
                                <div style="color: #64748b;">
                                    <div style="margin-bottom: 0.5rem;"><svg class="icon icon-3xl icon-muted"><use href="#icon-dish"></use></svg></div>
                                    <div>No dishes have been submitted for this restaurant yet.</div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="card-footer" style="display: flex; justify-content: space-between; align-items: center;">
            <div class="text-muted text-sm">Total: {{ count($dishes) }} dish(es)</div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.getElementById('search-input').addEventListener('input', (e) => {
    const q = e.target.value.toLowerCase();
    document.querySelectorAll('#dishes-body tr[data-name]').forEach(row => {
        const name = row.dataset.name || '';
        const comment = row.dataset.comment || '';
        const matches = name.includes(q) || comment.includes(q);
        row.style.display = matches ? '' : 'none';
    });
});
</script>
@endpush
