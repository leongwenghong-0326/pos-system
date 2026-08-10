"use strict";

const posState = {
    products: [],
    cart: [],
    paymentMethod: 'cash',
    cashReceived: 0,
    discount: 0,
    taxRate: 0.03,
    currentCategory: 'All Items',
    touchMode: false
};

let elements = {};

function formatMoney(value) {
    return `RM ${value.toFixed(2)}`;
}

function getFilteredProducts() {
    const text = elements.searchInput.value.trim().toLowerCase();
    return posState.products.filter(product => {
        const matchCategory = posState.currentCategory === 'All Items' || product.category === posState.currentCategory;
        const matchText = !text || product.name.toLowerCase().includes(text) || product.sku.toLowerCase().includes(text) || product.barcode.includes(text);
        return matchCategory && matchText;
    });
}

function fetchProductsFromServer() {
    return fetch('api/products.php')
        .then(r => r.json())
        .then(list => { posState.products = list; renderCategories(); renderProducts(); })
        .catch(() => { window.ui && window.ui.showToast('Unable to load products from server', 'error'); });
}

function renderCategories() {
    const categories = ['All Items', ...new Set(posState.products.map(p => p.category))];
    elements.categories.innerHTML = categories.map(category => {
        const active = category === posState.currentCategory ? 'active' : '';
        return `<button class="category-button ${active}" data-category="${category}">${category}</button>`;
    }).join('');
    document.querySelectorAll('.category-button').forEach(button => {
        button.addEventListener('click', () => {
            posState.currentCategory = button.dataset.category;
            renderCategories();
            renderProducts();
        });
    });
}

function renderProducts() {
    const products = getFilteredProducts();
    elements.productGrid.innerHTML = products.map(product => {
        const imageUrl = product.image || 'assets/images/default.svg';
        return `
            <article class="product-card" data-id="${product.id}">
                <div class="product-image" style="background-image: url('${imageUrl}'); min-height:120px"></div>
                <div class="product-info">
                    <strong>${product.name}</strong>
                    <span>${product.sku}</span>
                </div>
                <div class="product-meta">
                    <div>${formatMoney(product.price)}</div>
                    <div>Stock ${product.stock}</div>
                </div>
                <button class="button secondary add-to-cart">Add</button>
            </article>
        `;
    }).join('');
    document.querySelectorAll('.add-to-cart').forEach(button => {
        button.addEventListener('click', () => {
            const productId = Number(button.closest('.product-card').dataset.id);
            addToCart(productId);
        });
    });
}

function addToCart(productId) {
    const product = posState.products.find(p => p.id === productId);
    if (!product) return;
    const cartItem = posState.cart.find(item => item.product.id === productId);
    if (cartItem) {
        cartItem.quantity += 1;
    } else {
        posState.cart.push({ product, quantity: 1, discount: 0 });
    }
    renderCart();
}

function removeCartItem(index) {
    posState.cart.splice(index, 1);
    renderCart();
}

function updateCartQuantity(index, delta) {
    const item = posState.cart[index];
    if (!item) return;
    item.quantity = Math.max(1, item.quantity + delta);
    renderCart();
}

function renderCart() {
    elements.cartTable.innerHTML = posState.cart.map((item, index) => {
        const subtotal = item.quantity * item.product.price - item.discount;
        return `
            <tr>
                <td>${item.product.name}</td>
                <td>
                    <div class="qty-controls">
                        <button type="button" onclick="window.posActions.updateQty(${index}, -1)">-</button>
                        <span>${item.quantity}</span>
                        <button type="button" onclick="window.posActions.updateQty(${index}, 1)">+</button>
                    </div>
                </td>
                <td>${formatMoney(subtotal)}</td>
                <td><button type="button" class="button secondary mini" onclick="window.posActions.removeItem(${index})">Remove</button></td>
            </tr>
        `;
    }).join('');
    updateTotals();
}

function updateTotals() {
    const subtotal = posState.cart.reduce((sum, item) => sum + item.quantity * item.product.price - item.discount, 0);
    const tax = subtotal * posState.taxRate;
    const total = subtotal + tax - posState.discount;
    elements.subtotalValue.textContent = formatMoney(subtotal);
    elements.discountValue.textContent = formatMoney(posState.discount);
    elements.taxValue.textContent = formatMoney(tax);
    elements.totalValue.textContent = formatMoney(total);
    const cash = Number(elements.cashInput.value) || 0;
    posState.cashReceived = cash;
    elements.changeValue.textContent = formatMoney(Math.max(0, cash - total));
}

function renderPaymentButtons() {
    const methods = [
        { id: 'cash', label: 'Cash' },
        { id: 'card', label: 'Card' },
        { id: 'debit', label: 'Debit' },
        { id: 'dnpay', label: 'DuitNow' },
        { id: 'tng', label: 'TNG' },
        { id: 'grab', label: 'Grab' },
        { id: 'boost', label: 'Boost' }
    ];
    elements.paymentContainer.innerHTML = methods.map(method => {
        const active = method.id === posState.paymentMethod ? 'active' : '';
        return `<button type="button" class="button ${active}" data-method="${method.id}">${method.label}</button>`;
    }).join('');
    document.querySelectorAll('#paymentMethodButtons button').forEach(button => {
        button.addEventListener('click', () => selectPaymentMethod(button.dataset.method));
    });
}

