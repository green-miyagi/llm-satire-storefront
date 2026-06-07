<?php
// stripe api helper — direct curl to avoid composer dependency

function stripe_api(string $method, string $path, array $data = []): array
{
    $secret = getenv('STRIPE_SECRET_KEY');
    if (!$secret) {
        error_log('stripe: missing STRIPE_SECRET_KEY');
        return ['error' => 'stripe not configured'];
    }

    $url = 'https://api.stripe.com/v1/' . ltrim($path, '/');
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_USERPWD => $secret . ':',
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTPHEADER => ['Content-Type: application/x-www-form-urlencoded'],
    ]);

    if ($method === 'POST' && !empty($data)) {
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    }

    if ($method === 'GET') {
        curl_setopt($ch, CURLOPT_HTTPGET, true);
    }

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);

    if ($error) {
        error_log('stripe curl error: ' . $error);
        return ['error' => 'api request failed'];
    }

    $result = json_decode($response, true);
    if ($httpCode >= 400) {
        $msg = $result['error']['message'] ?? 'unknown error';
        error_log("stripe api error ($httpCode): $msg");
        return ['error' => $msg];
    }

    return $result;
}

function create_checkout_session(array $line_items, string $success_url, string $cancel_url): array
{
    $data = [
        'mode' => 'payment',
        'success_url' => $success_url,
        'cancel_url' => $cancel_url,
        'allow_promotion_codes' => 'true',
        'locale' => 'auto',
    ];

    foreach ($line_items as $i => $item) {
        $data["line_items[$i][price_data][currency]"] = 'usd';
        $data["line_items[$i][price_data][product_data][name]"] = $item['name'];
        $data["line_items[$i][price_data][product_data][description]"] = $item['description'] ?? '';
        $data["line_items[$i][price_data][unit_amount]"] = $item['amount_cents'];
        $data["line_items[$i][quantity]"] = $item['quantity'] ?? 1;

        // attach product slug for fulfillment
        $data["line_items[$i][price_data][product_data][metadata][product_slug]"] = $item['slug'] ?? '';
    }

    return stripe_api('POST', '/checkout/sessions', $data);
}

function retrieve_checkout_session(string $session_id): array
{
    return stripe_api('GET', "/checkout/sessions/$session_id");
}

// simple product image placeholder — returns an svg
function product_placeholder_svg(string $product_id): string
{
    $svg = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" width="600" height="600" viewBox="0 0 600 600">
  <rect width="600" height="600" fill="#0d0d0d"/>
  <rect x="50" y="50" width="500" height="500" rx="4" fill="none" stroke="#00ff41" stroke-width="1" opacity="0.3"/>
  <line x1="50" y1="100" x2="550" y2="100" stroke="#00ff41" stroke-width="1" opacity="0.15"/>
  <circle cx="300" cy="280" r="80" fill="none" stroke="#00ff41" stroke-width="1" opacity="0.4"/>
  <circle cx="300" cy="280" r="40" fill="none" stroke="#ffb000" stroke-width="1" opacity="0.3"/>
  <line x1="220" y1="280" x2="380" y2="280" stroke="#00ff41" stroke-width="1" opacity="0.2"/>
  <line x1="300" y1="200" x2="300" y2="360" stroke="#00ff41" stroke-width="1" opacity="0.2"/>
  <text x="300" y="440" text-anchor="middle" font-family="monospace" font-size="14" fill="#00ff41" opacity="0.6">[ {$product_id} ]</text>
  <text x="300" y="470" text-anchor="middle" font-family="monospace" font-size="10" fill="#666" opacity="0.4">digital download</text>
</svg>
SVG;

    return $svg;
}
