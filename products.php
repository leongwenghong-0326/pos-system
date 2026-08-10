<?php
session_start();
if (!isset($_SESSION['user'])) { header('Location: login.php'); exit; }
$pageTitle = 'Product Management';
$user = $_SESSION['user'];
include __DIR__ . '/partials/header.php';
?>
<div class="main-content">
    <div class="card">
        <div class="card-header">
            <h2>Products</h2>
            <div>
                <button id="refreshProducts" class="button">Refresh</button>
            </div>
        </div>
        <div style="margin-top:1rem; display:flex; gap:1rem; align-items:flex-start;">
            <form id="productForm" style="flex:1; max-width:520px;">
                <input type="hidden" id="productId">
                <div class="form-group">
                    <label>Name</label>
                    <input id="productName" required>
                </div>
                <div class="form-row split">
                    <div style="flex:1">
                        <label>SKU</label>
                        <input id="productSku">
                    </div>
                    <div style="flex:1">
                        <label>Category</label>
                        <input id="productCategory">
                    </div>
                </div>
                <div class="form-row split">
                    <div style="flex:1">
                        <label>Price</label>
                        <input id="productPrice" type="number" step="0.01">
                    </div>
                    <div style="flex:1">
                        <label>Stock</label>
                        <input id="productStock" type="number">
                    </div>
                </div>
                <div class="form-group">
                    <label>Barcode</label>
                    <input id="productBarcode">
                </div>
                <div class="form-group">
                    <label>Image URL</label>
                    <input id="productImage">
                </div>
                <div style="display:flex;gap:0.5rem;margin-top:0.5rem">
                    <button class="button primary" type="submit">Save</button>
                    <button id="cancelEdit" type="button" class="button secondary">Cancel</button>
                </div>
            </form>
            <div style="flex:1">
                <table class="table-list" id="productsTable">
                    <thead>
                        <tr><th>Name</th><th>SKU</th><th>Category</th><th>Price</th><th>Stock</th><th>Actions</th></tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
'use strict';

async function fetchProducts() {
    const res = await fetch('api/products.php');
    return res.json();
}

function renderProductsList(list) {
    const tbody = document.querySelector('#productsTable tbody');
    tbody.innerHTML = list.map(p => `
        <tr>
            <td>${p.name}</td>
            <td>${p.sku}</td>
            <td>${p.category}</td>
            <td>${Number(p.price).toFixed(2)}</td>
            <td>${p.stock}</td>
            <td>
                <button class="button" data-action="edit" data-id="${p.id}">Edit</button>
                <button class="button secondary" data-action="delete" data-id="${p.id}">Delete</button>
            </td>
        </tr>
    `).join('');
}

async function loadAndRender() {
    const list = await fetchProducts();
    renderProductsList(list);
}

function resetForm() {
    document.getElementById('productId').value = '';
    document.getElementById('productForm').reset();
}

document.getElementById('refreshProducts').addEventListener('click', loadAndRender);

document.getElementById('productForm').addEventListener('submit', async (ev) => {
    ev.preventDefault();
    const id = document.getElementById('productId').value;
    const data = new FormData();
    const payload = {
        name: document.getElementById('productName').value,
        sku: document.getElementById('productSku').value,
        category: document.getElementById('productCategory').value,
        price: document.getElementById('productPrice').value,
        stock: document.getElementById('productStock').value,
        barcode: document.getElementById('productBarcode').value,
        image: document.getElementById('productImage').value,
    };
    Object.keys(payload).forEach(k => data.append(k, payload[k]));
    if (id) {
        data.append('action', 'update');
        data.append('id', id);
    } else {
        data.append('action', 'create');
    }
    const res = await fetch('api/products.php', { method: 'POST', body: data });
    const json = await res.json();
    if (json.error) { window.ui && window.ui.showToast(json.error, 'error'); return; }
    window.ui && window.ui.showToast('Product saved', 'success');
    resetForm();
    loadAndRender();
});

document.getElementById('cancelEdit').addEventListener('click', resetForm);

document.querySelector('#productsTable tbody').addEventListener('click', async (ev) => {
    const btn = ev.target.closest('button');
    if (!btn) return;
    const action = btn.dataset.action;
    const id = btn.dataset.id;
    if (action === 'edit') {
        const list = await fetchProducts();
        const p = list.find(x => String(x.id) === String(id));
        if (!p) return;
        document.getElementById('productId').value = p.id;
        document.getElementById('productName').value = p.name;
        document.getElementById('productSku').value = p.sku;
        document.getElementById('productCategory').value = p.category;
        document.getElementById('productPrice').value = p.price;
        document.getElementById('productStock').value = p.stock;
        document.getElementById('productBarcode').value = p.barcode;
        document.getElementById('productImage').value = p.image;
    }
    if (action === 'delete') {
        if (!confirm('Delete product?')) return;
        const data = new FormData(); data.append('action', 'delete'); data.append('id', id);
        const res = await fetch('api/products.php', { method: 'POST', body: data });
        const json = await res.json();
        if (json.error) { window.ui && window.ui.showToast(json.error, 'error'); return; }
        window.ui && window.ui.showToast('Product deleted', 'success');
        loadAndRender();
    }
});

// Initial load
loadAndRender();
</script>

<?php include __DIR__ . '/partials/footer.php'; ?>
