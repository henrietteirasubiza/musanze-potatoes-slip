<?php
// app/views/orders/view.php
$pageTitle = 'Order ' . $order['order_ref'];
require __DIR__ . '/../partials/header.php';
?>

<div class="page-header">
    <div>
        <h1>Order <span class="order-ref" style="font-size:20px"><?= sanitize($order['order_ref']) ?></span></h1>
        <p>Created <?= date('d M Y, H:i', strtotime($order['created_at'])) ?> by <?= sanitize($order['created_by_name']) ?></p>
    </div>
    <div style="display:flex;gap:8px;flex-wrap:wrap">
        <a href="<?= BASE_URL ?>/orders/receipt?id=<?= $order['id'] ?>" class="btn btn-secondary" target="_blank">🧾 Print Receipt</a>
        <a href="<?= BASE_URL ?>/orders" class="btn btn-secondary">← Orders</a>
    </div>
</div>

<!-- Status Update -->
<div class="card" style="margin-bottom:20px">
    <div class="card-header">
        <span class="card-title">Order Status</span>
        <span class="badge badge-<?= $order['status'] ?>" style="font-size:13px"><?= ucfirst($order['status']) ?></span>
    </div>
    <div class="card-body">
        <form method="POST" action="<?= BASE_URL ?>/orders/status" style="display:flex;align-items:center;gap:12px;flex-wrap:wrap">
            <input type="hidden" name="id" value="<?= $order['id'] ?>">
            <label for="status" class="form-label" style="margin:0;white-space:nowrap">Update status:</label>
            <select id="status" name="status" class="form-control" style="max-width:200px">
                <?php foreach (['pending','confirmed','completed','cancelled'] as $s): ?>
                <option value="<?= $s ?>" <?= $order['status'] === $s ? 'selected' : '' ?>><?= ucfirst($s) ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="btn btn-primary btn-sm">Update</button>
        </form>
    </div>
</div>

<!-- Order Info -->
<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:20px" class="detail-grid">
    <div class="card">
        <div class="card-header"><span class="card-title">👨‍🌾 Supplier Information</span></div>
        <div class="card-body">
            <div class="detail-row">
                <span class="detail-label">Full Name</span>
                <span class="detail-value"><strong><?= sanitize($order['supplier_name']) ?></strong></span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Phone</span>
                <span class="detail-value"><?= sanitize($order['supplier_phone']) ?></span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Location</span>
                <span class="detail-value"><?= sanitize($order['supplier_location']) ?></span>
            </div>
            <?php if ($order['supplier_cooperative']): ?>
            <div class="detail-row">
                <span class="detail-label">Cooperative</span>
                <span class="detail-value"><?= sanitize($order['supplier_cooperative']) ?></span>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="card">
        <div class="card-header"><span class="card-title">📦 Delivery Details</span></div>
        <div class="card-body">
            <div class="detail-row">
                <span class="detail-label">Pickup Location</span>
                <span class="detail-value"><strong><?= sanitize($order['pickup_location']) ?></strong></span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Pickup Date</span>
                <span class="detail-value"><?= date('l, d F Y', strtotime($order['pickup_date'])) ?></span>
            </div>
            <?php if ($order['notes']): ?>
            <div class="detail-row">
                <span class="detail-label">Notes</span>
                <span class="detail-value"><?= nl2br(sanitize($order['notes'])) ?></span>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Items -->
<div class="card">
    <div class="card-header"><span class="card-title">📋 Order Items</span></div>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Unit</th>
                    <th>Unit Price</th>
                    <th>Line Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $i => $item): ?>
                <tr>
                    <td style="color:var(--c-subtle);font-family:var(--font-mono);font-size:12px"><?= $i + 1 ?></td>
                    <td><strong><?= sanitize($item['product_name']) ?></strong></td>
                    <td><?= number_format((float)$item['quantity'], 2) ?></td>
                    <td><?= sanitize($item['unit']) ?></td>
                    <td><?= formatRWF((float)$item['unit_price']) ?></td>
                    <td><strong><?= formatRWF((float)$item['line_total']) ?></strong></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5" style="text-align:right;font-weight:700;padding:14px;font-size:15px">TOTAL:</td>
                    <td style="font-size:18px;font-weight:700;font-family:var(--font-mono);color:var(--c-green)">
                        <?= formatRWF((float)$order['subtotal']) ?>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<div style="margin-bottom:32px">
    <form method="POST" action="<?= BASE_URL ?>/orders/delete" style="display:inline">
        <input type="hidden" name="id" value="<?= $order['id'] ?>">
        <button type="submit" class="btn btn-danger"
                data-confirm="Permanently delete order <?= sanitize($order['order_ref']) ?>? This cannot be undone.">
            🗑 Delete Order
        </button>
    </form>
</div>

<?php require __DIR__ . '/../partials/footer.php'; ?>
