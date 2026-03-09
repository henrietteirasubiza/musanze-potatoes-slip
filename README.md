# Musanze Market Order Slip System

A full-stack PHP/MySQL MVC web application for managing potato order slips in Musanze District, Rwanda.

**INES Assignment #2 — Project A**  
Faculty of Sciences and Information Technology · Department of Computer Science

---

## Tech Stack

- **Backend**: PHP 8.0+, MVC architecture (no frameworks)
- **Database**: MySQL 8.0 via MySQLi (prepared statements only)
- **Frontend**: HTML5, CSS3 (Flexbox/Grid), Vanilla JavaScript
- **Hosting**: InfinityFree / 000webhost (PHP + MySQL)
- **Version control**: Git / GitHub

---

## Features

- ✅ Supplier/farmer CRUD (Create, Read, Update, Delete)
- ✅ Order creation with multiple line items
- ✅ Real-time total calculator (JavaScript)
- ✅ Server-side validation + prepared statements
- ✅ Printable receipt page (print CSS)
- ✅ Order status management (pending → confirmed → completed → cancelled)
- ✅ Dashboard: today's orders, total value, status breakdown, recent orders
- ✅ Responsive design (mobile, tablet, desktop)
- ✅ MVC separation (controllers / models / views)
- ✅ DB transactions for multi-table writes

---

## Project Structure

```
musanze-market/
├── app/
│   ├── controllers/
│   │   ├── AuthController.php
│   │   ├── DashboardController.php
│   │   ├── OrderController.php
│   │   └── SupplierController.php
│   ├── models/
│   │   ├── OrderModel.php
│   │   ├── SupplierModel.php
│   │   └── UserModel.php
│   └── views/
│       ├── auth
│       ├── dashboard/index.php
│       ├── orders/{index,create,view,edit,receipt}.php
│       ├── suppliers/{index,create,edit}.php
│       ├── partials/{header,footer}.php
│       └── 404.php
├── assets/
│   ├── css/style.css
│   └── js/app.js
├── config/
│   ├── app.php
│   └── database.php
├── database/
│   ├── schema.sql
│   └── seed.sql
├── docs/
│   ├── planning.md
│   ├── testing.md
│   └── AI-usage.md
└── public/
    └── index.php       ← Front controller / router
```

---

## Local Setup

### Requirements
- PHP 8.0+
- MySQL 8.0+
- Apache with `mod_rewrite` enabled (or NGINX equivalent)
- XAMPP / WAMP / Laragon recommended for local dev

### Steps

1. **Clone the repo**
   ```bash
   git clone https://github.com/henrietteirasubiza/musanze-potatoes-slip
   cd musanze-market
   ```

2. **Create the database**
   ```bash
   mysql -u root -p < database/schema.sql
   mysql -u root -p musanze_market < database/seed.sql
   ```

3. **Configure DB connection**  

   ```php
   define('DB_HOST', 'localhost');
   define('DB_USER', 'root');
   define('DB_PASS', 'your_password');
   define('DB_NAME', 'musanze_market');
   ```

4. **Configure base URL**  
   Edit `config/app.php`:
   ```php
   define('BASE_URL', '/musanze-market/public'); // local
   // define('BASE_URL', ''); // production root
   ```

5. **Configure Apache**  
   Place in `public/.htaccess` (already included):
   ```apacheconf
   RewriteEngine On
   RewriteCond %{REQUEST_FILENAME} !-f
   RewriteCond %{REQUEST_FILENAME} !-d
   RewriteRule ^(.*)$ index.php [QSA,L]
   ```
## Deployment (InfinityFree)

1. Create account at [infinityfree.net](https://infinityfree.net)
2. Create a hosting account + MySQL database
3. Upload files via FTP (FileZilla) to `htdocs/`
4. Import `database/schema.sql` and `database/seed.sql` via phpMyAdmin
5. Update `config/database.php` with InfinityFree MySQL credentials
6. Update `config/app.php`: set `BASE_URL` to `''` (empty) or your subdomain path
7. Ensure `.htaccess` is uploaded to `public/`

**Hosting provider**: InfinityFree  
**Live URL**: _https://musanzeorderslip.infinityfree.me  
**GitHub repo**:https://github.com/henrietteirasubiza/musanze-potatoes-slip

---

## Group Members

| Name | Role |
|---|---|
| umugaba honore | Role 1 — Product Planner & Documentation Lead |
| yussif elisidig  | Role 2 — UI/UX Designer |
| umugaba honore | Role 3 — HTML Structure Engineer |
| mwiseneza kelly | Role 4 — CSS & Responsiveness Engineer |
| iradukunda pauline | Role 5 — JavaScript Interaction Engineer |
| ahmed fadul | Role 6 — Backend PHP MVC Engineer |
| irasubiza henriette| Role 7 — Database, Git & Deployment Engineer |
