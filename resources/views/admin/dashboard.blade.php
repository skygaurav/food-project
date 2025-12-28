@php($title = 'Admin Dashboard')

<x-admin-layout :title="$title">
    <div class="admin-header">
        <div>
            <h1 class="text-2xl font-semibold">Dashboard</h1>
            <p class="text-slate-600">Monitor the latest submissions and manage the platform.</p>
        </div>
        <div class="admin-toolbar">
            <a class="rounded border border-slate-500 px-4 py-2" href="/admin/restaurants">Manage restaurants</a>
            <a class="rounded border border-slate-500 px-4 py-2" href="/admin/dishes">Review dishes</a>
        </div>
    </div>

    <div class="grid gap-6 md:grid-cols-3">
        <div class="admin-card admin-card-body space-y-2">
            <p class="text-sm text-slate-500">Pending approvals</p>
            <p class="text-3xl font-semibold">18</p>
            <span class="admin-pill">Needs attention</span>
        </div>
        <div class="admin-card admin-card-body space-y-2">
            <p class="text-sm text-slate-500">Active restaurants</p>
            <p class="text-3xl font-semibold">42</p>
            <span class="admin-pill">Updated today</span>
        </div>
        <div class="admin-card admin-card-body space-y-2">
            <p class="text-sm text-slate-500">New reviews</p>
            <p class="text-3xl font-semibold">76</p>
            <span class="admin-pill">Last 7 days</span>
        </div>
    </div>
</x-admin-layout>
