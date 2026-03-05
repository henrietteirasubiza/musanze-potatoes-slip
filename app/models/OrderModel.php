<?php
// app/models/OrderModel.php

class OrderModel {
    private mysqli $db;

    public function __construct() {
        $this->db = getDBConnection();
    }

    public function getAll(int $limit = 100, int $offset = 0): array {
        $stmt = $this->db->prepare(
            "SELECT o.*, s.full_name AS supplier_name, s.phone AS supplier_phone,
                    u.full_name AS created_by_name
             FROM orders o
             JOIN suppliers s ON s.id = o.supplier_id
             JOIN users u ON u.id = o.created_by
             ORDER BY o.created_at DESC
             LIMIT ? OFFSET ?"
        );
        $stmt->bind_param('ii', $limit, $offset);
        $stmt->execute();
        $rows = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $rows;
    }

    public function getById(int $id): ?array {
        $stmt = $this->db->prepare(
            "SELECT o.*, s.full_name AS supplier_name, s.phone AS supplier_phone,
                    s.location AS supplier_location, s.cooperative AS supplier_cooperative,
                    u.full_name AS created_by_name
             FROM orders o
             JOIN suppliers s ON s.id = o.supplier_id
             JOIN users u ON u.id = o.created_by
             WHERE o.id = ?"
        );
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $row ?: null;
    }

    public function getItemsByOrderId(int $orderId): array {
        $stmt = $this->db->prepare(
            "SELECT * FROM order_items WHERE order_id = ? ORDER BY id ASC"
        );
        $stmt->bind_param('i', $orderId);
        $stmt->execute();
        $rows = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $rows;
    }

    public function create(array $order, array $items): int|false {
        $this->db->begin_transaction();
        try {
            // Compute subtotal
            $subtotal = array_reduce($items, fn($carry, $item) =>
                $carry + ($item['quantity'] * $item['unit_price']), 0.0);

            // Generate unique ref
            do {
                $ref = generateOrderRef();
                $check = $this->db->query("SELECT id FROM orders WHERE order_ref='$ref'");
            } while ($check->num_rows > 0);

            $stmt = $this->db->prepare(
                "INSERT INTO orders (order_ref, supplier_id, created_by, pickup_location, pickup_date, status, notes, subtotal)
                 VALUES (?, ?, ?, ?, ?, 'pending', ?, ?)"
            );
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $this->db->error);
            }
            $stmt->bind_param(
                'siisssd',
                $ref, $order['supplier_id'], $order['created_by'],
                $order['pickup_location'], $order['pickup_date'],
                $order['notes'], $subtotal
            );
            if (!$stmt->execute()) {
                throw new Exception("Failed to insert order: " . $stmt->error);
            }
            $orderId = $this->db->insert_id;
            $stmt->close();

            // Insert items
            $itemStmt = $this->db->prepare(
                "INSERT INTO order_items (order_id, product_name, quantity, unit, unit_price)
                 VALUES (?, ?, ?, ?, ?)"
            );
            if (!$itemStmt) {
                throw new Exception("Item prepare failed: " . $this->db->error);
            }
            foreach ($items as $item) {
                $itemStmt->bind_param(
                    'isdsd',
                    $orderId, $item['product_name'],
                    $item['quantity'], $item['unit'], $item['unit_price']
                );
                if (!$itemStmt->execute()) {
                    throw new Exception("Failed to insert order item: " . $itemStmt->error);
                }
            }
            $itemStmt->close();

            $this->db->commit();
            return $orderId;
        } catch (Exception $e) {
            $this->db->rollback();
            $error = "Database error: " . $e->getMessage() . " | SQL Error: " . $this->db->error;
            error_log($error);
            // Uncomment below temporarily to debug:
            // die($error);
            return false;
        }
    }

    public function updateStatus(int $id, string $status): bool {
        $allowed = ['pending','confirmed','completed','cancelled'];
        if (!in_array($status, $allowed)) return false;
        $stmt = $this->db->prepare("UPDATE orders SET status=? WHERE id=?");
        $stmt->bind_param('si', $status, $id);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }

    public function delete(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM orders WHERE id=?");
        $stmt->bind_param('i', $id);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }

    // Dashboard stats
    public function getTodayStats(): array {
        $today = date('Y-m-d');
        $stmt = $this->db->prepare(
            "SELECT COUNT(*) AS total_orders, COALESCE(SUM(subtotal),0) AS total_value
             FROM orders WHERE DATE(created_at) = ?"
        );
        $stmt->bind_param('s', $today);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $row;
    }

    public function getStatusCounts(): array {
        $result = $this->db->query(
            "SELECT status, COUNT(*) AS cnt FROM orders GROUP BY status"
        );
        $counts = ['pending'=>0,'confirmed'=>0,'completed'=>0,'cancelled'=>0];
        while ($row = $result->fetch_assoc()) {
            $counts[$row['status']] = (int)$row['cnt'];
        }
        return $counts;
    }

    public function getTotalValue(): float {
        $result = $this->db->query("SELECT COALESCE(SUM(subtotal),0) AS total FROM orders");
        return (float)($result->fetch_assoc()['total'] ?? 0);
    }

    public function getRecent(int $limit = 5): array {
        $stmt = $this->db->prepare(
            "SELECT o.*, s.full_name AS supplier_name
             FROM orders o JOIN suppliers s ON s.id=o.supplier_id
             ORDER BY o.created_at DESC LIMIT ?"
        );
        $stmt->bind_param('i', $limit);
        $stmt->execute();
        $rows = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $rows;
    }
}
