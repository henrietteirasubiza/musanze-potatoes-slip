<?php
// app/views/suppliers/edit.php
$pageTitle = 'Edit Supplier';
require __DIR__ . '/../partials/header.php';
?>

<div class="page-header">
    <div>
        <h1>Edit Supplier</h1>
        <p>Update supplier information</p>
    </div>
    <a href="<?= BASE_URL ?>/suppliers" class="btn btn-secondary">← Back</a>
</div>

<div class="card" style="max-width:700px">
    <div class="card-body">
        <form method="POST" action="<?= BASE_URL ?>/suppliers/update" data-validate>
            <input type="hidden" name="id" value="<?= $supplier['id'] ?>">
            <div class="form-grid">
                <div class="form-group col-span-2">
                    <label for="full_name" class="form-label">Full Name <span class="req">*</span></label>
                    <input type="text" id="full_name" name="full_name"
                           class="form-control"
                           value="<?= sanitize($supplier['full_name']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="phone" class="form-label">Phone Number <span class="req">*</span></label>
                    <input type="tel" id="phone" name="phone"
                           class="form-control"
                           value="<?= sanitize($supplier['phone']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="location" class="form-label">Location / Sector <span class="req">*</span></label>
                    <input type="text" id="location" name="location"
                           class="form-control"
                           value="<?= sanitize($supplier['location']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="national_id" class="form-label">National ID</label>
                    <input type="text" id="national_id" name="national_id"
                           class="form-control"
                           value="<?= sanitize($supplier['national_id'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label for="cooperative" class="form-label">Cooperative</label>
                    <input type="text" id="cooperative" name="cooperative"
                           class="form-control"
                           value="<?= sanitize($supplier['cooperative'] ?? '') ?>">
                </div>
            </div>
            <div style="display:flex;gap:10px;margin-top:24px">
                <button type="submit" class="btn btn-primary">Save Changes</button>
                <a href="<?= BASE_URL ?>/suppliers" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php require __DIR__ . '/../partials/footer.php'; ?>
