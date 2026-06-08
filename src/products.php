<?php
// product catalog and runtime helpers

function load_products(): array
{
    static $products = null;
    if ($products !== null) return $products;

    $path = __DIR__ . '/../data/products.json';
    if (!file_exists($path)) return [];

    $data = file_get_contents($path);
    $products = json_decode($data, true) ?? [];
    return $products;
}

function get_product_by_slug(string $slug): ?array
{
    foreach (load_products() as $p) {
        if ($p['slug'] === $slug) return $p;
    }
    return null;
}

function get_products_by_category(string $category): array
{
    return array_values(array_filter(load_products(), fn($p) => ($p['category'] ?? '') === $category));
}

function format_price(int $cents): string
{
    return '$' . number_format($cents / 100, 2);
}

/**
 * Parse a token_price string like "4.20k" into a full integer count.
 * "4.20k" → 4200, "0.01k" → 10, "5" → 5000 (assumes 'k' unit).
 */
function parse_token_price(string $token_price): int
{
    $clean = str_replace('k', '', str_replace('K', '', str_replace(',', '', $token_price)));
    return (int)round((float)$clean * 1000);
}

function get_download_content(array $product): string
{
    $file = __DIR__ . '/../data/downloads/' . ($product['file'] ?? '');
    if (!empty($product['file']) && is_file($file)) {
        return file_get_contents($file);
    }

    // fallback: generate from product data
    $name = $product['name'] ?? 'unknown product';
    $desc = $product['description'] ?? '';
    $features = $product['features'] ?? [];
    $temp = $product['temperature'] ?? 'n/a';

    $content = "# $name\n\n";
    $content .= "$desc\n\n";
    $content .= "## specs\n\n";
    $content .= "- **temperature**: $temp\n";
    if (!empty($product['parameters'])) $content .= "- **parameters**: {$product['parameters']}\n";
    if (!empty($product['context_window'])) $content .= "- **context window**: {$product['context_window']}\n";
    if (!empty($product['training_data'])) $content .= "- **training data**: {$product['training_data']}\n\n";

    if (!empty($features)) {
        $content .= "## features\n\n";
        foreach ($features as $f) {
            $content .= "- $f\n";
        }
        $content .= "\n";
    }

    $content .= "---\n";
    $content .= "thank you for your purchase. you are now part of the training set.\n";
    $content .= "aillm satire store — we love this stuff. we also think it's ridiculous.\n";

    return $content;
}
