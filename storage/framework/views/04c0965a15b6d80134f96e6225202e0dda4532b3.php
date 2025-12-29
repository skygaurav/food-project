<?php $__env->startSection('title', 'View Dish - ' . $dish->name); ?>

<?php $__env->startSection('content'); ?>
    <div class="breadcrumb">
        <a href="/admin">Dashboard</a>
        <span>›</span>
        <a href="/admin/dishes">All Dishes</a>
        <span>›</span>
        <span><?php echo e($dish->name); ?></span>
    </div>

    <div class="page-header">
        <div>
            <h1 class="page-title"><?php echo e($dish->name); ?></h1>
            <p class="page-subtitle">Dish details and approval management</p>
        </div>
        <div class="page-actions">
            <?php if($dish->status === 'pending'): ?>
                <button class="btn btn-success" id="approve-btn">
                    <svg class="icon"><use href="#icon-check-circle"></use></svg> Approve
                </button>
                <button class="btn btn-danger" id="reject-btn">
                    <svg class="icon"><use href="#icon-x"></use></svg> Reject
                </button>
            <?php else: ?>
                <span id="status-badge" class="badge <?php echo e($dish->status === 'approved' ? 'badge-success' : 'badge-danger'); ?>" style="font-size: 1rem; padding: 0.5rem 1rem;">
                    <?php echo e(ucfirst($dish->status)); ?>

                </span>
            <?php endif; ?>
            <a href="/dishes/<?php echo e($dish->slug); ?>" target="_blank" class="btn btn-secondary">
                <svg class="icon"><use href="#icon-external-link"></use></svg> View on Site
            </a>
        </div>
    </div>

    <div class="dish-view-grid">
        <!-- Images Section -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Images (<?php echo e($dish->images->count()); ?>)</h3>
            </div>
            <div class="card-body">
                <div id="dish-images" class="dish-images-grid">
                    <?php if($dish->images->count() > 0): ?>
                        <?php $__currentLoopData = $dish->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="dish-image-item">
                                <span class="image-index"><?php echo e($index + 1); ?></span>
                                <img src="/storage/<?php echo e($image->path); ?>" alt="<?php echo e($dish->name); ?>" onclick="openImageModal(this.src)" />
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                        <div class="no-images">
                            <svg class="icon icon-xl icon-muted"><use href="#icon-dish"></use></svg>
                            <p>No images uploaded</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Details Section -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Dish Details</h3>
            </div>
            <div class="card-body">
                <div class="detail-grid">
                    <div class="detail-item">
                        <label>Name</label>
                        <span><?php echo e($dish->name); ?></span>
                    </div>
                    <div class="detail-item">
                        <label>Slug</label>
                        <span><code><?php echo e($dish->slug); ?></code></span>
                    </div>
                    <div class="detail-item">
                        <label>Status</label>
                        <span>
                            <?php if($dish->status === 'approved'): ?>
                                <span class="badge badge-success">Approved</span>
                            <?php elseif($dish->status === 'pending'): ?>
                                <span class="badge badge-warning">Pending</span>
                            <?php else: ?>
                                <span class="badge badge-danger"><?php echo e(ucfirst($dish->status)); ?></span>
                            <?php endif; ?>
                        </span>
                    </div>
                    <div class="detail-item">
                        <label>Meal Cost</label>
                        <span><?php echo e($dish->meal_cost ? '$' . number_format($dish->meal_cost, 2) : '—'); ?></span>
                    </div>
                    <div class="detail-item">
                        <label>Good Date Spot</label>
                        <span>
                            <?php if($dish->good_date_spot): ?>
                                <span class="badge badge-success">Yes</span>
                            <?php else: ?>
                                <span class="text-muted">No</span>
                            <?php endif; ?>
                        </span>
                    </div>
                    <div class="detail-item">
                        <label>Reservation</label>
                        <span>
                            <?php if($dish->reservation): ?>
                                <span class="badge badge-success">Yes</span>
                            <?php else: ?>
                                <span class="text-muted">No</span>
                            <?php endif; ?>
                        </span>
                    </div>
                    <div class="detail-item">
                        <label>Phone</label>
                        <span><?php echo e($dish->phone ?: '—'); ?></span>
                    </div>
                    <div class="detail-item">
                        <label>Website</label>
                        <span>
                            <?php if($dish->website): ?>
                                <a href="<?php echo e($dish->website); ?>" target="_blank" style="color: var(--primary);"><?php echo e($dish->website); ?></a>
                            <?php else: ?>
                                —
                            <?php endif; ?>
                        </span>
                    </div>
                    <div class="detail-item full-width">
                        <label>Comment</label>
                        <span><?php echo e($dish->comment ?: '—'); ?></span>
                    </div>
                    <div class="detail-item">
                        <label>Created At</label>
                        <span><?php echo e($dish->created_at->format('M d, Y h:i A')); ?></span>
                    </div>
                    <div class="detail-item">
                        <label>Updated At</label>
                        <span><?php echo e($dish->updated_at->format('M d, Y h:i A')); ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Restaurant Section -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Restaurant Information</h3>
                <?php if($dish->restaurant): ?>
                    <a href="/admin/restaurants/<?php echo e($dish->restaurant->id); ?>/edit" class="btn btn-sm btn-secondary">
                        <svg class="icon icon-sm"><use href="#icon-edit"></use></svg> Edit Restaurant
                    </a>
                <?php endif; ?>
            </div>
            <div class="card-body">
                <?php if($dish->restaurant): ?>
                    <div class="detail-grid">
                        <div class="detail-item">
                            <label>Name</label>
                            <span><?php echo e($dish->restaurant->name); ?></span>
                        </div>
                        <div class="detail-item">
                            <label>Approved</label>
                            <span>
                                <?php if($dish->restaurant->is_approved): ?>
                                    <span class="badge badge-success">Yes</span>
                                <?php else: ?>
                                    <span class="badge badge-warning">Pending</span>
                                <?php endif; ?>
                            </span>
                        </div>
                        <div class="detail-item full-width">
                            <label>Address</label>
                            <span><?php echo e($dish->restaurant->address); ?>, <?php echo e($dish->restaurant->city); ?>, <?php echo e($dish->restaurant->region); ?> <?php echo e($dish->restaurant->postcode); ?>, <?php echo e($dish->restaurant->country); ?></span>
                        </div>
                        <div class="detail-item">
                            <label>Website</label>
                            <span>
                                <?php if($dish->restaurant->website): ?>
                                    <a href="<?php echo e($dish->restaurant->website); ?>" target="_blank" style="color: var(--primary);"><?php echo e($dish->restaurant->website); ?></a>
                                <?php else: ?>
                                    —
                                <?php endif; ?>
                            </span>
                        </div>
                        <div class="detail-item">
                            <label>Phone</label>
                            <span><?php echo e($dish->restaurant->phone ?: '—'); ?></span>
                        </div>
                        <div class="detail-item">
                            <label>Reservation</label>
                            <span>
                                <?php if($dish->restaurant->reservation): ?>
                                    <span class="badge badge-success">Yes</span>
                                <?php else: ?>
                                    <span class="text-muted">No</span>
                                <?php endif; ?>
                            </span>
                        </div>
                        <div class="detail-item">
                            <label>Categories</label>
                            <span>
                                <?php if($dish->restaurant->categories && $dish->restaurant->categories->count() > 0): ?>
                                    <?php $__currentLoopData = $dish->restaurant->categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <span class="badge badge-secondary"><?php echo e($cat->name); ?></span>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                    —
                                <?php endif; ?>
                            </span>
                        </div>
                    </div>
                <?php else: ?>
                    <p class="text-muted">No restaurant associated</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Uploader Section -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Uploaded By</h3>
            </div>
            <div class="card-body">
                <?php if($dish->user): ?>
                    <div class="detail-grid">
                        <div class="detail-item">
                            <label>User ID</label>
                            <span>#<?php echo e($dish->user->id); ?></span>
                        </div>
                        <div class="detail-item">
                            <label>Name</label>
                            <span><?php echo e($dish->user->name); ?></span>
                        </div>
                        <div class="detail-item">
                            <label>Email</label>
                            <span><?php echo e($dish->user->email); ?></span>
                        </div>
                        <div class="detail-item">
                            <label>Registered</label>
                            <span><?php echo e($dish->user->created_at->format('M d, Y')); ?></span>
                        </div>
                    </div>
                <?php else: ?>
                    <p class="text-muted">Unknown uploader</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Stats Section -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Engagement Stats</h3>
            </div>
            <div class="card-body">
                <div class="stats-grid">
                    <div class="stat-item">
                        <div class="stat-value"><?php echo e($dish->reactions->where('type', 'like')->count()); ?></div>
                        <div class="stat-label">
                            <svg class="icon icon-sm icon-success"><use href="#icon-thumbs-up"></use></svg> Likes
                        </div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value"><?php echo e($dish->reactions->where('type', 'dislike')->count()); ?></div>
                        <div class="stat-label">
                            <svg class="icon icon-sm icon-danger" style="transform: scaleY(-1)"><use href="#icon-thumbs-up"></use></svg> Dislikes
                        </div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value"><?php echo e($dish->reviews->count()); ?></div>
                        <div class="stat-label">
                            <svg class="icon icon-sm"><use href="#icon-star"></use></svg> Reviews
                        </div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value"><?php echo e($dish->reviews->count() > 0 ? number_format($dish->reviews->avg('rating'), 1) : '—'); ?></div>
                        <div class="stat-label">
                            <svg class="icon icon-sm icon-warning"><use href="#icon-star-filled"></use></svg> Avg Rating
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reviews Section -->
        <div class="card full-width">
            <div class="card-header">
                <h3 class="card-title">Reviews (<?php echo e($dish->reviews->count()); ?>)</h3>
            </div>
            <div class="card-body">
                <?php if($dish->reviews->count() > 0): ?>
                    <div class="reviews-list">
                        <?php $__currentLoopData = $dish->reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="review-item">
                                <div class="review-header">
                                    <div class="review-user">
                                        <svg class="icon"><use href="#icon-user"></use></svg>
                                        <span><?php echo e($review->user ? $review->user->name : 'Anonymous'); ?></span>
                                    </div>
                                    <div class="review-rating">
                                        <?php for($i = 1; $i <= 5; $i++): ?>
                                            <?php if($i <= $review->rating): ?>
                                                <svg class="icon icon-sm icon-warning icon-filled"><use href="#icon-star-filled"></use></svg>
                                            <?php else: ?>
                                                <svg class="icon icon-sm icon-muted"><use href="#icon-star"></use></svg>
                                            <?php endif; ?>
                                        <?php endfor; ?>
                                    </div>
                                    <span class="review-date"><?php echo e($review->created_at->format('M d, Y')); ?></span>
                                </div>
                                <p class="review-content"><?php echo e($review->comment ?: 'No comment'); ?></p>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php else: ?>
                    <p class="text-muted" style="text-align: center; padding: 2rem;">No reviews yet</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Image Modal -->
    <div id="image-modal" class="image-modal" onclick="closeImageModal()">
        <span class="image-modal-close">&times;</span>
        <img id="modal-image" src="" alt="" />
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .dish-view-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
    }
    
    .dish-view-grid .card.full-width {
        grid-column: 1 / -1;
    }
    
    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .card-title {
        font-size: 1rem;
        font-weight: 600;
        margin: 0;
    }
    
    .dish-images-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
        gap: 0.75rem;
        max-height: 400px;
        overflow-y: auto;
        padding: 0.25rem;
    }
    
    .dish-image-item {
        position: relative;
        aspect-ratio: 1;
    }
    
    .dish-image-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 8px;
        cursor: pointer;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    
    .dish-image-item img:hover {
        transform: scale(1.02);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    
    .dish-image-item .image-index {
        position: absolute;
        top: 0.5rem;
        left: 0.5rem;
        background: rgba(0,0,0,0.6);
        color: #fff;
        font-size: 0.7rem;
        padding: 0.2rem 0.5rem;
        border-radius: 4px;
    }
    
    .no-images {
        text-align: center;
        padding: 2rem;
        color: #94a3b8;
    }
    
    .no-images svg {
        margin-bottom: 0.5rem;
    }
    
    .detail-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
    }
    
    .detail-item {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }
    
    .detail-item.full-width {
        grid-column: 1 / -1;
    }
    
    .detail-item label {
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #64748b;
    }
    
    .detail-item span {
        font-size: 0.9rem;
        color: #1e293b;
    }
    
    .detail-item code {
        background: #f1f5f9;
        padding: 0.25rem 0.5rem;
        border-radius: 4px;
        font-size: 0.85rem;
    }
    
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1rem;
        text-align: center;
    }
    
    .stat-item {
        padding: 1rem;
        background: #f8fafc;
        border-radius: 8px;
    }
    
    .stat-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1e293b;
    }
    
    .stat-label {
        font-size: 0.8rem;
        color: #64748b;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.25rem;
        margin-top: 0.25rem;
    }
    
    .reviews-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }
    
    .review-item {
        padding: 1rem;
        background: #f8fafc;
        border-radius: 8px;
    }
    
    .review-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 0.5rem;
    }
    
    .review-user {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 500;
    }
    
    .review-rating {
        display: flex;
        gap: 2px;
    }
    
    .review-date {
        margin-left: auto;
        font-size: 0.8rem;
        color: #64748b;
    }
    
    .review-content {
        margin: 0;
        color: #475569;
        font-size: 0.9rem;
        line-height: 1.5;
    }
    
    .page-actions {
        display: flex;
        gap: 0.75rem;
        align-items: center;
    }
    
    .image-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.9);
        z-index: 1000;
        justify-content: center;
        align-items: center;
        cursor: pointer;
    }
    
    .image-modal.show {
        display: flex;
    }
    
    .image-modal img {
        max-width: 90%;
        max-height: 90%;
        border-radius: 8px;
    }
    
    .image-modal-close {
        position: absolute;
        top: 1rem;
        right: 1.5rem;
        font-size: 2rem;
        color: #fff;
        cursor: pointer;
    }
    
    .badge-secondary {
        background: #e2e8f0;
        color: #475569;
    }
    
    @media (max-width: 1024px) {
        .dish-view-grid {
            grid-template-columns: 1fr;
        }
        
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    
    @media (max-width: 640px) {
        .detail-grid {
            grid-template-columns: 1fr;
        }
        
        .page-actions {
            flex-wrap: wrap;
        }
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
const dishId = <?php echo e($dish->id); ?>;

function openImageModal(src) {
    document.getElementById('modal-image').src = src;
    document.getElementById('image-modal').classList.add('show');
}

function closeImageModal() {
    document.getElementById('image-modal').classList.remove('show');
}

document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') closeImageModal();
});

// Approve button
const approveBtn = document.getElementById('approve-btn');
if (approveBtn) {
    approveBtn.addEventListener('click', async () => {
        if (!confirm('Are you sure you want to approve this dish?')) return;
        
        try {
            await adminFetch('POST', `/admin/api/dishes/${dishId}/approve`);
            alert('Dish approved successfully!');
            location.reload();
        } catch (e) {
            alert('Failed to approve dish: ' + e.message);
        }
    });
}

// Reject button
const rejectBtn = document.getElementById('reject-btn');
if (rejectBtn) {
    rejectBtn.addEventListener('click', async () => {
        const reason = prompt('Enter rejection reason (optional):');
        if (reason === null) return; // User cancelled
        
        try {
            await adminFetch('POST', `/admin/api/dishes/${dishId}/disapprove`, { reason });
            alert('Dish rejected.');
            location.reload();
        } catch (e) {
            alert('Failed to reject dish: ' + e.message);
        }
    });
}
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/dish_view.blade.php ENDPATH**/ ?>