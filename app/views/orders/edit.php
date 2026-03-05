<?php
// app/views/orders/edit.php
$pageTitle = 'Edit Order';
require __DIR__ . '/../partials/header.php';
?>
<div class="page-header">
    <div>
        <h1>Edit Order</h1>
        <p>Update status for <span class="order-ref"><?= sanitize($order['order_ref']) ?></span></p>
    </div>
    <a href="<?= BASE_URL ?>/orders/view?id=<?= $order['id'] ?>" class="btn btn-secondary">← Back</a>
</div>

<div class="card" style="max-width:500px">
    <div class="card-body">
        <form method="POST" action="<?= BASE_URL ?>/orders/update">
            <input type="hidden" name="id" value="<?= $order['id'] ?>">
            <div class="form-group" style="margin-bottom:20px">
                <label for="status" class="form-label">Order Status <span class="req">*</span></label>
                <select id="status" name="status" class="form-control" required>
                    <?php foreach (['pending','confirmed','completed','cancelled'] as $s): ?>
                    <option value="<?= $s ?>" <?= $order['status'] === $s ? 'selected' : '' ?>><?= ucfirst($s) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div style="display:flex;gap:10px">
                <button type="submit" class="btn btn-primary">Save Changes</button>
                <a href="<?= BASE_URL ?>/orders/view?id=<?= $order['id'] ?>" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
<?php require __DIR__ . '/../partials/footer.php'; ?>
