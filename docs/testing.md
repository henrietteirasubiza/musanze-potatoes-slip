# Testing Checklist — Musanze Market Order Slip

## Phase 4 Testing Evidence

| # | Test Case | Expected Result | Status |
|---|---|---|---|

| T-01 | Register supplier with all required fields | Supplier saved, success message, appears in list | ✅ Pass |
| T-02 | Register supplier without phone number | Form error: "Phone number is required" | ✅ Pass |
| T-03 | Create order with two items, valid data | Order saved, redirected to detail view with correct total | ✅ Pass |
| T-04 | Create order with qty = 0 | Server-side error: "Quantity must be > 0" | ✅ Pass |
| T-05 | Live total calculator (JS) | Typing in qty/price fields updates line total and grand total instantly | ✅ Pass |
| T-06 | Add / remove item rows dynamically | Rows added/removed correctly; total recalculates | ✅ Pass |
| T-07 | Update order status from pending → confirmed | Status badge updates; flash message shown | ✅ Pass |
| T-8 | Open receipt page and trigger browser print | Print stylesheet hides nav/sidebar; receipt renders cleanly | ✅ Pass |
| T-9 | Delete supplier that has existing orders | Database constraint prevents delete; error message shown | ✅ Pass |
| T-10 | Attempt to access /orders without login | Redirected to /login | ✅ Pass |
| T-11 | Attempt SQL injection in supplier name field | Prepared statement neutralizes attack; data stored safely | ✅ Pass |
| T-12 | View dashboard after creating 3 orders | Today's count and value update correctly | ✅ Pass |
| T-13 | Responsive layout on 375px viewport | Sidebar collapses; menu toggle works; tables scroll horizontally | ✅ Pass |

## Notes
- All tests performed on PHP 8.1 + MySQL 8.0
- Browser tested: Chrome 120, Firefox 121, Mobile Safari (iPhone 14)
- Prepared statements verified using MySQLi `prepare()` + `bind_param()` — no raw string interpolation in SQL
