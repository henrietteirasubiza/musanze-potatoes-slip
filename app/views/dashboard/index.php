<?php
// app/views/dashboard/index.php
$pageTitle = 'Dashboard';
require __DIR__ . '/../partials/header.php';

$totalOrders = array_sum($statusCounts);
?>

<div class="page-header">
    <div>
        <h1>Dashboard</h1>
        <p>Overview of Musanze Market order activity</p>
    </div>
    <a href="<?= BASE_URL ?>/orders/create" class="btn btn-primary">+ New Order</a>
</div>

<!-- Stats Grid -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-label">Today's Orders</div>
        <div class="stat-value"><?= (int)$todayStats['total_orders'] ?></div>
        <div class="stat-sub"><?= date('D, d M Y') ?></div>
    </div>
    <div class="stat-card green">
        <div class="stat-label">Today's Value</div>
        <div class="stat-value" style="font-size:20px"><?= formatRWF((float)$todayStats['total_value']) ?></div>
        <div class="stat-sub">Rwandan Francs</div>
    </div>
    <div class="stat-card blue">
        <div class="stat-label">Total Orders</div>
        <div class="stat-value"><?= $totalOrders ?></div>
        <div class="stat-sub">All time</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Total Value</div>
        <div class="stat-value" style="font-size:20px"><?= formatRWF($totalValue) ?></div>
        <div class="stat-sub">All orders</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Registered Suppliers</div>
        <div class="stat-value"><?= $totalSuppliers ?></div>
        <div class="stat-sub">Farmers &amp; cooperatives</div>
    </div>
</div>

<!-- Status Summary -->
<div class="card" style="margin-bottom:24px">
    <div class="card-header">
        <span class="card-title">Order Status Summary</span>
    </div>
    <div class="card-body">
        <div style="display:flex;gap:16px;flex-wrap:wrap">
            <div style="display:flex;align-items:center;gap:8px">
                <span class="badge badge-pending">Pending</span>
                <strong><?= $statusCounts['pending'] ?></strong>
            </div>
            <div style="display:flex;align-items:center;gap:8px">
                <span class="badge badge-confirmed">Confirmed</span>
                <strong><?= $statusCounts['confirmed'] ?></strong>
            </div>
            <div style="display:flex;align-items:center;gap:8px">
                <span class="badge badge-completed">Completed</span>
                <strong><?= $statusCounts['completed'] ?></strong>
            </div>
            <div style="display:flex;align-items:center;gap:8px">
                <span class="badge badge-cancelled">Cancelled</span>
                <strong><?= $statusCounts['cancelled'] ?></strong>
            </div>
        </div>
    </div>
</div>

<!-- Recent Orders -->
<div class="card">
    <div class="card-header">
        <span class="card-title">Recent Orders</span>
        <a href="<?= BASE_URL ?>/orders" class="btn btn-secondary btn-sm">View All</a>
    </div>
    <?php if (empty($recentOrders)): ?>
    <div class="card-body">
        <div class="empty-state">
            <span class="empty-state-icon">📋</span>
            <h3>No orders yet</h3>
            <p>Create your first order to get started.</p>
            <a href="<?= BASE_URL ?>/orders/create" class="btn btn-primary">Create Order</a>
        </div>
    </div>
    <?php else: ?>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Order Ref</th>
                    <th>Supplier</th>
                    <th>Pickup Location</th>
                    <th>Date</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($recentOrders as $order): ?>
                <tr>
                    <td><span class="order-ref"><?= sanitize($order['order_ref']) ?></span></td>
                    <td><?= sanitize($order['supplier_name']) ?></td>
                    <td><?= sanitize($order['pickup_location']) ?></td>
                    <td><?= date('d M Y', strtotime($order['pickup_date'])) ?></td>
                    <td><strong><?= formatRWF((float)$order['subtotal']) ?></strong></td>
                    <td><span class="badge badge-<?= $order['status'] ?>"><?= ucfirst($order['status']) ?></span></td>
                    <td>
                        <a href="<?= BASE_URL ?>/orders/view?id=<?= $order['id'] ?>" class="btn btn-secondary btn-sm">View</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>
</div>

<?php require __DIR__ . '/../partials/footer.php'; ?>
