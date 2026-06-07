<?php
/**
 * storefront.php — GraphQL client for Shopify Storefront API
 * green miyagi style: minimal, direct, no fluff
 */

class storefront {
    private string $endpoint;
    private string $token;

    public function __construct() {
        $domain   = getenv('STORE_DOMAIN') ?: 'llm-satire.myshopify.com';
        $version  = getenv('STOREFRONT_API_VERSION') ?: '2024-10';
        $this->token = getenv('STOREFRONT_API_TOKEN') ?: '';
        $this->endpoint = "https://{$domain}/api/{$version}/graphql.json";
    }

    public function query(string $query, array $variables = []): array {
        $json = json_encode([
            'query'     => $query,
            'variables' => $variables,
        ]);

        $ch = curl_init($this->endpoint);
        curl_setopt_array($ch, [
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => $json,
            CURLOPT_HTTPHEADER     => [
                'Content-Type: application/json',
                'X-Shopify-Storefront-Access-Token: ' . $this->token,
            ],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 30,
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error    = curl_error($ch);
        curl_close($ch);

        if ($error) {
            throw new \RuntimeException("curl error: {$error}");
        }

        $data = json_decode($response, true);

        if ($httpCode !== 200 || isset($data['errors'])) {
            $msg = $data['errors'][0]['message'] ?? "http {$httpCode}";
            throw new \RuntimeException("storefront api error: {$msg}");
        }

        return $data['data'] ?? [];
    }
}
