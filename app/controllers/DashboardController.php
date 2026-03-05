<?php
// app/controllers/DashboardController.php

class DashboardController {
    private OrderModel   $orderModel;
    private SupplierModel $supplierModel;

    public function __construct() {
        $this->orderModel    = new OrderModel();
        $this->supplierModel = new SupplierModel();
    }

    public function index(): void {
        $todayStats     = $this->orderModel->getTodayStats();
        $statusCounts   = $this->orderModel->getStatusCounts();
        $totalValue     = $this->orderModel->getTotalValue();
        $recentOrders   = $this->orderModel->getRecent(6);
        $totalSuppliers = $this->supplierModel->getTotalCount();
        $flash          = getFlash();
        require __DIR__ . '/../views/dashboard/index.php';
    }
}
