<?php
/**
 * products.php — fetch products from Shopify Storefront API
 */

require_once __DIR__ . '/storefront.php';

function get_products(string $cursor = null, int $first = 24): array {
    $sf = new storefront();

    $query = <<<'GRAPHQL'
    query getProducts($first: Int!, $after: String) {
        products(first: $first, after: $after) {
            edges {
                cursor
                node {
                    id
                    title
                    handle
                    description
                    availableForSale
                    priceRange {
                        minVariantPrice {
                            amount
                            currencyCode
                        }
                    }
                    images(first: 5) {
                        edges {
                            node {
                                url
                                altText
                                width
                                height
                            }
                        }
                    }
                    collections(first: 5) {
                        edges {
                            node {
                                id
                                title
                                handle
                            }
                        }
                    }
                }
            }
            pageInfo {
                hasNextPage
                endCursor
            }
        }
    }
    GRAPHQL;

    $data = $sf->query($query, [
        'first' => $first,
        'after' => $cursor,
    ]);

    $products = array_map(function($edge) {
        $p = $edge['node'];
        $p['cursor'] = $edge['cursor'];
        return $p;
    }, $data['products']['edges'] ?? []);

    return [
        'products'   => $products,
        'pageInfo'   => $data['products']['pageInfo'] ?? [],
    ];
}

function get_product_by_handle(string $handle): ?array {
    $sf = new storefront();

    $query = <<<'GRAPHQL'
    query getProduct($handle: String!) {
        productByHandle(handle: $handle) {
            id
            title
            handle
            description
            descriptionHtml
            availableForSale
            priceRange {
                minVariantPrice {
                    amount
                    currencyCode
                }
            }
            metafields(namespace: "satire", first: 25) {
                edges {
                    node {
                        key
                        value
                        type
                    }
                }
            }
            images(first: 10) {
                edges {
                    node {
                        url
                        altText
                        width
                        height
                    }
                }
            }
            variants(first: 5) {
                edges {
                    node {
                        id
                        title
                        price {
                            amount
                            currencyCode
                        }
                        availableForSale
                    }
                }
            }
        }
    }
    GRAPHQL;

    $data = $sf->query($query, ['handle' => $handle]);
    return $data['productByHandle'] ?? null;
}

function format_price(array $priceRange): string {
    $min = $priceRange['minVariantPrice'];
    $symbols = ['USD' => '$', 'EUR' => '€', 'GBP' => '£'];
    $sym = $symbols[$min['currencyCode']] ?? $min['currencyCode'] . ' ';
    return $sym . number_format((float)$min['amount'], 2);
}
