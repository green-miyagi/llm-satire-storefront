<?php
/**
 * collections.php — fetch collections from Shopify Storefront API
 */

require_once __DIR__ . '/storefront.php';

function get_collections(): array {
    $sf = new storefront();

    $query = <<<'GRAPHQL'
    query getCollections {
        collections(first: 50) {
            edges {
                node {
                    id
                    title
                    handle
                    description
                    image {
                        url
                        altText
                    }
                    products(first: 1) {
                        edges {
                            node {
                                priceRange {
                                    minVariantPrice {
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
    }
    GRAPHQL;

    $data = $sf->query($query);
    $collections = array_map(fn($e) => $e['node'], $data['collections']['edges'] ?? []);

    // enrich with product count
    $queryCount = <<<'GRAPHQL'
    query getCollectionProducts($handle: String!) {
        collectionByHandle(handle: $handle) {
            productsCount
        }
    }
    GRAPHQL;

    foreach ($collections as &$c) {
        $dc = $sf->query($queryCount, ['handle' => $c['handle']]);
        $c['productsCount'] = $dc['collectionByHandle']['productsCount'] ?? 0;
    }

    return $collections;
}

function get_collection_by_handle(string $handle, int $first = 24): ?array {
    $sf = new storefront();

    $query = <<<'GRAPHQL'
    query getCollection($handle: String!, $first: Int!) {
        collectionByHandle(handle: $handle) {
            id
            title
            handle
            description
            image {
                url
                altText
            }
            products(first: $first) {
                edges {
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
                        images(first: 3) {
                            edges {
                                node {
                                    url
                                    altText
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
    }
    GRAPHQL;

    $data = $sf->query($query, ['handle' => $handle, 'first' => $first]);
    $collection = $data['collectionByHandle'] ?? null;

    if ($collection) {
        $collection['products'] = array_map(
            fn($e) => $e['node'],
            $collection['products']['edges'] ?? []
        );
    }

    return $collection;
}
