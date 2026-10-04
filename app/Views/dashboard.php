<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Four Beans Café - POS Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root { --primary-brown:#5D4037; --light-brown:#8D6E63; --beige:#F5F0E8; --card-bg:#FFFFFF; }
        body { background-color:var(--beige); font-family:'Segoe UI',Tahoma,Geneva,Verdana,sans-serif; }
        .sidebar { background-color:var(--primary-brown); min-height:100vh; color:white; padding:20px 0; }
        .sidebar-logo { display:flex; align-items:center; gap:10px; padding:0 25px; margin-bottom:30px; }
        .sidebar-logo i { font-size:2rem; }
        .sidebar-logo h4 { margin:0; font-weight:600; }
        .nav-link { color:rgba(255,255,255,0.8); padding:12px 25px; display:flex; align-items:center; gap:12px; transition:all 0.3s; }
        .nav-link:hover { color:white; background-color:rgba(255,255,255,0.1); }
        .nav-link.active { background-color:var(--light-brown); color:white; }
        .nav-link i { font-size:1.2rem; }
        .sidebar-bottom { padding:0 25px; margin-top:auto; }
        .user-profile { display:flex; align-items:center; gap:12px; padding:15px 25px; margin-top:20px; }
        .user-avatar { width:45px; height:45px; border-radius:50%; background-color:var(--light-brown); display:flex; align-items:center; justify-content:center; font-weight:bold; overflow:hidden; }
        .user-avatar img { width:100%; height:100%; object-fit:cover; }
        .user-info h6 { margin:0; font-weight:600; }
        .user-info small { color:rgba(255,255,255,0.7); }
        .main-content { padding:30px; }
        .header-section { display:flex; justify-content:space-between; align-items:center; margin-bottom:30px; }
        .header-section h2 { color:var(--primary-brown); margin:0; }
        .header-section p { color:#666; margin:0; }
        .btn-record-sale { background-color:var(--primary-brown); color:white; border:none; padding:12px 30px; border-radius:8px; font-weight:500; }
        .btn-record-sale:hover { background-color:var(--light-brown); color:white; }
        .summary-card { background:var(--card-bg); border-radius:16px; padding:25px; box-shadow:0 2px 10px rgba(0,0,0,0.05); border:none; }
        .summary-card .icon-box { width:50px; height:50px; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:1.5rem; margin-bottom:15px; }
        .icon-box.green { background-color:#E8F5E9; color:#4CAF50; }
        .icon-box.blue { background-color:#E3F2FD; color:#2196F3; }
        .icon-box.orange { background-color:#FFF3E0; color:#FF9800; }
        .icon-box.purple { background-color:#F3E5F5; color:#9C27B0; }
        .summary-card h5 { color:#666; font-weight:500; margin-bottom:10px; }
        .summary-card h3 { color:var(--primary-brown); font-weight:700; margin-bottom:10px; }
        .section-card { background:var(--card-bg); border-radius:16px; padding:25px; box-shadow:0 2px 10px rgba(0,0,0,0.05); border:none; }
        .section-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; }
        .section-header h5 { color:var(--primary-brown); font-weight:600; margin:0; }
        .section-header p { color:#666; margin:0; font-size:0.9rem; }
        .low-stock-item { display:flex; align-items:center; gap:15px; padding:12px; border-radius:12px; transition:background-color 0.3s; }
        .low-stock-item:hover { background-color:#f9f9f9; }
        .low-stock-item img { width:50px; height:50px; border-radius:10px; object-fit:cover; }
        .low-stock-item .item-img-placeholder { width:50px; height:50px; border-radius:10px; background:#f0e8e0; display:flex; align-items:center; justify-content:center; color:var(--light-brown); font-size:1.3rem; }
        .low-stock-item .item-info h6 { margin:0; color:var(--primary-brown); font-weight:600; }
        .low-stock-item .item-info small { color:#666; }
        .stock-badge { background-color:#FFEBEE; color:#F44336; padding:5px 12px; border-radius:20px; font-size:0.85rem; font-weight:500; }
        .table { border:none; }
        .table thead th { border:none; color:#666; font-weight:500; font-size:0.85rem; padding:15px; }
        .table tbody td { border:none; padding:12px 15px; vertical-align:middle; }
        .table tbody tr { border-bottom:1px solid #f0f0f0; }
        .table tbody tr:last-child { border-bottom:none; }
        .transaction-id { color:var(--primary-brown); font-weight:600; }
        .price { color:var(--primary-brown); font-weight:600; }
        .date { color:#666; font-size:0.9rem; }
        .link-text { color:var(--primary-brown); text-decoration:none; font-weight:500; }
        .link-text:hover { text-decoration:underline; }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-2 sidebar d-flex flex-column">
            <div class="sidebar-logo">
                <i class="bi bi-cup-hot"></i>
                <h4>Four Beans Café</h4>
            </div>
            <nav class="nav flex-column">
                <a class="nav-link active" href="/dashboard"><i class="bi bi-grid-1x2"></i> Dashboard</a>
                <a class="nav-link" href="/products"><i class="bi bi-box-seam"></i> Products</a>
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
                <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                    <?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <div class="header-section">
                <div>
                    <h2>Four Beans Café</h2>
                    <p>Point-of-Sale Management Dashboard</p>
                </div>
                <a href="/record-sale" class="btn btn-record-sale">
                    <i class="bi bi-cart me-2"></i> Record a sale
                </a>
            </div>

            <!-- Summary Cards -->
            <div class="row g-4 mb-4">
                <div class="col-md-3">
                    <div class="summary-card">
                        <div class="icon-box green"><i class="bi bi-currency-dollar"></i></div>
                        <h5>Today's Sales</h5>
                        <h3>₱<?= number_format($todaySales, 2) ?></h3>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="summary-card">
                        <div class="icon-box blue"><i class="bi bi-file-earmark-text"></i></div>
                        <h5>Today's Transactions</h5>
                        <h3><?= $totalTx ?></h3>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="summary-card">
                        <div class="icon-box orange"><i class="bi bi-box"></i></div>
                        <h5>Total Products</h5>
                        <h3><?= $totalProducts ?></h3>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="summary-card">
                        <div class="icon-box purple"><i class="bi bi-people"></i></div>
                        <h5>Total Customers</h5>
                        <h3><?= $totalCustomers ?></h3>
                    </div>
                </div>
            </div>

            <!-- Low Stock & Recent Transactions -->
            <div class="row g-4 mb-4">
                <div class="col-md-4">
                    <div class="section-card">
                        <div class="section-header">
                            <div>
                                <h5>Low Stock</h5>
                                <p>Products requiring attention</p>
                            </div>
                            <a href="/products" class="link-text">View all</a>
                        </div>
                        <?php if (empty($lowStock)): ?>
                            <p class="text-muted text-center py-3">All products have sufficient stock.</p>
                        <?php else: ?>
                            <?php foreach ($lowStock as $item): ?>
                                <div class="low-stock-item">
                                    <?php if ($item['image']): ?>
                                        <img src="/uploads/products/<?= esc($item['image']) ?>" alt="<?= esc($item['name']) ?>">
                                    <?php else: ?>
                                        <div class="item-img-placeholder"><i class="bi bi-box-seam"></i></div>
                                    <?php endif; ?>
                                    <div class="item-info flex-grow-1">
                                        <h6><?= esc($item['name']) ?></h6>
                                        <small>₱<?= number_format($item['price'], 2) ?></small>
                                    </div>
                                    <span class="stock-badge"><?= $item['stock_quantity'] ?> left</span>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="section-card">
                        <div class="section-header">
                            <div>
                                <h5>Recent Transactions</h5>
                                <p>Latest sales at Four Beans Café</p>
                            </div>
                            <a href="/sales-history" class="link-text">View all</a>
                        </div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>PRODUCT</th>
                                    <th>CUSTOMER</th>
                                    <th>STAFF</th>
                                    <th>QTY</th>
                                    <th>TOTAL</th>
                                    <th>DATE</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($recentSales)): ?>
                                    <tr><td colspan="7" class="text-center text-muted py-3">No transactions yet.</td></tr>
                                <?php else: ?>
                                    <?php foreach ($recentSales as $sale): ?>
                                        <tr>
                                            <td><span class="transaction-id">#<?= $sale['id'] ?></span></td>
                                            <td><?= esc($sale['product_name']) ?></td>
                                            <td><?= $sale['customer_name'] ? esc($sale['customer_name']) : '<em class="text-muted">Walk-in</em>' ?></td>
                                            <td><?= esc($sale['staff_name']) ?></td>
                                            <td><?= $sale['quantity'] ?></td>
                                            <td><span class="price">₱<?= number_format($sale['total_price'], 2) ?></span></td>
                                            <td><span class="date"><?= date('M j, g:i A', strtotime($sale['created_at'])) ?></span></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
