<?php
// config/app.php

define('APP_NAME', 'Musanze Market');
define('APP_TAGLINE', 'Order Slip Management System');
define('APP_VERSION', '1.0.0');
define('BASE_URL', '/musanze-market/public'); // Change to '/' on production

define('SESSION_TIMEOUT', 3600); // 1 hour

// Start session securely
if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.cookie_httponly', 1);
    ini_set('session.use_strict_mode', 1);
    session_start();
}

// Autoload helpers
function redirect(string $path): void {
    header('Location: ' . BASE_URL . $path);
    exit;
}

function isLoggedIn(): bool {
    return isset($_SESSION['user_id']) && isset($_SESSION['user_role']);
}

function requireLogin(): void {
    if (!isLoggedIn()) {
        redirect('/login');
    }
}

function requireAdmin(): void {
    requireLogin();
    if ($_SESSION['user_role'] !== 'admin') {
        redirect('/dashboard');
    }
}

function sanitize(string $val): string {
    return htmlspecialchars(trim($val), ENT_QUOTES, 'UTF-8');
}

function generateOrderRef(): string {
    return 'MM-' . date('Y') . '-' . str_pad(mt_rand(1, 99999), 4, '0', STR_PAD_LEFT);
}

function formatRWF(float $amount): string {
    return 'RWF ' . number_format($amount, 0, '.', ',');
}

function flashMessage(string $type, string $message): void {
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

function getFlash(): ?array {
    if (isset($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }
    return null;
}
