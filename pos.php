<?php
$pageTitle = 'POS Counter';
include __DIR__ . '/partials/header.php';
?>
<script>
    window.currentUser = {
        name: '<?php echo htmlspecialchars($user['name'], ENT_QUOTES); ?>',
        username: '<?php echo htmlspecialchars($user['username'], ENT_QUOTES); ?>'
    };
</script>
<div class="pos-grid">
    <section class="pos-panel">
        <div class="card">
            <div class="card-header">
                <h2>Scan or Search Product</h2>
            </div>
            <div class="form-group">
                <label>Scan Barcode here...</label>
                <input id="barcodeInput" type="text" placeholder="Scan barcode here...">
            </div>
            <div class="form-group">
                <label>Search product name, SKU or barcode...</label>
                <input id="searchInput" type="text" placeholder="Search product name, SKU or barcode...">
            </div>
                <div style="display:flex;gap:0.75rem;align-items:center;margin-top:0.75rem;">
                    <div class="category-tabs-container" style="flex:1">
                        <div class="category-tabs"></div>
                    </div>
                    <button type="button" id="touchModeButton" class="button secondary">Touch Mode</button>
                    <div id="touchModeLabel" class="link-button" style="margin-left:0.5rem">Touch Mode: OFF</div>
                </div>
                <div class="product-grid" style="margin-top:1rem"></div>
                <button type="button" class="button secondary">Create New Customer</button>
        </div>
        <div class="card">
            <div class="card-header">
                <h2>Customer</h2>
            </div>
            <div class="form-group">
                <label>Customer</label>
                <select>
                    <option>Walk-in Customer</option>
                    <option>Ahmad Hassan</option>
                    <option>Siti Aisyah</option>
                </select>
            </div>
            <button class="button secondary">Create New Customer</button>
        </div>
    </section>
    <section class="cart-panel">
        <div class="card">
            <div class="card-header">
                <h2>Shopping Cart</h2>
            </div>
            <table class="table-list cart-table">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Qty</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
            <div class="summary-row">
                <div>Subtotal</div>
                <div id="subtotalValue">RM 0.00</div>
            </div>
            <div class="summary-row">
                <div>Discount</div>
                <div id="discountValue">RM 0.00</div>
            </div>
            <div class="summary-row">
                <div>Tax (3%)</div>
                <div id="taxValue">RM 0.00</div>
            </div>
            <div class="summary-row total-row">
                <div>TOTAL:</div>
                <div id="totalValue">RM 0.00</div>
            </div>
            <div id="paymentMethodButtons" class="payment-method"></div>
            <div class="form-group">
                <label>Cash Received</label>
                <input id="cashReceived" type="number" min="0" placeholder="RM 0.00">
            </div>
            <div class="summary-row">
                <div>Change</div>
                <div id="changeValue">RM 0.00</div>
            </div>
            <div class="action-buttons">
                <button type="button" id="payButton" class="button primary full">Pay</button>
                <button type="button" id="printButton" class="button secondary full">Print Receipt</button>
                <button type="button" id="holdButton" class="button secondary full">Hold</button>
                <button type="button" id="drawerButton" class="button secondary full">Open Drawer</button>
                <button type="button" id="clearButton" class="button secondary full">Clear Cart</button>
            </div>
        </div>
    </section>
</div>
<?php include __DIR__ . '/partials/footer.php'; ?>
