<?php
/**
 * cart-endpoint.php — AJAX cart API
 * endpoints: ?action=get&cartId=xxx, ?action=add
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

require_once __DIR__ . '/../src/config.php';
require_once __DIR__ . '/../src/api/cart.php';

$action = $_GET['action'] ?? '';

try {
    switch ($action) {
        case 'get':
            $cartId = $_GET['cartId'] ?? '';
            if (!$cartId) {
                echo json_encode(null);
                exit;
            }
            $cart = get_cart($cartId);
            echo json_encode($cart);
            break;

        case 'add':
            $input = json_decode(file_get_contents('php://input'), true);
            $cartId = $input['cartId'] ?? null;
            $lines  = $input['lines'] ?? [];

            // show special loading/thinking animation
            usleep(200000); // 200ms "thinking" delay for satire effect

            if ($cartId) {
                $result = add_to_cart($cartId, $lines);
                echo json_encode($result);
            } else {
                $result = create_cart($lines);
                echo json_encode($result);
            }
            break;

        case 'create':
            $input = json_decode(file_get_contents('php://input'), true);
            $lines = $input['lines'] ?? [];
            $cart = create_cart($lines);
            echo json_encode($cart);
            break;

        default:
            echo json_encode(['error' => 'unknown action']);
    }
} catch (\Throwable $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
