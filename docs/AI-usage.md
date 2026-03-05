# AI Usage Documentation

## What we asked AI

- "Explain the difference between MVC and non-MVC PHP architecture"
- "How do MySQLi prepared statements work with bind_param?"
- "What is a generated column in MySQL?"
- "How to use PHP sessions securely (httponly, strict mode)?"
- "How to implement a simple front controller router in PHP without a framework"

## What we changed

- AI generated boilerplate for the DB connection class; we modified it to use a singleton pattern and added our actual DB name and charset settings.
- AI suggested using `password_hash()` — we applied this to the seed data manually and added the correct bcrypt hash.
- AI explained prepared statements syntax; we wrote all SQL queries ourselves from scratch following that pattern.
- The router structure was inspired by a PHP tutorial; we rewrote it as a route table array instead of nested if/else.

## What we learned

- Database transactions (`begin_transaction / commit / rollback`) are essential when inserting into multiple related tables simultaneously.
- Generated columns in MySQL (`GENERATED ALWAYS AS`) let the DB compute `line_total = quantity * unit_price` so the value is always consistent.
- PHP's `spl_autoload_register` can replace manual `require_once` calls for controllers and models.
- `htmlspecialchars()` with `ENT_QUOTES` is essential for XSS prevention in views.
- Separation of concerns: views should contain zero business logic — all data must come from controllers.
