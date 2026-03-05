<?php
// app/views/auth/login.php
$pageTitle = 'Login';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Musanze Market</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
</head>
<body>
<div class="login-page">
    <div class="login-container">
        <div class="login-logo">
            <span class="login-logo-icon">🥔</span>
            <h1>Musanze Market</h1>
            <p>Order Slip Management System</p>
        </div>

        <div class="login-card">
            <h2>Sign in to your account</h2>

            <?php if ($flash ?? null): ?>
            <div class="alert alert--<?= $flash['type'] === 'success' ? 'success' : 'error' ?>">
                <?= $flash['message'] ?>
            </div>
            <?php endif; ?>

            <form method="POST" action="<?= BASE_URL ?>/login" data-validate>
                <div class="form-group" style="margin-bottom:16px">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" id="username" name="username"
                           class="form-control"
                           placeholder="Enter your username"
                           value="<?= sanitize($_POST['username'] ?? '') ?>"
                           required autocomplete="username">
                </div>
                <div class="form-group" style="margin-bottom:24px">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" id="password" name="password"
                           class="form-control"
                           placeholder="Enter your password"
                           required autocomplete="current-password">
                </div>
                <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;">
                    Sign In →
                </button>
            </form>

            <p class="login-hint">Default credentials: admin / password</p>
        </div>
    </div>
</div>
<script src="<?= BASE_URL ?>/assets/js/app.js"></script>
</body>
</html>
