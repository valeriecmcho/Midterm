<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Four Beans Café - Sales History</title>
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
        .section-card { background:white; border-radius:16px; padding:25px; box-shadow:0 2px 10px rgba(0,0,0,0.05); }
        .table thead th { border:none; color:#666; font-weight:500; font-size:0.85rem; padding:12px 15px; }
        .table tbody td { border:none; padding:12px 15px; vertical-align:middle; }
        .table tbody tr { border-bottom:1px solid #f0f0f0; }
        .table tbody tr:last-child { border-bottom:none; }
        .transaction-id { color:var(--primary-brown); font-weight:700; }
        .price { color:var(--primary-brown); font-weight:600; }
        .date-cell { color:#666; font-size:0.85rem; }
        .search-box { display:flex; gap:10px; }
        .search-box input { border:1px solid #ddd; border-radius:8px; padding:8px 15px; }
        .summary-strip { display:flex; gap:20px; margin-bottom:20px; flex-wrap:wrap; }
        .summary-pill { background:#f5f0e8; border-radius:12px; padding:12px 20px; text-align:center; min-width:130px; }
        .summary-pill .value { font-size:1.3rem; font-weight:700; color:var(--primary-brown); }
        .summary-pill .label { font-size:0.8rem; color:#888; }
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
            <a class="nav-link" href="/record-sale"><i class="bi bi-cart-plus"></i> Record Sale</a>
            <a class="nav-link active" href="/sales-history"><i class="bi bi-clock-history"></i> Sales History</a>
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
        <div class="header-section">
            <div>
                <h2>Sales History</h2>
                <p>All recorded sales transactions</p>
            </div>
            <a href="/record-sale" class="btn" style="background:var(--primary-brown);color:white;border-radius:8px;padding:10px 24px;font-weight:500;">
                <i class="bi bi-plus-lg me-2"></i> New Sale
            </a>
        </div>

        <?php
            $totalRevenue = array_sum(array_column($sales, 'total_price'));
            $totalQty = array_sum(array_column($sales, 'quantity'));
        ?>
        <div class="summary-strip">
            <div class="summary-pill">
                <div class="value"><?= count($sales) ?></div>
                <div class="label">Total Transactions</div>
            </div>
            <div class="summary-pill">
                <div class="value">₱<?= number_format($totalRevenue, 2) ?></div>
                <div class="label">Total Revenue</div>
            </div>
            <div class="summary-pill">
                <div class="value"><?= $totalQty ?></div>
                <div class="label">Units Sold</div>
            </div>
        </div>

        <div class="section-card">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 style="color:var(--primary-brown); margin:0; font-weight:600;">All Transactions</h5>
                <div class="search-box">
                    <input type="text" id="tableSearch" placeholder="Search transactions..." oninput="filterTable()" class="form-control" style="width:250px;">
                </div>
            </div>
            <table class="table" id="salesTable">
                <thead>
                    <tr>
                        <th>#ID</th>
                        <th>PRODUCT</th>
                        <th>CUSTOMER</th>
                        <th>STAFF</th>
                        <th>QTY</th>
                        <th>TOTAL</th>
                        <th>DATE</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($sales)): ?>
                        <tr><td colspan="7" class="text-center text-muted py-4">No sales recorded yet.</td></tr>
                    <?php else: ?>
                        <?php foreach ($sales as $s): ?>
                            <tr>
                                <td><span class="transaction-id">#<?= $s['id'] ?></span></td>
                                <td><?= esc($s['product_name']) ?></td>
                                <td><?= $s['customer_name'] ? esc($s['customer_name']) : '<em class="text-muted">Walk-in</em>' ?></td>
                                <td><?= esc($s['staff_name']) ?></td>
                                <td><?= $s['quantity'] ?></td>
                                <td><span class="price">₱<?= number_format($s['total_price'], 2) ?></span></td>
                                <td class="date-cell"><?= date('M j, Y g:i A', strtotime($s['created_at'])) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
function filterTable() {
    const q = document.getElementById('tableSearch').value.toLowerCase();
    document.querySelectorAll('#salesTable tbody tr').forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
    });
}
</script>
</body>
</html>
