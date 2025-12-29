<?php $__env->startSection('title', 'Dishes for ' . ($restaurant->name ?? '')); ?>

<?php $__env->startSection('content'); ?>
    <div class="breadcrumb">
        <a href="/admin">Dashboard</a>
        <span>›</span>
        <a href="/admin/restaurants">Restaurants</a>
        <span>›</span>
        <a href="/admin/restaurants/<?php echo e($restaurant->id); ?>/edit"><?php echo e($restaurant->name); ?></a>
        <span>›</span>
        <span>Dishes</span>
    </div>

    <div class="page-header">
        <div>
            <h1 class="page-title">Dishes — <?php echo e($restaurant->name); ?></h1>
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
                    <?php $__empty_1 = true; $__currentLoopData = $dishes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr data-name="<?php echo e(strtolower($d->name)); ?>" data-comment="<?php echo e(strtolower($d->comment ?? '')); ?>">
                            <td><?php echo e($d->id); ?></td>
                            <td>
                                <?php if($d->images && $d->images->count()): ?>
                                    <img src="/storage/<?php echo e($d->images->first()->path); ?>" alt="" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                                <?php else: ?>
                                    <div style="width: 50px; height: 50px; background: #f1f5f9; border-radius: 4px; display: flex; align-items: center; justify-content: center;"><svg class="icon icon-xl icon-muted"><use href="#icon-dish"></use></svg></div>
                                <?php endif; ?>
                            </td>
                            <td><strong><?php echo e($d->name); ?></strong></td>
                            <td style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"><?php echo e($d->comment ?? '—'); ?></td>
                            <td>
                                <?php if($d->status === 'approved'): ?>
                                    <span class="badge badge-success">Approved</span>
                                <?php elseif($d->status === 'pending'): ?>
                                    <span class="badge badge-warning">Pending</span>
                                <?php else: ?>
                                    <span class="badge badge-danger"><?php echo e(ucfirst($d->status)); ?></span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo e($d->meal_cost ? '$' . number_format($d->meal_cost, 2) : '—'); ?></td>
                            <td>
                                <?php if($d->good_date_spot): ?>
                                    <span class="badge badge-success">Yes</span>
                                <?php else: ?>
                                    <span class="text-muted">No</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if($d->website): ?>
                                    <a href="<?php echo e($d->website); ?>" target="_blank" style="color: var(--primary);">Visit</a>
                                <?php else: ?>
                                    —
                                <?php endif; ?>
                            </td>
                            <td class="text-sm text-muted"><?php echo e($d->created_at->format('M d, Y')); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="9" style="text-align: center; padding: 2rem;">
                                <div style="color: #64748b;">
                                    <div style="margin-bottom: 0.5rem;"><svg class="icon icon-3xl icon-muted"><use href="#icon-dish"></use></svg></div>
                                    <div>No dishes have been submitted for this restaurant yet.</div>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <div class="card-footer" style="display: flex; justify-content: space-between; align-items: center;">
            <div class="text-muted text-sm">Total: <?php echo e(count($dishes)); ?> dish(es)</div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
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
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/restaurant_dishes.blade.php ENDPATH**/ ?>