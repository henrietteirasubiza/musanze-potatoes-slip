<?php
// app/controllers/SupplierController.php

class SupplierController {
    private SupplierModel $model;

    public function __construct() {
        $this->model = new SupplierModel();
    }

    public function index(): void {
        $suppliers = $this->model->getAll();
        $flash     = getFlash();
        require __DIR__ . '/../views/suppliers/index.php';
    }

    public function create(): void {
        require __DIR__ . '/../views/suppliers/create.php';
    }

    public function store(): void {
        $data   = $this->extractAndValidate();
        $errors = $data['errors'];
        unset($data['errors']);

        if (!empty($errors)) {
            $flash = ['type' => 'error', 'message' => implode('<br>', $errors)];
            require __DIR__ . '/../views/suppliers/create.php';
            return;
        }

        if ($this->model->create($data)) {
            flashMessage('success', 'Supplier registered successfully.');
        } else {
            flashMessage('error', 'Failed to register supplier. Try again.');
        }
        redirect('/suppliers');
    }

    public function edit(): void {
        $id       = (int)($_GET['id'] ?? 0);
        $supplier = $this->model->getById($id);
        if (!$supplier) { flashMessage('error', 'Supplier not found.'); redirect('/suppliers'); }
        require __DIR__ . '/../views/suppliers/edit.php';
    }

    public function update(): void {
        $id     = (int)($_POST['id'] ?? 0);
        $data   = $this->extractAndValidate();
        $errors = $data['errors'];
        unset($data['errors']);

        if (!empty($errors)) {
            $supplier = array_merge(['id' => $id], $data);
            $flash    = ['type' => 'error', 'message' => implode('<br>', $errors)];
            require __DIR__ . '/../views/suppliers/edit.php';
            return;
        }

        if ($this->model->update($id, $data)) {
            flashMessage('success', 'Supplier updated successfully.');
        } else {
            flashMessage('error', 'Update failed.');
        }
        redirect('/suppliers');
    }

    public function delete(): void {
        $id = (int)($_POST['id'] ?? 0);
        if ($this->model->delete($id)) {
            flashMessage('success', 'Supplier removed.');
        } else {
            flashMessage('error', 'Cannot delete supplier — they may have existing orders.');
        }
        redirect('/suppliers');
    }

    private function extractAndValidate(): array {
        $data   = [
            'full_name'   => sanitize($_POST['full_name']   ?? ''),
            'phone'       => sanitize($_POST['phone']       ?? ''),
            'location'    => sanitize($_POST['location']    ?? ''),
            'national_id' => sanitize($_POST['national_id'] ?? ''),
            'cooperative' => sanitize($_POST['cooperative'] ?? ''),
        ];
        $errors = [];
        if (empty($data['full_name']))  $errors[] = 'Full name is required.';
        if (empty($data['phone']))      $errors[] = 'Phone number is required.';
        if (empty($data['location']))   $errors[] = 'Location is required.';
        if (!preg_match('/^\+?[0-9\s\-]{7,20}$/', $data['phone'])) {
            $errors[] = 'Phone number format is invalid.';
        }
        $data['errors'] = $errors;
        return $data;
    }
}
