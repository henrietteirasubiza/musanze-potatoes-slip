<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt <?= sanitize($order['order_ref']) ?> — Musanze Market</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
</head>
<body style="background:#f0ece4;padding:24px;min-height:100vh">

<div class="receipt-page">

    <!-- Print controls -->
    <div class="no-print" style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px">
        <a href="<?= BASE_URL ?>/orders/view?id=<?= $order['id'] ?>" class="btn btn-secondary">← Back to Order</a>
        <button onclick="window.print()" class="btn btn-primary" style="font-size:15px;padding:10px 24px">
            🖨 Print Receipt
        </button>
    </div>

    <!-- Receipt Card -->
    <div class="receipt-card">

        <!-- Header -->
        <div class="receipt-header">
            <div>
                <div class="receipt-logo">🥔</div>
                <div class="receipt-org-name">Musanze Market</div>
                <div class="receipt-org-sub">Order Slip System · Musanze, Rwanda</div>
            </div>
            <div class="receipt-ref-block">
                <div class="receipt-ref"><?= sanitize($order['order_ref']) ?></div>
                <div class="receipt-date">Issued: <?= date('d F Y', strtotime($order['created_at'])) ?></div>
                <div class="receipt-date">By: <?= sanitize($order['created_by_name']) ?></div>
            </div>
        </div>

        <!-- Meta -->
        <div class="receipt-meta">
            <div class="receipt-meta-block">
                <h4>Supplier / Farmer</h4>
                <p>
                    <strong><?= sanitize($order['supplier_name']) ?></strong><br>
                    <?= sanitize($order['supplier_phone']) ?><br>
                    <?= sanitize($order['supplier_location']) ?>
                    <?php if ($order['supplier_cooperative']): ?>
                    <br><em><?= sanitize($order['supplier_cooperative']) ?></em>
                    <?php endif; ?>
                </p>
            </div>
            <div class="receipt-meta-block">
                <h4>Pickup Information</h4>
                <p>
                    <strong><?= sanitize($order['pickup_location']) ?></strong><br>
                    Date: <?= date('l, d F Y', strtotime($order['pickup_date'])) ?>
                </p>
                <?php if ($order['notes']): ?>
                <p style="margin-top:8px;font-size:12px;color:#666"><em><?= nl2br(sanitize($order['notes'])) ?></em></p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Items Table -->
        <table class="receipt-items">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Product</th>
                    <th style="text-align:right">Qty</th>
                    <th>Unit</th>
                    <th style="text-align:right">Unit Price</th>
                    <th style="text-align:right">Line Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $i => $item): ?>
                <tr>
                    <td style="color:#999;font-size:12px"><?= $i + 1 ?></td>
                    <td><strong><?= sanitize($item['product_name']) ?></strong></td>
                    <td style="text-align:right"><?= number_format((float)$item['quantity'], 2) ?></td>
                    <td><?= sanitize($item['unit']) ?></td>
                    <td style="text-align:right;font-family:'DM Mono',monospace"><?= number_format((float)$item['unit_price'], 0) ?></td>
                    <td style="text-align:right;font-family:'DM Mono',monospace;font-weight:600"><?= number_format((float)$item['line_total'], 0) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5" style="text-align:right;font-size:13px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px">
                        TOTAL (RWF)
                    </td>
                    <td class="receipt-total"><?= number_format((float)$order['subtotal'], 0) ?></td>
                </tr>
            </tfoot>
        </table>

        <!-- Status -->
        <div style="margin-top:16px">
            <?php
            $statusColors = [
                'pending'   => '#92400E',
                'confirmed' => '#1A3E5C',
                'completed' => '#1E4A22',
                'cancelled' => '#7A1F18',
            ];
            $color = $statusColors[$order['status']] ?? '#333';
            ?>
            <span class="receipt-status" style="color:<?= $color ?>;border-color:<?= $color ?>">
                <?= strtoupper($order['status']) ?>
            </span>
        </div>

        <!-- Footer -->
        <div class="receipt-footer">
            <span>Musanze Market Order Slip System</span>
            <span>Printed: <?= date('d M Y, H:i') ?></span>
            <span><?= APP_VERSION ?></span>
        </div>

    </div><!-- .receipt-card -->
</div>

<script src="<?= BASE_URL ?>/assets/js/app.js"></script>
</body>
</html>
