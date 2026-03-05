<?php
// app/models/SupplierModel.php

class SupplierModel {
    private mysqli $db;

    public function __construct() {
        $this->db = getDBConnection();
    }

    public function getAll(): array {
        $sql = "SELECT * FROM suppliers ORDER BY full_name ASC";
        $result = $this->db->query($sql);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function getById(int $id): ?array {
        $stmt = $this->db->prepare("SELECT * FROM suppliers WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $row ?: null;
    }

    public function create(array $data): bool {
        $stmt = $this->db->prepare(
            "INSERT INTO suppliers (full_name, phone, location, national_id, cooperative)
             VALUES (?, ?, ?, ?, ?)"
        );
        $stmt->bind_param(
            'sssss',
            $data['full_name'], $data['phone'], $data['location'],
            $data['national_id'], $data['cooperative']
        );
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }

    public function update(int $id, array $data): bool {
        $stmt = $this->db->prepare(
            "UPDATE suppliers SET full_name=?, phone=?, location=?, national_id=?, cooperative=?
             WHERE id=?"
        );
        $stmt->bind_param(
            'sssssi',
            $data['full_name'], $data['phone'], $data['location'],
            $data['national_id'], $data['cooperative'], $id
        );
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }

    public function delete(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM suppliers WHERE id = ?");
        $stmt->bind_param('i', $id);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }

    public function getTotalCount(): int {
        $result = $this->db->query("SELECT COUNT(*) AS cnt FROM suppliers");
        return (int)($result->fetch_assoc()['cnt'] ?? 0);
    }
}
