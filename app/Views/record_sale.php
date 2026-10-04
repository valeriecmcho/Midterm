<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Four Beans Café - Record Sale</title>
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
        .header-section h2 { color:var(--primary-brown); font-weight:700; margin-bottom:5px; }
        .header-section p { color:#666; margin:0; }
        .form-card { background:white; border-radius:16px; padding:30px; box-shadow:0 2px 10px rgba(0,0,0,0.05); }
        .product-select-card { border:2px solid #e0e0e0; border-radius:12px; padding:15px; cursor:pointer; transition:all 0.3s; margin-bottom:15px; }
        .product-select-card:hover { border-color:var(--primary-brown); background:#faf8f6; }
        .product-select-card.selected { border-color:var(--primary-brown); background:#f5f0e8; }
        .product-select-card img { width:60px; height:60px; border-radius:10px; object-fit:cover; }
        .product-img-ph { width:60px; height:60px; border-radius:10px; background:#f0e8e0; display:flex; align-items:center; justify-content:center; color:var(--light-brown); font-size:1.5rem; }
        .product-name { color:var(--primary-brown); font-weight:600; font-size:1rem; }
        .product-price { color:var(--light-brown); font-weight:600; }
        .product-stock { font-size:0.82rem; color:#888; }
        .btn-primary-brown { background-color:var(--primary-brown); color:white; border:none; padding:12px 24px; border-radius:8px; font-weight:600; }
        .btn-primary-brown:hover { background-color:var(--light-brown); color:white; }
        .btn-primary-brown:disabled { background-color:#ccc; cursor:not-allowed; }
        .total-display { font-size:1.6rem; font-weight:700; color:var(--primary-brown); }
        .form-control:focus, .form-select:focus { border-color:var(--primary-brown); box-shadow:0 0 0 0.2rem rgba(93,64,55,0.15); }
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
            <a class="nav-link" href="/staff"><i class="bi bi-person-badge"></i> Staff</a>
            <a class="nav-link active" href="/record-sale"><i class="bi bi-cart-plus"></i> Record Sale</a>
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
                <i class="bi bi-check-circle me-2"></i><?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i><?= session()->getFlashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="header-section mb-4">
            <h2>Record a Sale</h2>
            <p>Select a product, optionally assign a customer, enter quantity and submit.</p>
        </div>

        <?php if (empty($products)): ?>
            <div class="alert alert-warning">
                <i class="bi bi-exclamation-triangle me-2"></i>
                No products with stock available. Please <a href="/products">add or restock products</a> first.
            </div>
        <?php else: ?>
        <form action="/record-sale/store" method="POST" id="saleForm">
            <?= csrf_field() ?>
            <input type="hidden" name="product_id" id="selected_product_id">

            <div class="row g-4">
                <!-- Product Selection -->
                <div class="col-md-8">
                    <div class="form-card">
                        <h5 style="color:var(--primary-brown); font-weight:600; margin-bottom:20px;">
                            <i class="bi bi-box-seam me-2"></i> Select Product
                        </h5>
                        <input type="text" class="form-control mb-3" id="productSearch" placeholder="Search products..." oninput="filterProducts()">
                        <div id="productsContainer">
                            <?php foreach ($products as $p): ?>
                                <div class="product-select-card"
                                     id="pcard_<?= $p['id'] ?>"
                                     data-name="<?= strtolower(esc($p['name'])) ?>"
                                     onclick="selectProduct(<?= $p['id'] ?>, '<?= esc($p['name'], 'js') ?>', <?= $p['price'] ?>, <?= $p['stock_quantity'] ?>)">
                                    <div class="d-flex align-items-center gap-3">
                                        <?php if ($p['image']): ?>
                                            <img src="/uploads/products/<?= esc($p['image']) ?>" alt="<?= esc($p['name']) ?>">
                                        <?php else: ?>
                                            <div class="product-img-ph"><i class="bi bi-cup-hot"></i></div>
                                        <?php endif; ?>
                                        <div class="flex-grow-1">
                                            <div class="product-name"><?= esc($p['name']) ?></div>
                                            <div class="product-price">₱<?= number_format($p['price'], 2) ?></div>
                                            <div class="product-stock"><?= $p['stock_quantity'] ?> units available</div>
                                        </div>
                                        <div class="text-end">
                                            <i class="bi bi-check-circle-fill text-success" id="check_<?= $p['id'] ?>" style="display:none; font-size:1.3rem;"></i>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <!-- Order Summary Panel -->
                <div class="col-md-4">
                    <div class="form-card" style="position:sticky; top:20px;">
                        <h5 style="color:var(--primary-brown); font-weight:600; margin-bottom:20px;">
                            <i class="bi bi-receipt me-2"></i> Sale Details
                        </h5>

                        <div id="noProductMsg" class="text-center text-muted py-3">
                            <i class="bi bi-arrow-left-circle" style="font-size:2rem;"></i>
                            <p class="mt-2">Select a product first</p>
                        </div>

                        <div id="saleDetailsForm" style="display:none;">
                            <div class="mb-3 p-3 rounded" style="background:#f5f0e8;">
                                <div id="selectedProductName" class="fw-bold" style="color:var(--primary-brown);"></div>
                                <div id="selectedProductPrice" class="text-muted small"></div>
                                <div id="selectedProductStock" class="text-muted small"></div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-medium">Quantity *</label>
                                <input type="number" class="form-control" name="quantity" id="quantity_input"
                                       min="1" value="1" required oninput="updateTotal()">
                                <div id="stockWarning" class="text-danger small mt-1" style="display:none;"></div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-medium">Customer <small class="text-muted">(optional)</small></label>
                                <select class="form-select" name="customer_id">
                                    <option value="">Walk-in Customer</option>
                                    <?php foreach ($customers as $c): ?>
                                        <option value="<?= $c['id'] ?>"><?= esc($c['full_name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="text-center mb-3">
                                <div class="text-muted small">Total Amount</div>
                                <div class="total-display" id="totalDisplay">₱0.00</div>
                            </div>

                            <button type="submit" class="btn btn-primary-brown w-100" id="submitBtn">
                                <i class="bi bi-check2-circle me-2"></i> Record Sale
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <?php endif; ?>
    </div>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
let selectedPrice = 0;
let selectedStock = 0;

function selectProduct(id, name, price, stock) {
    // Remove selected from all cards
    document.querySelectorAll('.product-select-card').forEach(c => {
        c.classList.remove('selected');
    });
    document.querySelectorAll('[id^="check_"]').forEach(c => {
        c.style.display = 'none';
    });

    // Select this card
    document.getElementById('pcard_' + id).classList.add('selected');
    document.getElementById('check_' + id).style.display = 'inline';

    document.getElementById('selected_product_id').value = id;
    selectedPrice = price;
    selectedStock = stock;

    document.getElementById('selectedProductName').textContent = name;
    document.getElementById('selectedProductPrice').textContent = '₱' + price.toFixed(2) + ' per unit';
    document.getElementById('selectedProductStock').textContent = stock + ' units in stock';

    document.getElementById('noProductMsg').style.display = 'none';
    document.getElementById('saleDetailsForm').style.display = 'block';

    document.getElementById('quantity_input').value = 1;
    document.getElementById('quantity_input').max = stock;
    updateTotal();
}

function updateTotal() {
    const qty = parseInt(document.getElementById('quantity_input').value) || 0;
    const total = qty * selectedPrice;
    document.getElementById('totalDisplay').textContent = '₱' + total.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');

    const warning = document.getElementById('stockWarning');
    const btn = document.getElementById('submitBtn');
    if (qty > selectedStock) {
        warning.textContent = 'Exceeds available stock (' + selectedStock + ' units)';
        warning.style.display = 'block';
        btn.disabled = true;
    } else if (qty <= 0) {
        warning.textContent = 'Quantity must be at least 1';
        warning.style.display = 'block';
        btn.disabled = true;
    } else {
        warning.style.display = 'none';
        btn.disabled = false;
    }
}

function filterProducts() {
    const q = document.getElementById('productSearch').value.toLowerCase();
    document.querySelectorAll('.product-select-card').forEach(card => {
        card.style.display = card.dataset.name.includes(q) ? '' : 'none';
    });
}

document.getElementById('saleForm') && document.getElementById('saleForm').addEventListener('submit', function(e) {
    const pid = document.getElementById('selected_product_id').value;
    if (!pid) {
        e.preventDefault();
        alert('Please select a product first.');
    }
});
</script>
</body>
</html>
