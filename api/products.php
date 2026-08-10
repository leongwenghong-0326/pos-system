<?php
header('Content-Type: application/json');

function getProductFilePath() {
    return __DIR__ . '/../data/products.json';
}

function ensureProductStore() {
    $path = getProductFilePath();
    if (!file_exists($path)) {
        file_put_contents($path, json_encode([], JSON_PRETTY_PRINT), LOCK_EX);
    }
}

function readProducts() {
    ensureProductStore();
    $json = file_get_contents(getProductFilePath());
    $data = json_decode($json, true);
    if (!is_array($data)) return [];
    return $data;
}

function saveProducts($products) {
    file_put_contents(getProductFilePath(), json_encode(array_values($products), JSON_PRETTY_PRINT), LOCK_EX);
}

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    echo json_encode(readProducts());
    exit;
}

// Use POST for create/update/delete with action param
if ($method === 'POST') {
    $action = $_POST['action'] ?? ($_GET['action'] ?? 'list');
    $products = readProducts();

    if ($action === 'create') {
        $name = trim($_POST['name'] ?? '');
        $sku = trim($_POST['sku'] ?? '');
        $category = trim($_POST['category'] ?? '');
        $price = floatval($_POST['price'] ?? 0);
        $stock = intval($_POST['stock'] ?? 0);
        $barcode = trim($_POST['barcode'] ?? '');
        $image = trim($_POST['image'] ?? '');
        if ($name === '') {
            echo json_encode(['error' => 'Name required']); exit;
        }
        $nextId = count($products) ? max(array_column($products, 'id')) + 1 : 1;
        $new = compact('id', 'name', 'sku', 'category', 'price', 'stock', 'barcode', 'image');
        $new['id'] = $nextId;
        $products[] = $new;
        saveProducts($products);
        echo json_encode($new);
        exit;
    }

    if ($action === 'update') {
        $id = intval($_POST['id'] ?? 0);
        foreach ($products as &$p) {
            if ($p['id'] === $id) {
                $p['name'] = trim($_POST['name'] ?? $p['name']);
                $p['sku'] = trim($_POST['sku'] ?? $p['sku']);
                $p['category'] = trim($_POST['category'] ?? $p['category']);
                $p['price'] = floatval($_POST['price'] ?? $p['price']);
                $p['stock'] = intval($_POST['stock'] ?? $p['stock']);
                $p['barcode'] = trim($_POST['barcode'] ?? $p['barcode']);
                $p['image'] = trim($_POST['image'] ?? $p['image']);
                saveProducts($products);
                echo json_encode($p);
                exit;
            }
        }
        echo json_encode(['error' => 'Product not found']); exit;
    }

    if ($action === 'delete') {
        $id = intval($_POST['id'] ?? 0);
        $found = false;
        foreach ($products as $idx => $p) {
            if ($p['id'] === $id) {
                $found = true;
                array_splice($products, $idx, 1);
                saveProducts($products);
                echo json_encode(['success' => true]);
                exit;
            }
        }
        echo json_encode(['error' => 'Product not found']); exit;
    }
}

http_response_code(400);
echo json_encode(['error' => 'Unsupported request']);
