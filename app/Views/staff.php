<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Four Beans Café - Staff</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root { --primary-brown:#5D4037; --light-brown:#8D6E63; --beige:#F5F0E8; }
        body { background-color:var(--beige); font-family:'Segoe UI',Tahoma,Geneva,Verdana,sans-serif; }
        .sidebar { background-color:var(--primary-brown); min-height:100vh; color:white; padding:20px 0; }
        .sidebar-logo { display:flex; align-items:center; gap:10px; padding:0 25px; margin-bottom:30px; }
        .sidebar-logo i { font-size:2rem; } .sidebar-logo h4 { margin:0; font-weight:600; }
        .nav-link { color:rgba(255,255,255,0.8); padding:12px 25px; display:flex; align-items:center; gap:12px; transition:all 0.3s; }
        .nav-link:hover { color:white; background-color:rgba(255,255,255,0.1); }
        .nav-link.active { background-color:var(--light-brown); color:white; }
        .nav-link i { font-size:1.2rem; }
        .user-profile { display:flex; align-items:center; gap:12px; padding:15px 25px; margin-top:20px; }
        .user-avatar { width:45px; height:45px; border-radius:50%; background-color:var(--light-brown); display:flex; align-items:center; justify-content:center; font-weight:bold; overflow:hidden; }
        .user-avatar img { width:100%; height:100%; object-fit:cover; }
        .user-info h6 { margin:0; font-weight:600; } .user-info small { color:rgba(255,255,255,0.7); }
        .main-content { padding:30px; }
        .header-section { display:flex; justify-content:space-between; align-items:center; margin-bottom:25px; }
        .header-section h2 { color:var(--primary-brown); margin:0; font-weight:700; }
        .header-section p { color:#666; margin:0; }
        .btn-primary-brown { background-color:var(--primary-brown); color:white; border:none; padding:10px 24px; border-radius:8px; font-weight:500; }
        .btn-primary-brown:hover { background-color:var(--light-brown); color:white; }
        .section-card { background:white; border-radius:16px; padding:25px; box-shadow:0 2px 10px rgba(0,0,0,0.05); }
        .table thead th { border:none; color:#666; font-weight:500; font-size:0.85rem; padding:12px 15px; }
        .table tbody td { border:none; padding:12px 15px; vertical-align:middle; }
        .table tbody tr { border-bottom:1px solid #f0f0f0; }
        .table tbody tr:last-child { border-bottom:none; }
        .staff-avatar-sm { width:45px; height:45px; border-radius:50%; object-fit:cover; }
        .staff-avatar-initials { width:45px; height:45px; border-radius:50%; background:var(--beige); display:flex; align-items:center; justify-content:center; font-weight:700; color:var(--primary-brown); }
        .staff-name { color:var(--primary-brown); font-weight:600; }
        .action-btn { border:none; background:none; padding:5px 8px; border-radius:6px; transition:all 0.3s; }
        .action-btn:hover { background-color:#f5f5f5; }
        .action-btn.edit { color:#2196F3; } .action-btn.delete { color:#F44336; }
        .avatar-preview { width:80px; height:80px; border-radius:50%; object-fit:cover; display:none; margin-top:10px; }
    </style>
</head>
<body>
<div class="container-fluid">
<div class="row">
    <!-- Sidebar -->
    <div class="col-md-2 sidebar d-flex flex-column">
        <div class="sidebar-logo"><i class="bi bi-cup-hot"></i><h4>Four Beans Café</h4></div>
        <nav class="nav flex-column">
            <a class="nav-link" href="/dashboard"><i class="bi bi-grid-1x2"></i> Dashboard</a>
            <a class="nav-link" href="/products"><i class="bi bi-box-seam"></i> Products</a>
            <a class="nav-link" href="/customers"><i class="bi bi-people"></i> Customers</a>
            <a class="nav-link active" href="/staff"><i class="bi bi-person-badge"></i> Staff</a>
            <a class="nav-link" href="/record-sale"><i class="bi bi-cart-plus"></i> Record Sale</a>
            <a class="nav-link" href="/sales-history"><i class="bi bi-clock-history"></i> Sales History</a>
        </nav>
        <div class="mt-auto">
            <a class="nav-link text-danger" href="/logout"><i class="bi bi-box-arrow-left"></i> Logout</a>
        </div>
        <div class="user-profile">
            <div class="user-avatar">
                <?php if (session()->get('avatar')): ?>
                    <img src="/uploads/avatars/<?= session()->get('avatar') ?>" alt="avatar">
                <?php else: ?>
                    <?= strtoupper(substr(session()->get('user_name','?'), 0, 2)) ?>
                <?php endif; ?>
            </div>
            <div class="user-info">
                <h6><?= esc(session()->get('user_name')) ?></h6>
                <small>Staff Member</small>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="col-md-10 main-content">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="header-section">
            <div>
                <h2>Staff Management</h2>
                <p>Manage your café staff members (<?= count($staff) ?> total)</p>
            </div>
            <button class="btn btn-primary-brown" data-bs-toggle="modal" data-bs-target="#addStaffModal">
                <i class="bi bi-plus-lg me-2"></i> Add Staff
            </button>
        </div>

        <div class="section-card">
            <table class="table">
                <thead>
                    <tr>
                        <th>STAFF MEMBER</th>
                        <th>USERNAME</th>
                        <th>JOINED</th>
                        <th>ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($staff)): ?>
                        <tr><td colspan="4" class="text-center text-muted py-4">No staff members found.</td></tr>
                    <?php else: ?>
                        <?php foreach ($staff as $s): ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <?php if ($s['avatar']): ?>
                                            <img src="/uploads/avatars/<?= esc($s['avatar']) ?>" class="staff-avatar-sm" alt="<?= esc($s['full_name']) ?>">
                                        <?php else: ?>
                                            <div class="staff-avatar-initials"><?= strtoupper(substr($s['full_name'], 0, 2)) ?></div>
                                        <?php endif; ?>
                                        <div>
                                            <div class="staff-name"><?= esc($s['full_name']) ?></div>
                                            <?php if (session()->get('user_id') == $s['id']): ?>
                                                <span class="badge bg-secondary" style="font-size:0.7rem;">You</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </td>
                                <td><code><?= esc($s['username']) ?></code></td>
                                <td class="text-muted" style="font-size:0.85rem;"><?= date('M j, Y', strtotime($s['created_at'])) ?></td>
                                <td>
                                    <button class="action-btn edit" data-bs-toggle="modal" data-bs-target="#editStaffModal"
                                        data-id="<?= $s['id'] ?>"
                                        data-fullname="<?= esc($s['full_name']) ?>"
                                        data-username="<?= esc($s['username']) ?>"
                                        data-avatar="<?= esc($s['avatar']) ?>">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <?php if (session()->get('user_id') != $s['id']): ?>
                                        <form method="POST" action="/staff/delete/<?= $s['id'] ?>" class="d-inline"
                                              onsubmit="return confirm('Delete this staff member?')">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="action-btn delete"><i class="bi bi-trash"></i></button>
                                        </form>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>

<!-- Add Staff Modal -->
<div class="modal fade" id="addStaffModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="/staff/store" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="modal-header">
                    <h5 class="modal-title" style="color:var(--primary-brown)"><i class="bi bi-person-plus me-2"></i>Add Staff Member</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-medium">Full Name *</label>
                        <input type="text" class="form-control" name="full_name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium">Username *</label>
                        <input type="text" class="form-control" name="username" required autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium">Password *</label>
                        <input type="password" class="form-control" name="password" required autocomplete="new-password">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium">Avatar Photo</label>
                        <input type="file" class="form-control" name="avatar" accept="image/*"
                               onchange="previewAvatar(this,'addAvatarPreview')">
                        <img id="addAvatarPreview" class="avatar-preview" alt="preview">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary-brown">Add Staff</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Staff Modal -->
<div class="modal fade" id="editStaffModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editStaffForm" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="modal-header">
                    <h5 class="modal-title" style="color:var(--primary-brown)"><i class="bi bi-pencil me-2"></i>Edit Staff Member</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-medium">Full Name *</label>
                        <input type="text" class="form-control" name="full_name" id="edit_staff_fullname" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium">Username *</label>
                        <input type="text" class="form-control" name="username" id="edit_staff_username" required autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium">New Password <small class="text-muted">(leave blank to keep current)</small></label>
                        <input type="password" class="form-control" name="password" autocomplete="new-password">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium">Avatar Photo <small class="text-muted">(leave blank to keep current)</small></label>
                        <input type="file" class="form-control" name="avatar" accept="image/*"
                               onchange="previewAvatar(this,'editAvatarPreview')">
                        <img id="editCurrentAvatar" class="avatar-preview" alt="current avatar">
                        <img id="editAvatarPreview" class="avatar-preview" alt="new avatar">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary-brown">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
function previewAvatar(input, previewId) {
    const preview = document.getElementById(previewId);
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => { preview.src = e.target.result; preview.style.display = 'block'; };
        reader.readAsDataURL(input.files[0]);
    }
}

document.getElementById('editStaffModal').addEventListener('show.bs.modal', function(e) {
    const btn = e.relatedTarget;
    document.getElementById('edit_staff_fullname').value = btn.dataset.fullname;
    document.getElementById('edit_staff_username').value  = btn.dataset.username;
    document.getElementById('editStaffForm').action = '/staff/update/' + btn.dataset.id;

    const currentAvatar = document.getElementById('editCurrentAvatar');
    if (btn.dataset.avatar) {
        currentAvatar.src = '/uploads/avatars/' + btn.dataset.avatar;
        currentAvatar.style.display = 'block';
    } else {
        currentAvatar.style.display = 'none';
    }
    document.getElementById('editAvatarPreview').style.display = 'none';
});
</script>
</body>
</html>