function selectPaymentMethod(method) {
    posState.paymentMethod = method;
    document.querySelectorAll('#paymentMethodButtons button').forEach(button => {
        button.classList.toggle('active', button.dataset.method === method);
    });
}

function buildReceiptHtml(total) {
    const now = new Date();
    const receiptNo = `TRN${now.getTime()}`;
    const lines = [];
    const sellerHeader = [
        'SUPERMARKET POS SYSTEM',
        '123 Supermarket Ave, Suite 100',
        'Kuala Lumpur, Malaysia',
        'Tel: +60 3-8888 9999',
        'SST Reg No: W10-1808-32000034'
    ];
    lines.push(...sellerHeader, ''.padEnd(40, '-'));
    lines.push(`Receipt No: ${receiptNo}`);
    lines.push(`Date: ${now.toLocaleDateString('en-GB')} ${now.toLocaleTimeString('en-GB')}`);
    lines.push(`Cashier: ${window.currentUser?.name || 'admin'}`);
    lines.push(`Payment Method: ${posState.paymentMethod.toUpperCase()}`);
    lines.push(''.padEnd(40, '-'));
    lines.push('Item                    Qty   Price   Total');
    lines.push(''.padEnd(40, '-'));

    posState.cart.forEach(item => {
        const name = item.product.name.slice(0, 20).padEnd(22);
        const qty = String(item.quantity).padEnd(5);
        const price = formatMoney(item.product.price).padStart(7);
        const lineTotal = formatMoney(item.quantity * item.product.price).padStart(8);
        lines.push(`${name}${qty}${price}${lineTotal}`);
    });

    lines.push(''.padEnd(40, '-'));
    const subtotal = posState.cart.reduce((sum, item) => sum + item.quantity * item.product.price, 0);
    const tax = subtotal * posState.taxRate;
    const cashTendered = Number(elements.cashInput.value) || 0;
    const changeDue = Math.max(0, cashTendered - total);

    lines.push(`Subtotal: ${formatMoney(subtotal).padStart(25)}`);
    lines.push(`Tax (3%): ${formatMoney(tax).padStart(23)}`);
    lines.push(`TOTAL: ${formatMoney(total).padStart(28)}`);
    if (posState.paymentMethod === 'cash') {
        lines.push(`Cash Tendered: ${formatMoney(cashTendered).padStart(18)}`);
        lines.push(`Change Due: ${formatMoney(changeDue).padStart(22)}`);
    }
    lines.push(''.padEnd(40, '-'));
    lines.push('Tax Code    Rate   Taxable   Tax Amt');
    lines.push(`SR (Standard Rate) 3.00% ${formatMoney(subtotal).padStart(10)} ${formatMoney(tax).padStart(10)}`);
    lines.push(''.padEnd(40, '-'));
    lines.push(receiptNo);
    lines.push('Thank you for shopping with us!');
    lines.push('Goods sold are not returnable or refundable.');
    lines.push('Please come again!');

    return `
        <html>
        <head>
            <title>Receipt ${receiptNo}</title>
            <style>
                body { font-family: Courier, monospace; margin: 16px; }
                pre { font-size: 12px; line-height: 1.2; }
                .center { text-align: center; }
            </style>
        </head>
        <body>
            <pre>${lines.join('\n')}</pre>
        </body>
        </html>
    `;
}

function printReceipt(total) {
    const receiptHtml = buildReceiptHtml(total);
    const printWindow = window.open('', '_blank', 'width=420,height=720');
    if (!printWindow) {
        alert('Please allow popups to print receipt.');
        return;
    }
    // Prevent the opened window from accessing our window
    try { printWindow.opener = null; } catch (e) { /* ignore */ }
    printWindow.document.write(receiptHtml);
    printWindow.document.close();
    printWindow.focus();
    printWindow.print();
}

function openCashDrawer() {
    fetch('api/print.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ action: 'open_drawer' })
    }).then(response => response.json())
      .then(data => {
          if (data.success) {
              alert('Cash drawer trigger sent.');
          } else {
              alert('Unable to open drawer automatically.');
          }
      }).catch(() => {
          alert('Printer service unavailable. Please open drawer manually.');
      });
}

function getCartTotal() {
    const subtotal = posState.cart.reduce((sum, item) => sum + item.quantity * item.product.price, 0);
    return subtotal + subtotal * posState.taxRate - posState.discount;
}

function handlePayment() {
    if (!posState.cart.length) {
        return window.ui ? window.ui.showToast('Add items to cart before payment', 'error') : alert('Please add items to cart before payment.');
    }
    const total = getCartTotal();
    if (posState.paymentMethod === 'cash' && posState.cashReceived < total) {
        alert('Cash received is less than total amount.');
        return;
    }
    window.ui ? window.ui.showToast(`Payment recorded. Total: ${formatMoney(total)}`, 'success') : alert(`Payment recorded. Total: ${formatMoney(total)}\nPayment method: ${posState.paymentMethod}`);
    printReceipt(total);
    if (posState.paymentMethod === 'cash') {
        openCashDrawer();
    }
    posState.cart = [];
    elements.cashInput.value = '';
    renderCart();
}

