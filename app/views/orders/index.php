<?php
// app/views/orders/index.php
$pageTitle = 'Orders';
require __DIR__ . '/../partials/header.php';
?>

<div class="page-header">
    <div>
        <h1>All Orders</h1>
        <p><?= count($orders) ?> order<?= count($orders) !== 1 ? 's' : '' ?> in the system</p>
    </div>
    <a href="<?= BASE_URL ?>/orders/create" class="btn btn-primary">+ New Order</a>
</div>

<div class="card">
    <?php if (empty($orders)): ?>
    <div class="card-body">
        <div class="empty-state">
            <span class="empty-state-icon">📋</span>
            <h3>No orders yet</h3>
            <p>Create your first order slip to track potato deliveries.</p>
            <a href="<?= BASE_URL ?>/orders/create" class="btn btn-primary">Create First Order</a>
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
                    <th>Pickup Date</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Created By</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $o): ?>
                <tr>
                    <td><span class="order-ref"><?= sanitize($o['order_ref']) ?></span></td>
                    <td>
                        <strong><?= sanitize($o['supplier_name']) ?></strong><br>
                        <small style="color:var(--c-subtle)"><?= sanitize($o['supplier_phone']) ?></small>
                    </td>
                    <td><?= sanitize($o['pickup_location']) ?></td>
                    <td style="white-space:nowrap"><?= date('d M Y', strtotime($o['pickup_date'])) ?></td>
                    <td><strong><?= formatRWF((float)$o['subtotal']) ?></strong></td>
                    <td><span class="badge badge-<?= $o['status'] ?>"><?= ucfirst($o['status']) ?></span></td>
                    <td style="font-size:13px"><?= sanitize($o['created_by_name']) ?></td>
                    <td>
                        <div style="display:flex;gap:5px">
                            <a href="<?= BASE_URL ?>/orders/view?id=<?= $o['id'] ?>" class="btn btn-secondary btn-sm">View</a>
                            <a href="<?= BASE_URL ?>/orders/receipt?id=<?= $o['id'] ?>" class="btn btn-secondary btn-sm" title="Receipt">🧾</a>
                            <form method="POST" action="<?= BASE_URL ?>/orders/delete" style="display:inline">
                                <input type="hidden" name="id" value="<?= $o['id'] ?>">
                                <button type="submit" class="btn btn-danger btn-sm"
                                        data-confirm="Delete order <?= sanitize($o['order_ref']) ?>?">✕</button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>
</div>

<?php require __DIR__ . '/../partials/footer.php'; ?>
