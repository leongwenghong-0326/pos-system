<?php
$pageTitle = 'Settings';
include __DIR__ . '/partials/header.php';
?>
<div class="card">
    <div class="card-header">
        <h2>System Preferences</h2>
    </div>
    <div class="settings-grid">
        <div class="settings-card">
            <h3>Receipt Printer</h3>
            <p>Select printer connection and auto-print settings.</p>
            <div class="form-group">
                <label>Connection Mode</label>
                <select>
                    <option>USB / Serial</option>
                    <option>Local Print Agent</option>
                </select>
            </div>
            <div class="form-group">
                <label>Auto Print</label>
                <select>
                    <option>Enabled</option>
                    <option>Disabled</option>
                </select>
            </div>
            <div class="form-group">
                <label>Auto Open Drawer</label>
                <select>
                    <option>Enabled</option>
                    <option>Disabled</option>
                </select>
            </div>
        </div>
        <div class="settings-card">
            <h3>Theme & Language</h3>
            <p>Switch interface mode and regional settings.</p>
            <div class="form-group">
                <label>Mode</label>
                <select>
                    <option>Light</option>
                    <option>Dark</option>
                </select>
            </div>
            <div class="form-group">
                <label>Currency</label>
                <select>
                    <option>RM (Malaysian Ringgit)</option>
                </select>
            </div>
            <div class="form-group">
                <label>Date Format</label>
                <select>
                    <option>DD/MM/YYYY</option>
                </select>
            </div>
        </div>
    </div>
</div>
<?php include __DIR__ . '/partials/footer.php'; ?>
