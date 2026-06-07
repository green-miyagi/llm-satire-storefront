<?php
/**
 * cart.php — Shopify Storefront Cart API operations
 */

require_once __DIR__ . '/storefront.php';

function create_cart(array $lines = []): array {
    $sf = new storefront();

    $query = <<<'GRAPHQL'
    mutation createCart($input: CartInput!) {
        cartCreate(input: $input) {
            cart {
                id
                checkoutUrl
                totalQuantity
                cost {
                    subtotalAmount {
                        amount
                        currencyCode
                    }
                    totalAmount {
                        amount
                        currencyCode
                    }
                }
                lines(first: 50) {
                    edges {
                        node {
                            id
                            quantity
                            merchandise {
                                ... on ProductVariant {
                                    id
                                    title
                                    product {
                                        title
                                        handle
                                    }
                                    price {
                                        amount
                                        currencyCode
                                    }
                                }
                            }
                        }
                    }
                }
            }
            userErrors {
                field
                message
            }
        }
    }
    GRAPHQL;

    $input = [];
    if (!empty($lines)) {
        $input['lines'] = array_map(function($line) {
            return [
                'variantId'   => $line['variantId'],
                'quantity'    => $line['quantity'] ?? 1,
            ];
        }, $lines);
    }

    $data = $sf->query($query, ['input' => $input]);
    return $data['cartCreate']['cart'] ?? [];
}

function get_cart(string $cartId): ?array {
    $sf = new storefront();

    $query = <<<'GRAPHQL'
    query getCart($cartId: ID!) {
        cart(id: $cartId) {
            id
            checkoutUrl
            totalQuantity
            cost {
                subtotalAmount {
                    amount
                    currencyCode
                }
                totalAmount {
                    amount
                    currencyCode
                }
            }
            lines(first: 50) {
                edges {
                    node {
                        id
                        quantity
                        merchandise {
                            ... on ProductVariant {
                                id
                                title
                                product {
                                    title
                                    handle
                                    images(first: 1) {
                                        edges {
                                            node { url }
                                        }
                                    }
                                }
                                price {
                                    amount
                                    currencyCode
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    GRAPHQL;

    $data = $sf->query($query, ['cartId' => $cartId]);
    return $data['cart'] ?? null;
}

function add_to_cart(string $cartId, array $lines): array {
    $sf = new storefront();

    $query = <<<'GRAPHQL'
    mutation addToCart($cartId: ID!, $lines: [CartLineInput!]!) {
        cartLinesAdd(cartId: $cartId, lines: $lines) {
            cart {
                id
                totalQuantity
                cost {
                    subtotalAmount {
                        amount
                        currencyCode
                    }
                }
            }
            userErrors {
                field
                message
            }
        }
    }
    GRAPHQL;

    $data = $sf->query($query, [
        'cartId' => $cartId,
        'lines'  => $lines,
    ]);

    return $data['cartLinesAdd']['cart'] ?? [];
}
