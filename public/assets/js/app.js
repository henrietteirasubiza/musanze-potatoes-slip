// assets/js/app.js — Musanze Market Order Slip

/* ============================================================
   Menu Toggle (mobile sidebar)
   ============================================================ */
(function initMenuToggle() {
    const btn     = document.getElementById('menuToggle');
    const sidebar = document.getElementById('sidebar');
    if (!btn || !sidebar) return;

    btn.addEventListener('click', () => {
        sidebar.classList.toggle('open');
        btn.setAttribute('aria-expanded', sidebar.classList.contains('open'));
    });

    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', (e) => {
        if (window.innerWidth <= 900 &&
            sidebar.classList.contains('open') &&
            !sidebar.contains(e.target) &&
            e.target !== btn) {
            sidebar.classList.remove('open');
        }
    });
})();

/* ============================================================
   Order Items — Dynamic Rows & Live Calculator
   ============================================================ */
(function initOrderItems() {
    const tableBody    = document.getElementById('items-body');
    const addBtn       = document.getElementById('add-item-btn');
    const grandTotalEl = document.getElementById('grand-total');

    if (!tableBody || !addBtn) return;

    let rowIndex = tableBody.querySelectorAll('tr').length;

    function formatRWF(n) {
        if (isNaN(n) || n <= 0) return 'RWF 0';
        return 'RWF ' + n.toLocaleString('en-US', { minimumFractionDigits: 0 });
    }

    function recalcTotal() {
        let total = 0;
        tableBody.querySelectorAll('tr').forEach(row => {
            const qty   = parseFloat(row.querySelector('.qty-input')?.value)   || 0;
            const price = parseFloat(row.querySelector('.price-input')?.value) || 0;
            const line  = qty * price;
            const ltEl  = row.querySelector('.line-total-display');
            if (ltEl) ltEl.textContent = formatRWF(line);
            total += line;
        });
        if (grandTotalEl) grandTotalEl.textContent = formatRWF(total);
    }

    function attachRowListeners(row) {
        row.querySelectorAll('.qty-input, .price-input').forEach(input => {
            input.addEventListener('input', recalcTotal);
        });
        row.querySelector('.remove-row-btn')?.addEventListener('click', () => {
            if (tableBody.querySelectorAll('tr').length > 1) {
                row.remove();
                recalcTotal();
            } else {
                alert('At least one item is required.');
            }
        });
    }

    function createRow(index) {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>
                <input type="text" name="product_name[]"
                       class="form-control" placeholder="e.g. Irish Potato (Grade A)"
                       required>
            </td>
            <td>
                <input type="number" name="quantity[]"
                       class="form-control qty-input" placeholder="0" min="0.01"
                       step="0.01" required>
            </td>
            <td>
                <select name="unit[]" class="form-control">
                    <option value="kg">kg</option>
                    <option value="ton">ton</option>
                    <option value="bag">bag</option>
                    <option value="piece">piece</option>
                </select>
            </td>
            <td>
                <input type="number" name="unit_price[]"
                       class="form-control price-input" placeholder="0" min="1"
                       step="1" required>
            </td>
            <td>
                <span class="line-total-display">RWF 0</span>
            </td>
            <td>
                <button type="button" class="remove-row-btn" title="Remove row">×</button>
            </td>
        `;
        attachRowListeners(tr);
        return tr;
    }

    // Attach listeners to existing rows (on edit page)
    tableBody.querySelectorAll('tr').forEach(row => attachRowListeners(row));
    recalcTotal();

    addBtn.addEventListener('click', () => {
        const row = createRow(rowIndex++);
        tableBody.appendChild(row);
        row.querySelector('input')?.focus();
    });
})();

/* ============================================================
   Client-side form validation
   ============================================================ */
(function initFormValidation() {
    document.querySelectorAll('form[data-validate]').forEach(form => {
        form.addEventListener('submit', (e) => {
            let valid = true;
            form.querySelectorAll('[required]').forEach(field => {
                field.classList.remove('error');
                if (!field.value.trim()) {
                    field.classList.add('error');
                    valid = false;
                }
            });
            if (!valid) {
                e.preventDefault();
                const firstError = form.querySelector('.error');
                firstError?.focus();
                firstError?.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        });
    });
})();

/* ============================================================
   Confirm delete dialogs
   ============================================================ */
document.querySelectorAll('[data-confirm]').forEach(el => {
    el.addEventListener('click', (e) => {
        if (!confirm(el.dataset.confirm || 'Are you sure?')) {
            e.preventDefault();
        }
    });
});

/* ============================================================
   Auto-dismiss alerts after 5 seconds
   ============================================================ */
setTimeout(() => {
    document.querySelectorAll('.alert').forEach(el => {
        el.style.transition = 'opacity 0.5s';
        el.style.opacity = '0';
        setTimeout(() => el.remove(), 500);
    });
}, 5000);
