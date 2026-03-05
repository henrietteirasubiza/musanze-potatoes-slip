<?php
// app/views/suppliers/create.php
$pageTitle = 'Add Supplier';
$supplier  = $supplier ?? [];
require __DIR__ . '/../partials/header.php';
?>

<div class="page-header">
    <div>
        <h1>Register Supplier</h1>
        <p>Add a new farmer or cooperative to the system</p>
    </div>
    <a href="<?= BASE_URL ?>/suppliers" class="btn btn-secondary">← Back</a>
</div>

<div class="card" style="max-width:700px">
    <div class="card-body">
        <form method="POST" action="<?= BASE_URL ?>/suppliers/store" data-validate>
            <div class="form-grid">
                <div class="form-group col-span-2">
                    <label for="full_name" class="form-label">Full Name <span class="req">*</span></label>
                    <input type="text" id="full_name" name="full_name"
                           class="form-control"
                           placeholder="e.g. Marie Uwimana"
                           value="<?= sanitize($supplier['full_name'] ?? '') ?>" required>
                </div>
                <div class="form-group">
                    <label for="phone" class="form-label">Phone Number <span class="req">*</span></label>
                    <input type="tel" id="phone" name="phone"
                           class="form-control"
                           placeholder="+250 788 000 000"
                           value="<?= sanitize($supplier['phone'] ?? '') ?>" required>
                </div>
                <div class="form-group">
                    <label for="location" class="form-label">Location / Sector <span class="req">*</span></label>
                    <input type="text" id="location" name="location"
                           class="form-control"
                           placeholder="e.g. Kinigi Sector"
                           value="<?= sanitize($supplier['location'] ?? '') ?>" required>
                </div>
                <div class="form-group">
                    <label for="national_id" class="form-label">National ID <span style="color:var(--c-subtle);font-weight:400">(optional)</span></label>
                    <input type="text" id="national_id" name="national_id"
                           class="form-control"
                           placeholder="16-digit ID number"
                           value="<?= sanitize($supplier['national_id'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label for="cooperative" class="form-label">Cooperative <span style="color:var(--c-subtle);font-weight:400">(optional)</span></label>
                    <input type="text" id="cooperative" name="cooperative"
                           class="form-control"
                           placeholder="e.g. Kinigi Potato Coop"
                           value="<?= sanitize($supplier['cooperative'] ?? '') ?>">
                </div>
            </div>

            <div style="display:flex;gap:10px;margin-top:24px">
                <button type="submit" class="btn btn-primary">Register Supplier</button>
                <a href="<?= BASE_URL ?>/suppliers" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php require __DIR__ . '/../partials/footer.php'; ?>
