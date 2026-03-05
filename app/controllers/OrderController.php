<?php
// app/controllers/OrderController.php

class OrderController {
    private OrderModel    $model;
    private SupplierModel $supplierModel;

    public function __construct() {
        $this->model         = new OrderModel();
        $this->supplierModel = new SupplierModel();
    }

    public function index(): void {
        $orders = $this->model->getAll();
        $flash  = getFlash();
        require __DIR__ . '/../views/orders/index.php';
    }

    public function create(): void {
        $suppliers = $this->supplierModel->getAll();
        require __DIR__ . '/../views/orders/create.php';
    }

    public function store(): void {
        [$order, $items, $errors] = $this->extractAndValidate();

        if (!empty($errors)) {
            $suppliers = $this->supplierModel->getAll();
            $flash     = ['type' => 'error', 'message' => implode('<br>', $errors)];
            require __DIR__ . '/../views/orders/create.php';
            return;
        }

        $order['created_by'] = 1; // default admin user
        $newId = $this->model->create($order, $items);

        if ($newId) {
            flashMessage('success', 'Order created successfully.');
            redirect('/orders/view?id=' . $newId);
        } else {
            flashMessage('error', 'Failed to create order. Please try again.');
            redirect('/orders/create');
        }
    }

    public function view(): void {
        $id    = (int)($_GET['id'] ?? 0);
        $order = $this->model->getById($id);
        if (!$order) { flashMessage('error', 'Order not found.'); redirect('/orders'); }
        $items = $this->model->getItemsByOrderId($id);
        $flash = getFlash();
        require __DIR__ . '/../views/orders/view.php';
    }

    public function receipt(): void {
        $id    = (int)($_GET['id'] ?? 0);
        $order = $this->model->getById($id);
        if (!$order) { flashMessage('error', 'Order not found.'); redirect('/orders'); }
        $items = $this->model->getItemsByOrderId($id);
        require __DIR__ . '/../views/orders/receipt.php';
    }

    public function edit(): void {
        $id    = (int)($_GET['id'] ?? 0);
        $order = $this->model->getById($id);
        if (!$order) { flashMessage('error', 'Order not found.'); redirect('/orders'); }
        $items     = $this->model->getItemsByOrderId($id);
        $suppliers = $this->supplierModel->getAll();
        require __DIR__ . '/../views/orders/edit.php';
    }

    public function update(): void {
        $id = (int)($_POST['id'] ?? 0);
        // For this version, only status update via POST
        $status = sanitize($_POST['status'] ?? '');
        if ($this->model->updateStatus($id, $status)) {
            flashMessage('success', 'Order status updated.');
        } else {
            flashMessage('error', 'Update failed.');
        }
        redirect('/orders/view?id=' . $id);
    }

    public function updateStatus(): void {
        $id     = (int)($_POST['id'] ?? 0);
        $status = sanitize($_POST['status'] ?? '');
        if ($this->model->updateStatus($id, $status)) {
            flashMessage('success', 'Order status updated to ' . ucfirst($status) . '.');
        } else {
            flashMessage('error', 'Status update failed.');
        }
        redirect('/orders/view?id=' . $id);
    }

    public function delete(): void {
        $id = (int)($_POST['id'] ?? 0);
        if ($this->model->delete($id)) {
            flashMessage('success', 'Order deleted.');
        } else {
            flashMessage('error', 'Delete failed.');
        }
        redirect('/orders');
    }

    private function extractAndValidate(): array {
        $errors = [];

        $order = [
            'supplier_id'      => (int)($_POST['supplier_id']   ?? 0),
            'pickup_location'  => sanitize($_POST['pickup_location'] ?? ''),
            'pickup_date'      => sanitize($_POST['pickup_date']     ?? ''),
            'notes'            => sanitize($_POST['notes']           ?? ''),
        ];

        if ($order['supplier_id'] <= 0) $errors[] = 'Please select a supplier.';
        if (empty($order['pickup_location'])) $errors[] = 'Pickup location is required.';
        if (empty($order['pickup_date'])) $errors[] = 'Pickup date is required.';

        // Parse items
        $productNames = $_POST['product_name'] ?? [];
        $quantities   = $_POST['quantity']      ?? [];
        $units        = $_POST['unit']          ?? [];
        $unitPrices   = $_POST['unit_price']    ?? [];

        $items = [];
        foreach ($productNames as $i => $name) {
            $name  = sanitize($name);
            $qty   = (float)($quantities[$i] ?? 0);
            $unit  = sanitize($units[$i]     ?? 'kg');
            $price = (float)($unitPrices[$i] ?? 0);

            if (empty($name))   { $errors[] = "Product name is required for item #" . ($i + 1); continue; }
            if ($qty <= 0)      { $errors[] = "Quantity must be > 0 for \"$name\"."; continue; }
            if ($price <= 0)    { $errors[] = "Unit price must be > 0 for \"$name\"."; continue; }

            $items[] = compact('name', 'qty', 'unit', 'price') + [
                'product_name' => $name,
                'quantity'     => $qty,
                'unit'         => $unit,
                'unit_price'   => $price,
            ];
        }

        if (empty($items) && empty($errors)) {
            $errors[] = 'At least one order item is required.';
        }

        return [$order, $items, $errors];
    }
}
