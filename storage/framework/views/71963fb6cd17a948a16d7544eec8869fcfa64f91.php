<?php $__env->startSection('title', isset($admin) && $admin->id ? 'Edit Admin' : 'New Admin'); ?>

<?php $__env->startSection('content'); ?>
    <div class="breadcrumb">
        <a href="/admin">Dashboard</a>
        <span>›</span>
        <a href="/admin/admins">Admin Users</a>
        <span>›</span>
        <span><?php echo e(isset($admin) && $admin->id ? 'Edit' : 'New'); ?></span>
    </div>

    <div class="page-header">
        <div>
            <h1 class="page-title"><?php echo e(isset($admin) && $admin->id ? 'Edit Admin User' : 'Create New Admin User'); ?></h1>
            <p class="page-subtitle"><?php echo e(isset($admin) && $admin->id ? 'Update admin user details' : 'Add a new administrator account'); ?></p>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form id="admin-form">
                <input type="hidden" name="id" value="<?php echo e($admin->id ?? ''); ?>" />
                
                <h3 style="font-size: 1rem; font-weight: 600; margin-bottom: 1rem; color: #475569;">Account Information</h3>
                
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Username <span style="color: #ef4444;">*</span></label>
                        <input type="text" name="username" value="<?php echo e($admin->username ?? ''); ?>" class="form-control" placeholder="Enter username" required />
                    </div>
                </div>
                
                <h3 style="font-size: 1rem; font-weight: 600; margin: 1.5rem 0 1rem; color: #475569;">Password<?php echo e(isset($admin) && $admin->id ? ' (leave blank to keep current)' : ''); ?></h3>
                
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Password <?php if(!isset($admin) || !$admin->id): ?><span style="color: #ef4444;">*</span><?php endif; ?></label>
                        <input type="password" name="password" class="form-control" placeholder="Enter password" minlength="6" <?php echo e(!isset($admin) || !$admin->id ? 'required' : ''); ?> />
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" name="password_confirm" class="form-control" placeholder="Confirm password" />
                    </div>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary" id="submit-btn">
                        <span>💾</span> <?php echo e(isset($admin) && $admin->id ? 'Update Admin' : 'Create Admin'); ?>

                    </button>
                    <a href="/admin/admins" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
const form = document.getElementById('admin-form');
const isEdit = form.id.value !== '';

form.addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const username = form.username.value.trim();
    const password = form.password.value;
    const passwordConfirm = form.password_confirm.value;
    
    if (!username) {
        alert('Username is required');
        return;
    }
    
    if (!isEdit && !password) {
        alert('Password is required');
        return;
    }
    
    if (password && password !== passwordConfirm) {
        alert('Passwords do not match');
        return;
    }
    
    if (password && password.length < 6) {
        alert('Password must be at least 6 characters');
        return;
    }
    
    const submitBtn = document.getElementById('submit-btn');
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<svg class="icon icon-spin"><use href="#icon-loader"></use></svg> Saving...';
    
    try {
        const data = { username };
        if (password) {
            data.password = password;
        }
        
        if (isEdit) {
            await adminFetch('PUT', `/admin/api/admins/${form.id.value}`, data);
        } else {
            await adminFetch('POST', '/admin/api/admins', data);
        }
        
        window.location.href = '/admin/admins';
    } catch (err) {
        alert('Failed to save admin: ' + (err.message || 'Unknown error'));
        submitBtn.disabled = false;
        submitBtn.innerHTML = '<span>💾</span> ' + (isEdit ? 'Update Admin' : 'Create Admin');
    }
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/admin_form.blade.php ENDPATH**/ ?>