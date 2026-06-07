/**
 * app.js — aillm satire storefront
 * localStorage cart · Stripe Checkout · terminal-core UI
 */
(function () {
  'use strict';

  const CART_KEY = 'aillm_cart';

  /* ── cart helpers ── */

  function getCart() {
    try {
      return JSON.parse(localStorage.getItem(CART_KEY)) || [];
    } catch {
      return [];
    }
  }

  function saveCart(cart) {
    localStorage.setItem(CART_KEY, JSON.stringify(cart));
  }

  /** Add item (or increment qty). Returns updated cart. */
  function addItemToCart(slug) {
    const cart = getCart();
    const existing = cart.find(function (i) { return i.slug === slug; });
    if (existing) {
      existing.quantity = (existing.quantity || 1) + 1;
    } else {
      cart.push({ slug: slug, quantity: 1 });
    }
    saveCart(cart);
    updateCartBadge();
    return cart;
  }

  /** Remove item entirely. */
  function removeItem(slug) {
    const cart = getCart().filter(function (i) { return i.slug !== slug; });
    saveCart(cart);
    updateCartBadge();
    return cart;
  }

  function clearCart() {
    localStorage.removeItem(CART_KEY);
    updateCartBadge();
  }

  function cartItemCount() {
    return getCart().reduce(function (sum, i) { return sum + (i.quantity || 1); }, 0);
  }

  /* ── badge ── */

  function updateCartBadge() {
    var el = document.getElementById('cart-count');
    if (!el) return;
    var count = cartItemCount();
    el.textContent = count;
    el.style.display = count > 0 ? 'inline-flex' : 'none';
  }

  /* ── render cart page ── */

  function renderCart() {
    var container = document.getElementById('cart-contents');
    var emptyEl = document.getElementById('cart-empty');
    var summaryEl = document.getElementById('cart-summary');
    if (!container) return;

    var cart = getCart();

    if (cart.length === 0) {
      container.innerHTML = '';
      if (emptyEl) emptyEl.style.display = '';
      if (summaryEl) summaryEl.style.display = 'none';
      return;
    }

    if (emptyEl) emptyEl.style.display = 'none';

    // fetch product data for all slugs
    var slugs = cart.map(function (i) { return i.slug; });
    fetchProductBatch(slugs, function (products) {
      var html = '<div class="cart-items">';
      var subtotal = 0;
      var totalTokens = 0;

      cart.forEach(function (item) {
        var p = products[item.slug];
        var name = p ? p.name : item.slug;
        var price = p ? p.price_display : '—';
        var priceCents = p ? p.price_cents : 0;
        var tokens = p ? parseInt(p.token_price) || 0 : 0;
        var qty = item.quantity || 1;

        subtotal += priceCents * qty;
        totalTokens += tokens * qty;

        html += '<div class="cart-item">';
        html += '  <div class="cart-item-info">';
        html += '    <div class="cart-item-name">' + esc(name) + '</div>';
        html += '    <div class="cart-item-price">' + esc(price) + '</div>';
        html += '  </div>';
        html += '  <div class="cart-item-actions">';
        html += '    <span class="cart-item-qty">×' + qty + '</span>';
        html += '    <button class="cart-item-remove" data-slug="' + esc(item.slug) + '">remove</button>';
        html += '  </div>';
        html += '</div>';
      });

      html += '</div>';
      container.innerHTML = html;

      if (summaryEl) {
        summaryEl.style.display = '';
        document.getElementById('cart-subtotal').textContent = '$' + (subtotal / 100).toFixed(2);
        document.getElementById('cart-tokens').textContent = '~' + totalTokens + 'k tokens';
      }

      // wire remove buttons
      container.querySelectorAll('.cart-item-remove').forEach(function (btn) {
        btn.addEventListener('click', function () {
          var slug = btn.getAttribute('data-slug');
          renderCart(); // re-render after removal
        });
      });
    });
  }

  /* ── fetch product data in batch ── */

  function fetchProductBatch(slugs, callback) {
    // try to pull from a known endpoint or embed data
    // we fetch the shop page's data via a JSON endpoint
    var xhr = new XMLHttpRequest();
    xhr.open('GET', '/api/products.json?slugs=' + encodeURIComponent(slugs.join(',')), true);
    xhr.onload = function () {
      if (xhr.status === 200) {
        try {
          var data = JSON.parse(xhr.responseText);
          callback(data);
          return;
        } catch (e) { /* fall through */ }
      }
      // fallback: load from product detail pages one by one
      fetchProductsFallback(slugs, callback);
    };
    xhr.onerror = function () {
      fetchProductsFallback(slugs, callback);
    };
    xhr.send();
  }

  function fetchProductsFallback(slugs, callback) {
    var result = {};
    var pending = slugs.length;
    if (pending === 0) { callback(result); return; }

    slugs.forEach(function (slug) {
      var xhr = new XMLHttpRequest();
      xhr.open('GET', '/api/product-data.json?slug=' + encodeURIComponent(slug), true);
      xhr.onload = function () {
        if (xhr.status === 200) {
          try {
            var p = JSON.parse(xhr.responseText);
            result[slug] = p;
          } catch (e) { /* skip */ }
        }
        pending--;
        if (pending === 0) callback(result);
      };
      xhr.onerror = function () {
        pending--;
        if (pending === 0) callback(result);
      };
      xhr.send();
    });
  }

  /* ── checkout ── */

  function handleCheckout() {
    var cart = getCart();
    if (cart.length === 0) return;

    var overlay = document.getElementById('checkout-overlay');
    if (overlay) overlay.style.display = '';

    var xhr = new XMLHttpRequest();
    xhr.open('POST', '/api/create-checkout.php', true);
    xhr.setRequestHeader('Content-Type', 'application/json');

    xhr.onload = function () {
      if (overlay) overlay.style.display = 'none';
      if (xhr.status === 200) {
        try {
          var data = JSON.parse(xhr.responseText);
          if (data.url) {
            clearCart();
            window.location.href = data.url;
            return;
          }
        } catch (e) { /* fall through */ }
      }
      alert('checkout error. the model might be overloaded. try again?');
    };

    xhr.onerror = function () {
      if (overlay) overlay.style.display = 'none';
      alert('network error. check your connection and try again.');
    };

    xhr.send(JSON.stringify({ items: cart }));
  }

  /* ── product page add-to-cart ── */

  function addToCart(slug) {
    addItemToCart(slug);
    var btn = document.querySelector('.add-to-cart-btn');
    if (btn) {
      var orig = btn.textContent;
      btn.textContent = '✓ added';
      btn.disabled = true;
      setTimeout(function () {
        btn.textContent = orig;
        btn.disabled = false;
      }, 1500);
    }
  }

  /* ── product listing add-to-cart ── (for cards with add buttons) ── */

  function addToCartFromCard(slug, btnEl) {
    addItemToCart(slug);
    var orig = btnEl.textContent;
    btnEl.textContent = '✓';
    btnEl.disabled = true;
    setTimeout(function () {
      btnEl.textContent = orig;
      btnEl.disabled = false;
    }, 1500);
  }

  /* ── helpers ── */

  function esc(s) {
    if (typeof s !== 'string') return s;
    var div = document.createElement('div');
    div.appendChild(document.createTextNode(s));
    return div.innerHTML;
  }

  /* ── init ── */

  document.addEventListener('DOMContentLoaded', function () {
    updateCartBadge();

    // cart page
    if (document.getElementById('cart-contents')) {
      renderCart();
    }

    // wire checkout button
    var checkoutBtn = document.getElementById('checkout-btn');
    if (checkoutBtn) {
      checkoutBtn.addEventListener('click', handleCheckout);
    }
  });

  /* ── expose to inline onclick handlers ── */
  window.addToCart = addToCart;
  window.addToCartFromCard = addToCartFromCard;
  window.handleCheckout = handleCheckout;

})();
