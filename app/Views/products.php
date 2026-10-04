<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Four Beans Café - Products</title>
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
        .product-thumb { width:50px; height:50px; border-radius:10px; object-fit:cover; }
        .product-thumb-placeholder { width:50px; height:50px; border-radius:10px; background:#f0e8e0; display:flex; align-items:center; justify-content:center; color:var(--light-brown); font-size:1.4rem; }
        .stock-badge { padding:4px 12px; border-radius:20px; font-size:0.8rem; font-weight:500; }
        .stock-high { background:#E8F5E9; color:#4CAF50; }
        .stock-medium { background:#FFF3E0; color:#FF9800; }
        .stock-low { background:#FFEBEE; color:#F44336; }
        .price { color:var(--primary-brown); font-weight:600; }
        .action-btn { border:none; background:none; padding:5px 8px; border-radius:6px; transition:all 0.3s; }
        .action-btn:hover { background-color:#f5f5f5; }
        .action-btn.edit { color:#2196F3; } .action-btn.delete { color:#F44336; }
        .img-preview { width:100px; height:100px; border-radius:10px; object-fit:cover; display:none; margin-top:10px; }
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
            <a class="nav-link active" href="/products"><i class="bi bi-box-seam"></i> Products</a>
            <a class="nav-link" href="/customers"><i class="bi bi-people"></i> Customers</a>
            <a class="nav-link" href="/staff"><i class="bi bi-person-badge"></i> Staff</a>
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
                <h2>Product Management</h2>
                <p>Manage Four Beans Café menu and inventory</p>
            </div>
            <button class="btn btn-primary-brown" data-bs-toggle="modal" data-bs-target="#addProductModal">
                <i class="bi bi-plus-lg me-2"></i> Add Product
            </button>
        </div>

        <div class="section-card">
            <table class="table">
                <thead>
                    <tr>
                        <th>IMAGE</th>
                        <th>NAME</th>
                        <th>PRICE</th>
                        <th>STOCK</th>
                        <th>ADDED</th>
                        <th>ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($products)): ?>
                        <tr><td colspan="6" class="text-center text-muted py-4">No products found. Add your first product!</td></tr>
                    <?php else: ?>
                        <?php foreach ($products as $p): ?>
                            <?php
                                $stock = $p['stock_quantity'];
                                $stockClass = $stock >= 20 ? 'stock-high' : ($stock >= 10 ? 'stock-medium' : 'stock-low');
                                $stockLabel = $stock >= 20 ? 'In Stock' : ($stock >= 10 ? 'Low' : 'Critical');
                            ?>
                            <tr>
                                <td>
                                    <?php if ($p['image']): ?>
                                        <img src="/uploads/products/<?= esc($p['image']) ?>" class="product-thumb" alt="<?= esc($p['name']) ?>">
                                    <?php else: ?>
                                        <div class="product-thumb-placeholder"><i class="bi bi-box-seam"></i></div>
                                    <?php endif; ?>
                                </td>
                                <td><strong><?= esc($p['name']) ?></strong></td>
                                <td class="price">₱<?= number_format($p['price'], 2) ?></td>
                                <td>
                                    <span class="stock-badge <?= $stockClass ?>"><?= $stockLabel ?> (<?= $stock ?>)</span>
                                </td>
                                <td class="text-muted" style="font-size:0.85rem;"><?= date('M j, Y', strtotime($p['created_at'])) ?></td>
                                <td>
                                    <button class="action-btn edit" data-bs-toggle="modal" data-bs-target="#editProductModal"
                                        data-id="<?= $p['id'] ?>"
                                        data-name="<?= esc($p['name']) ?>"
                                        data-price="<?= $p['price'] ?>"
                                        data-stock="<?= $p['stock_quantity'] ?>"
                                        data-image="<?= esc($p['image']) ?>">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <form method="POST" action="/products/delete/<?= $p['id'] ?>" class="d-inline"
                                          onsubmit="return confirm('Delete this product?')">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="action-btn delete"><i class="bi bi-trash"></i></button>
                                    </form>
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

<!-- Add Product Modal -->
<div class="modal fade" id="addProductModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="/products/store" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="modal-header">
                    <h5 class="modal-title" style="color:var(--primary-brown)"><i class="bi bi-plus-circle me-2"></i>Add Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-medium">Product Name *</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col">
                            <label class="form-label fw-medium">Price (₱) *</label>
                            <input type="number" class="form-control" name="price" step="0.01" min="0" required>
                        </div>
                        <div class="col">
                            <label class="form-label fw-medium">Stock Quantity *</label>
                            <input type="number" class="form-control" name="stock_quantity" min="0" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium">Product Image</label>
                        <input type="file" class="form-control" name="image" accept="image/*" onchange="previewImage(this,'addPreview')">
                        <img id="addPreview" class="img-preview" alt="preview">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary-brown">Add Product</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Product Modal -->
<div class="modal fade" id="editProductModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editProductForm" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="modal-header">
                    <h5 class="modal-title" style="color:var(--primary-brown)"><i class="bi bi-pencil me-2"></i>Edit Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-medium">Product Name *</label>
                        <input type="text" class="form-control" name="name" id="edit_name" required>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col">
                            <label class="form-label fw-medium">Price (₱) *</label>
                            <input type="number" class="form-control" name="price" id="edit_price" step="0.01" min="0" required>
                        </div>
                        <div class="col">
                            <label class="form-label fw-medium">Stock Quantity *</label>
                            <input type="number" class="form-control" name="stock_quantity" id="edit_stock" min="0" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium">Product Image (leave blank to keep current)</label>
                        <input type="file" class="form-control" name="image" accept="image/*" onchange="previewImage(this,'editPreview')">
                        <img id="editCurrentImg" class="img-preview" alt="current image">
                        <img id="editPreview" class="img-preview" alt="new preview">
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
function previewImage(input, previewId) {
    const preview = document.getElementById(previewId);
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => { preview.src = e.target.result; preview.style.display = 'block'; };
        reader.readAsDataURL(input.files[0]);
    }
}

document.getElementById('editProductModal').addEventListener('show.bs.modal', function(e) {
    const btn = e.relatedTarget;
    document.getElementById('edit_name').value  = btn.dataset.name;
    document.getElementById('edit_price').value = btn.dataset.price;
    document.getElementById('edit_stock').value = btn.dataset.stock;
    document.getElementById('editProductForm').action = '/products/update/' + btn.dataset.id;

    const currentImg = document.getElementById('editCurrentImg');
    if (btn.dataset.image) {
        currentImg.src = '/uploads/products/' + btn.dataset.image;
        currentImg.style.display = 'block';
    } else {
        currentImg.style.display = 'none';
    }
    document.getElementById('editPreview').style.display = 'none';
});

// Auto-open edit modal if PHP set editProduct
<?php if (isset($editProduct)): ?>
document.addEventListener('DOMContentLoaded', function() {
    var modal = new bootstrap.Modal(document.getElementById('editProductModal'));
    document.getElementById('edit_name').value  = '<?= esc($editProduct['name'], 'js') ?>';
    document.getElementById('edit_price').value = '<?= $editProduct['price'] ?>';
    document.getElementById('edit_stock').value = '<?= $editProduct['stock_quantity'] ?>';
    document.getElementById('editProductForm').action = '/products/update/<?= $editProduct['id'] ?>';
    modal.show();
});
<?php endif; ?>
</script>
</body>
</html>