function holdOrder() {
    if (!posState.cart.length) {
        return window.ui ? window.ui.showToast('Cannot hold empty cart', 'error') : alert('Cannot hold empty cart.');
    }
    localStorage.setItem('heldOrder', JSON.stringify(posState.cart));
    window.ui ? window.ui.showToast('Order held; resume available', 'success') : alert('Order held successfully. You can resume later.');
}

function clearCart() {
    posState.cart = [];
    elements.cashInput.value = '';
    renderCart();
}

function toggleTouchMode() {
    posState.touchMode = !posState.touchMode;
    document.body.classList.toggle('touch-mode', posState.touchMode);
    elements.touchButtonLabel.textContent = posState.touchMode ? 'Touch Mode: ON' : 'Touch Mode: OFF';
}

function initPosPage() {
    elements = {
        categories: document.querySelector('.category-tabs'),
        productGrid: document.querySelector('.product-grid'),
        searchInput: document.getElementById('searchInput'),
        barcodeInput: document.getElementById('barcodeInput'),
        cartTable: document.querySelector('.cart-table tbody'),
        subtotalValue: document.getElementById('subtotalValue'),
        discountValue: document.getElementById('discountValue'),
        taxValue: document.getElementById('taxValue'),
        totalValue: document.getElementById('totalValue'),
        cashInput: document.getElementById('cashReceived'),
        changeValue: document.getElementById('changeValue'),
        paymentContainer: document.getElementById('paymentMethodButtons'),
        payButton: document.getElementById('payButton'),
        holdButton: document.getElementById('holdButton'),
        drawerButton: document.getElementById('drawerButton'),
        printButton: document.getElementById('printButton'),
        clearButton: document.getElementById('clearButton'),
        touchModeButton: document.getElementById('touchModeButton'),
        touchButtonLabel: document.getElementById('touchModeLabel')
    };

    renderCategories();
    // load products from server if available
    fetchProductsFromServer().then?.(() => {});
    selectPaymentMethod(posState.paymentMethod);
    renderPaymentButtons();
    elements.searchInput && elements.searchInput.addEventListener('input', renderProducts);
    elements.barcodeInput && elements.barcodeInput.addEventListener('keyup', event => {
        if (event.key === 'Enter') {
            const value = event.target.value.trim();
            const found = posState.products.find(p => p.barcode === value || p.sku === value);
            if (found) {
                addToCart(found.id);
                event.target.value = '';
            } else {
                alert('Product not found.');
            }
        }
    });
    elements.cashInput && elements.cashInput.addEventListener('input', updateTotals);
    elements.payButton && elements.payButton.addEventListener('click', handlePayment);
    elements.holdButton && elements.holdButton.addEventListener('click', holdOrder);
    elements.drawerButton && elements.drawerButton.addEventListener('click', openCashDrawer);
    elements.printButton && elements.printButton.addEventListener('click', () => {
        if (!posState.cart.length) {
            return window.ui ? window.ui.showToast('Cannot print empty receipt', 'error') : alert('Cannot print receipt for an empty cart.');
        }
        printReceipt(getCartTotal());
    });
    elements.clearButton && elements.clearButton.addEventListener('click', clearCart);
    elements.touchModeButton && elements.touchModeButton.addEventListener('click', toggleTouchMode);
    // Resume held order UI
    const held = localStorage.getItem('heldOrder');
    if (held) {
        const resumeBtn = document.createElement('button');
        resumeBtn.className = 'button secondary full';
        resumeBtn.textContent = 'Resume Held Order';
        resumeBtn.addEventListener('click', () => {
            try {
                posState.cart = JSON.parse(held);
                localStorage.removeItem('heldOrder');
                renderCart();
                window.ui && window.ui.showToast('Held order resumed', 'success');
                resumeBtn.remove();
            } catch (e) {
                window.ui && window.ui.showToast('Failed to resume held order', 'error');
            }
        });
        elements.holdButton.parentNode.insertBefore(resumeBtn, elements.holdButton.nextSibling);
    }
    // Keyboard shortcuts
    window.addEventListener('keydown', (ev) => {
        if (ev.target.tagName === 'INPUT' || ev.target.tagName === 'TEXTAREA' || ev.metaKey || ev.ctrlKey) return;
        if (ev.key === 'H') { holdOrder(); }
        if (ev.key === 'C') { clearCart(); }
        if (ev.key === 'P') { if (posState.cart.length) printReceipt(getCartTotal()); }
        if (ev.key === 'Enter' && ev.shiftKey) { handlePayment(); }
    });
    renderCart();
}

window.posActions = { updateQty: updateCartQuantity, removeItem: removeCartItem };
window.addEventListener('DOMContentLoaded', initPosPage);
