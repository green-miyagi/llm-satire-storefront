# llm satire — storefront

headless shopify storefront for an llm-themed satire store.
green miyagi distribution. no capitals. no hero. no noise.

## architecture

```
your domain (aillm.space)
└─ public/           → web root (html, php, assets)
   ├── api/          → ajax endpoints (cart, etc.)
   ├── assets/       → css, js, images
   ├── index.php     → home
   ├── products.php  → product listing
   ├── product.php   → product detail
   ├── collections.php → collection listing
   ├── cart.php      → cart / checkout
   └── about.php     → model card
src/
└── api/             → shopify storefront graphql client
    ├── storefront.php  → graphql client
    ├── products.php    → product queries
    ├── collections.php → collection queries
    └── cart.php        → cart mutations
```

## setup

### 1. shopify store

create a development store at partners.shopify.com → stores → add store → development store.

enable **headless** / **storefront api** in store settings → sales channels → headless.

### 2. storefront api token

1. shopify admin → settings → apps and sales channels → develop apps
2. create an app → enable **storefront api integration**
3. copy the `storefront access token`

### 3. environment

copy `.env.example` to `.env` and fill in:

```
STOREFRONT_API_TOKEN=your_storefront_access_token
STORE_DOMAIN=your-store.myshopify.com
STOREFRONT_API_VERSION=2024-10
```

### 4. run locally

```bash
php -S localhost:8080 -t public
```

## deploy

### option a: git → hostinger (recommended)

```bash
git remote add hostinger your-hostinger-user@your-hostinger-host:~/your-path/.git
git push hostinger main
```

### option b: github actions

add these secrets to your github repo:
- `HOSTINGER_SSH_KEY` — your ssh private key
- `HOSTINGER_HOST` — hostinger server hostname
- `HOSTINGER_USER` — hostinger username
- `HOSTINGER_PATH` — path to web root on hostinger

push to main → auto-deploys.

## building the catalog

use the shopify admin api to create products, collections, metafields.
the `green-miyagi-shopify` project has the tooling for this:

```bash
cd ../green-miyagi-shopify
# edit products.ts for the llm satire catalog
bun run products
```

## style

green miyagi says: no capitals. no hero. no noise. minimal. breathing space. low gloss.

## license

this is satire. there is no license. if you take this seriously, that's on you.
