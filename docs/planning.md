# Phase 1 — Planning

## Problem Statement

Potato aggregators and cooperative collection points in Musanze District, Northern Province, Rwanda, currently manage order transactions through paper slips, handwritten notebooks, and informal WhatsApp messages. This fragmented approach causes:

- **Calculation errors**: Manual qty × price computations produce wrong totals, leading to monetary disputes between farmers and aggregators.
- **Missing receipts**: Paper slips are lost, soaked in rain, or destroyed, leaving no verifiable record of completed transactions.
- **Pickup disputes**: Without confirmed order details, farmers and aggregators disagree on quantities, grades, and pickup times.
- **No audit trail**: Management cannot generate daily summaries, verify payment histories, or track order trends.
- **Inaccessible records**: Data is not searchable, filterable, or accessible remotely.

The **Musanze Market Order Slip System** digitizes this workflow, creating a reliable, accessible, printed-receipt-capable order management platform for Musanze's agricultural supply chain.

---

## Stakeholders

| Stakeholder | Role | Pain Point |
|---|---|---|
| Potato Aggregator | Primary user — creates and manages orders | Calculation errors, lost slips |
| Cooperative Admin | Reviews orders, confirms deliveries | No dashboard visibility |
| Farmer / Supplier | Provides produce | Disputes at pickup time |
| System Admin | Manages users and data integrity | No audit trail |

---

## User Stories

| # | As a... | I want to... | So that... |
|---|---|---|---|
| US-01 | Aggregator | Log in securely | Only authorized users access the system |
| US-02 | Aggregator | Register a new supplier | I have their details on record before creating orders |
| US-03 | Aggregator | Create an order slip with multiple items | All quantities and prices are recorded accurately |
| US-04 | System | Auto-compute line totals and grand total | No manual arithmetic errors occur |
| US-05 | Aggregator | Generate a printable receipt | The farmer has a physical record of the transaction |
| US-06 | Aggregator | View a dashboard with today's orders and total value | I can track daily throughput at a glance |
| US-07 | Admin | Update an order's status (pending → confirmed → completed) | The lifecycle of each order is traceable |
| US-08 | Admin | Delete erroneous orders | Data remains clean and accurate |
| US-09 | Aggregator | View a list of all orders with filters by status | I can quickly find specific orders |
| US-10 | System | Validate all form inputs server-side | Malformed or malicious data cannot corrupt the database |

### Acceptance Criteria (selected)

**US-03 — Create Order Slip**
- Form includes: supplier selection, pickup location, pickup date, at least one item row
- Each item row captures: product name, quantity, unit, unit price
- System prevents submission if any required field is empty
- System prevents submission if quantity or price ≤ 0

**US-04 — Auto-compute Totals**
- JavaScript updates line totals and grand total in real time on input
- Server re-verifies totals before storing (JS is enhancement, not trust boundary)

**US-05 — Printable Receipt**
- Receipt page is clean, printer-friendly (print CSS hides navigation)
- Receipt includes: order ref, supplier details, pickup info, itemized table, total, status

---

## Scope

### In Scope
- User authentication (login/logout)
- Supplier/farmer CRUD
- Order creation with multiple line items
- Auto-computed totals (JS + server)
- Order status management
- Printable receipt page
- Dashboard (today's orders, total value, status counts, recent orders)
- Full orders list view
- Server-side validation with prepared statements
- MVC architecture
- MySQL storage

### Out of Scope
- SMS/email notifications
- Multi-currency support
- PDF export (beyond browser print)
- Mobile app
- Payment processing
- Stock/inventory management
- Multi-warehouse locations

---

## Non-Functional Requirements

| Category | Requirement |
|---|---|
| Security | All DB queries use MySQLi prepared statements; passwords hashed with bcrypt |
| Usability | Responsive layout for mobile and desktop; accessible focus states |
| Performance | Page load < 2s on standard shared hosting |
| Reliability | DB transactions used for multi-step writes (order + items) |
| Maintainability | MVC separation; no business logic in views |
| Browser support | Chrome, Firefox, Edge (latest 2 versions), Safari 15+ |
