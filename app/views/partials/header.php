<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? APP_NAME ?> — Musanze Market</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
</head>
<body>

<nav class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <div class="brand-icon">🥔</div>
        <div class="brand-text">
            <span class="brand-name">Musanze</span>
            <span class="brand-sub">Market Orders</span>
        </div>
    </div>

    <ul class="nav-list">
        <li class="nav-item <?= str_contains($_SERVER['REQUEST_URI'], '/dashboard') || $_SERVER['REQUEST_URI'] === BASE_URL . '/' ? 'active' : '' ?>">
            <a href="<?= BASE_URL ?>/dashboard" class="nav-link">
                <span class="nav-icon">◈</span> Dashboard
            </a>
        </li>
        <li class="nav-item <?= str_contains($_SERVER['REQUEST_URI'], '/orders') ? 'active' : '' ?>">
            <a href="<?= BASE_URL ?>/orders" class="nav-link">
                <span class="nav-icon">◧</span> Orders
            </a>
        </li>
        <li class="nav-item <?= str_contains($_SERVER['REQUEST_URI'], '/suppliers') ? 'active' : '' ?>">
            <a href="<?= BASE_URL ?>/suppliers" class="nav-link">
                <span class="nav-icon">◦</span> Suppliers
            </a>
        </li>
    </ul>

    <div class="sidebar-footer">
        <div class="user-badge">
            <div class="user-avatar">M</div>
            <div class="user-info">
                <span class="user-name">Musanze Market</span>
                <span class="user-role">Admin</span>
            </div>
        </div>
    </div>
</nav>

<div class="main-wrapper">
    <header class="topbar">
        <button class="menu-toggle" id="menuToggle" aria-label="Toggle menu">
            <span></span><span></span><span></span>
        </button>
        <div class="topbar-title"><?= $pageTitle ?? 'Dashboard' ?></div>
        <div class="topbar-right">
            <span class="date-badge"><?= date('D, d M Y') ?></span>
        </div>
    </header>

    <main class="content">
        <?php
        $flash = $flash ?? getFlash();
        if ($flash): ?>
        <div class="alert alert--<?= $flash['type'] === 'success' ? 'success' : 'error' ?>">
            <?= $flash['message'] ?>
        </div>
        <?php endif; ?>
