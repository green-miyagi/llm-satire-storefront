# aillm satire store

llm-themed satire storefront. digital downloads via Stripe. built with php, no framework, no shopify.

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
├── 404.php          → error page
├── router.php       → dev server rewriter
├── .htaccess        → production rewriter (apache)
├── assets/
│   ├── css/style.css
│   ├── js/app.js
│   └── images/      → 18 product images
├── api/
│   ├── products.json.php  → json product endpoint
│   └── create-checkout.php → stripe checkout session
├── src/
│   ├── config.php   → env loader
│   ├── products.php → catalog loader
│   ├── stripe.php   → stripe curl client
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
SITE_URL=http://localhost:8080
SITE_NAME=aillm satire
```

### 3. run locally

```bash
php -S localhost:8080 -t . router.php
```

the `router.php` handles pretty urls (`/product/slug`) during local dev. on production, `.htaccess` (apache) does the same.

## deploy

the project root **is** the web root — deploy the entire repo to `public_html/`. no nested `public/` directory.

### rsync (quick)

```bash
rsync -avz --delete --exclude='.git' --exclude='.env' --exclude='README.md' \
  -e "ssh -p 65002" \
  ./ u511131261@212.85.29.56:domains/aillm.space/public_html/
```

### github actions

add these secrets to the github repo:
- `HOSTINGER_SSH_KEY` — ssh private key
- `HOSTINGER_HOST` — `212.85.29.56`
- `HOSTINGER_USER` — `u511131261`
- `HOSTINGER_PATH` — `domains/aillm.space/public_html`

push to main → auto-deploys.

## product images

18 ai-generated product images in `assets/images/`. generated with draw-things-cli (flux-dev on mps). each product in `data/products.json` references its image by filename stem.

## stack

| layer | what |
|---|---|
| runtime | php 8.x (no framework) |
| payments | stripe checkout (live) |
| images | draw-things-cli / flux-dev |
| hosting | hostinger (apache + php) |

## style

no capitals. no hero. no noise. minimal. breathing space. low gloss.

terminal aesthetic, ascii boxes, model card ui, token economy as a running joke.

## license

this is satire. there is no license. if you take this seriously, that's on you.
