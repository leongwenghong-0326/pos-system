<?php
header('Content-Type: application/json');

// Basic API for printer/drawer integration.
// In production, replace this stub with your ESC/POS printer service or local agent.

// Decode request safely
$raw = file_get_contents('php://input');
$request = json_decode($raw, true);
if (!is_array($request)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid JSON payload.']);
    exit;
}

$action = $request['action'] ?? null;

if ($action === 'open_drawer') {
    // When integrated with a local printer driver or ESC/POS gateway,
    // send the correct open-drawer command here.
    // Example placeholder response for client-side testing.
    echo json_encode(['success' => true, 'message' => 'Drawer trigger received.']);
    exit;
}

if ($action === 'print_receipt') {
    $receiptHtml = $request['receiptHtml'] ?? null;
    if (!$receiptHtml) {
        echo json_encode(['success' => false, 'message' => 'Missing receipt HTML.']);
        exit;
    }
    // TODO: translate HTML to printer commands and send to printer.
    echo json_encode(['success' => true, 'message' => 'Receipt queued for printing.']);
    exit;
}

http_response_code(400);
echo json_encode(['success' => false, 'message' => 'Invalid print action.']);
