<?php
// app/views/orders/create.php
$pageTitle = 'Create Order';
require __DIR__ . '/../partials/header.php';
?>

<div class="page-header">
    <div>
        <h1>Create Order Slip</h1>
        <p>Record a new potato delivery order</p>
    </div>
    <a href="<?= BASE_URL ?>/orders" class="btn btn-secondary">← Back</a>
</div>

<form method="POST" action="<?= BASE_URL ?>/orders/store" data-validate>

    <!-- Order Details -->
    <div class="card">
        <div class="card-header"><span class="card-title">Order Details</span></div>
        <div class="card-body">
            <div class="form-grid">
                <div class="form-group col-span-2">
                    <label for="supplier_id" class="form-label">Supplier / Farmer <span class="req">*</span></label>
                    <select id="supplier_id" name="supplier_id" class="form-control" required>
                        <option value="">— Select a supplier —</option>
                        <?php foreach ($suppliers as $s): ?>
                        <option value="<?= $s['id'] ?>"
                            <?= ($_POST['supplier_id'] ?? '') == $s['id'] ? 'selected' : '' ?>>
                            <?= sanitize($s['full_name']) ?> — <?= sanitize($s['location']) ?>
                            <?= $s['cooperative'] ? '(' . sanitize($s['cooperative']) . ')' : '' ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                    <span class="form-hint">
                        Supplier not listed?
                        <a href="<?= BASE_URL ?>/suppliers/create" target="_blank">Register them first →</a>
                    </span>
                </div>
                <div class="form-group">
                    <label for="pickup_location" class="form-label">Pickup Location <span class="req">*</span></label>
                    <input type="text" id="pickup_location" name="pickup_location"
                           class="form-control"
                           placeholder="e.g. Musanze Central Market Gate B"
                           value="<?= sanitize($_POST['pickup_location'] ?? '') ?>" required>
                </div>
                <div class="form-group">
                    <label for="pickup_date" class="form-label">Pickup Date <span class="req">*</span></label>
                    <input type="date" id="pickup_date" name="pickup_date"
                           class="form-control"
                           value="<?= sanitize($_POST['pickup_date'] ?? date('Y-m-d')) ?>" required>
                </div>
                <div class="form-group col-span-2">
                    <label for="notes" class="form-label">Notes <span style="color:var(--c-subtle);font-weight:400">(optional)</span></label>
                    <textarea id="notes" name="notes" class="form-control"
                              placeholder="Any special instructions, grade requirements, transport details..."><?= sanitize($_POST['notes'] ?? '') ?></textarea>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Items -->
    <div class="card">
        <div class="card-header">
            <span class="card-title">Order Items</span>
            <button type="button" id="add-item-btn" class="btn btn-secondary btn-sm">+ Add Row</button>
        </div>
        <div class="card-body">
            <div class="items-table-wrap">
                <table id="items-table">
                    <thead>
                        <tr>
                            <th style="width:35%">Product Name</th>
                            <th style="width:14%">Quantity</th>
                            <th style="width:12%">Unit</th>
                            <th style="width:18%">Unit Price (RWF)</th>
                            <th style="width:15%">Line Total</th>
                            <th style="width:6%"></th>
                        </tr>
                    </thead>
                    <tbody id="items-body">
                        <tr>
                            <td>
                                <input type="text" name="product_name[]"
                                       class="form-control"
                                       placeholder="e.g. Irish Potato (Grade A)"
                                       value="<?= sanitize(($_POST['product_name'] ?? [''])[0] ?? '') ?>"
                                       required>
                            </td>
                            <td>
                                <input type="number" name="quantity[]"
                                       class="form-control qty-input"
                                       placeholder="0" min="0.01" step="0.01"
                                       value="<?= sanitize(($_POST['quantity'] ?? [''])[0] ?? '') ?>"
                                       required>
                            </td>
                            <td>
                                <select name="unit[]" class="form-control">
                                    <option value="kg">kg</option>
                                    <option value="ton">ton</option>
                                    <option value="bag">bag</option>
                                    <option value="piece">piece</option>
                                </select>
                            </td>
                            <td>
                                <input type="number" name="unit_price[]"
                                       class="form-control price-input"
                                       placeholder="0" min="1" step="1"
                                       value="<?= sanitize(($_POST['unit_price'] ?? [''])[0] ?? '') ?>"
                                       required>
                            </td>
                            <td><span class="line-total-display">RWF 0</span></td>
                            <td>
                                <button type="button" class="remove-row-btn" title="Remove">×</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="total-summary">
                <div class="total-box">
                    <div class="total-label">Order Total</div>
                    <div class="total-amount" id="grand-total">RWF 0</div>
                </div>
            </div>
        </div>
    </div>

    <div style="display:flex;gap:10px;margin-bottom:32px">
        <button type="submit" class="btn btn-primary" style="font-size:16px;padding:12px 28px">
            ✓ Create Order
        </button>
        <a href="<?= BASE_URL ?>/orders" class="btn btn-secondary">Cancel</a>
    </div>

</form>

<?php require __DIR__ . '/../partials/footer.php'; ?>
