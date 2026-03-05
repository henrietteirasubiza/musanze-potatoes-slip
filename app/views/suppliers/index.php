<?php
// app/views/suppliers/index.php
$pageTitle = 'Suppliers';
require __DIR__ . '/../partials/header.php';
?>

<div class="page-header">
    <div>
        <h1>Suppliers</h1>
        <p>Registered farmers and cooperatives</p>
    </div>
    <a href="<?= BASE_URL ?>/suppliers/create" class="btn btn-primary">+ Add Supplier</a>
</div>

<div class="card">
    <?php if (empty($suppliers)): ?>
    <div class="card-body">
        <div class="empty-state">
            <span class="empty-state-icon">👨‍🌾</span>
            <h3>No suppliers registered</h3>
            <p>Add your first supplier to start creating orders.</p>
            <a href="<?= BASE_URL ?>/suppliers/create" class="btn btn-primary">Add Supplier</a>
        </div>
    </div>
    <?php else: ?>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Full Name</th>
                    <th>Phone</th>
                    <th>Location</th>
                    <th>Cooperative</th>
                    <th>Registered</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($suppliers as $i => $s): ?>
                <tr>
                    <td style="color:var(--c-subtle);font-family:var(--font-mono);font-size:12px"><?= $i + 1 ?></td>
                    <td><strong><?= sanitize($s['full_name']) ?></strong></td>
                    <td><?= sanitize($s['phone']) ?></td>
                    <td><?= sanitize($s['location']) ?></td>
                    <td><?= $s['cooperative'] ? sanitize($s['cooperative']) : '<span style="color:var(--c-subtle)">—</span>' ?></td>
                    <td style="font-family:var(--font-mono);font-size:12px"><?= date('d M Y', strtotime($s['created_at'])) ?></td>
                    <td>
                        <div style="display:flex;gap:6px">
                            <a href="<?= BASE_URL ?>/suppliers/edit?id=<?= $s['id'] ?>" class="btn btn-secondary btn-sm">Edit</a>
                            <form method="POST" action="<?= BASE_URL ?>/suppliers/delete" style="display:inline">
                                <input type="hidden" name="id" value="<?= $s['id'] ?>">
                                <button type="submit" class="btn btn-danger btn-sm"
                                        data-confirm="Delete supplier '<?= sanitize($s['full_name']) ?>'? This cannot be undone.">
                                    Delete
                                </button>
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
