# aillm satire store

llm-themed satire storefront. physical posters via print-on-demand, digital downloads via Stripe. built with php, no framework, no shopify.

## structure

```
project root (web root on deploy)
├── index.php        → home
├── shop.php         → product listing
├── product.php      → product detail
├── cart.php         → cart / checkout
├── checkout.php     → stripe return / download links
├── download.php     → digital file delivery
├── about.php        → model card
├── router.php       → dev server rewriter
├── .htaccess        → production rewriter (apache)
├── assets/
│   ├── css/style.css
│   ├── js/app.js
│   └── images/      → 18 product images
├── api/
│   └── products.json.php  → json product endpoint
├── src/
│   ├── config.php   → env loader
│   ├── products.php → catalog loader
│   ├── stripe.php   → stripe client
│   └── components/  → header, footer
└── data/
    ├── products.json
    └── downloads/   → digital product files
```

## setup

### 1. stripe

create a stripe account at stripe.com. get your publishable and secret keys.

### 2. environment

copy `.env.example` to `.env` and fill in:

```
STRIPE_SECRET_KEY=sk_test_...
STRIPE_PUBLISHABLE_KEY=pk_test_...
```

### 3. run locally

```bash
php -S localhost:8080 -t . router.php
```

the `router.php` handles pretty urls (`/product/slug`) during local dev. on production, `.htaccess` (apache) does the same.

## deploy

the project root **is** the web root — deploy the entire repo to `public_html/`. no nested `public/` directory.

```bash
# hostinger: push the whole repo to public_html
git remote add hostinger your-user@your-host:~/public_html/.git
git push hostinger main
```

### github actions

add secrets `HOSTINGER_SSH_KEY`, `HOSTINGER_HOST`, `HOSTINGER_USER`, `HOSTINGER_PATH` — push to main deploys.

## product images

18 ai-generated product images in `assets/images/`. generated with draw-things-cli (flux-dev on mps). each product in `data/products.json` references its image by filename stem.

art products (posters) show an amber "also available as physical print" badge. fulfilled via printful / printify / gelato — no upfront cost, global shipping.

## stack

| layer | what |
|---|---|
| runtime | php 8.x (no framework) |
| payments | stripe checkout |
| images | draw-things-cli / flux-dev |
| fulfillment | printful / printify / gelato (pods) |
| hosting | hostinger (apache + php) |

## style

no capitals. no hero. no noise. minimal. breathing space. low gloss.

terminal aesthetic, ascii boxes, model card ui, token economy as a running joke.

## license

this is satire. there is no license. if you take this seriously, that's on you.
