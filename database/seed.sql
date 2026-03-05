-- Musanze Market Order Slip - Seed Data
USE musanze_market;

-- Default admin user (password: Admin@1234)
INSERT INTO users (username, email, password_hash, role, full_name, phone) VALUES
('admin', 'admin@musanzemarket.rw', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uHxL.75u2', 'admin', 'System Administrator', '+250788000001'),
('aggregator1', 'agg1@musanzemarket.rw', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uHxL.75u2', 'aggregator', 'Jean Pierre Hakizimana', '+250788000002');
-- Default password for both: password

-- Sample suppliers
INSERT INTO suppliers (full_name, phone, location, national_id, cooperative) VALUES
('Marie Uwimana', '+250788111001', 'Kinigi Sector', '1198070012345678', 'Kinigi Potato Coop'),
('Emmanuel Bizimana', '+250788111002', 'Cyuve Sector', '1197580023456789', 'Cyuve Farmers'),
('Alphonsine Mukamana', '+250788111003', 'Shingiro Sector', '1199080034567890', NULL),
('Théoneste Nshimiyimana', '+250788111004', 'Muhoza Sector', '1198580045678901', 'Muhoza Cooperative'),
('Claudette Iradukunda', '+250788111005', 'Musanze District', '1200180056789012', 'Musanze Agri Group');

-- Sample orders
INSERT INTO orders (order_ref, supplier_id, created_by, pickup_location, pickup_date, status, subtotal) VALUES
('MM-2025-0001', 1, 2, 'Musanze Central Market Gate B', '2025-03-10', 'completed', 450000.00),
('MM-2025-0002', 2, 2, 'Cyuve Collection Point', '2025-03-11', 'confirmed', 312500.00),
('MM-2025-0003', 3, 1, 'Shingiro Road Depot', '2025-03-12', 'pending', 187500.00);

-- Sample order items
INSERT INTO order_items (order_id, product_name, quantity, unit, unit_price) VALUES
(1, 'Irish Potato (Grade A)', 500, 'kg', 600.00),
(1, 'Irish Potato (Grade B)', 250, 'kg', 420.00),
(2, 'Irish Potato (Grade A)', 625, 'kg', 500.00),
(3, 'Irish Potato (Mixed)', 375, 'kg', 500.00);
