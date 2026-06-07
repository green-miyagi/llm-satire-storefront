/**
 * storefront.js — client-side cart management
 * green miyagi style: minimal, no jquery, no cruft
 */

(function() {
    'use strict';

    // --- cart helpers ---
    function getCartId() {
        return localStorage.getItem('cartId');
    }

    function setCartId(id) {
        localStorage.setItem('cartId', id);
    }

    async function api(path, options = {}) {
        try {
            const res = await fetch(path, {
                headers: { 'Content-Type': 'application/json' },
                ...options,
            });
            return await res.json();
        } catch (e) {
            console.warn('storefront api error:', e);
            return null;
        }
    }

    async function addToCart(variantId, quantity = 1) {
        const cartId = getCartId();
        const payload = { lines: [{ variantId, quantity }] };

        let result;
        if (cartId) {
            payload.cartId = cartId;
            result = await api('/api/cart-endpoint.php?action=add', {
                method: 'POST',
                body: JSON.stringify(payload),
            });
        } else {
            result = await api('/api/cart-endpoint.php?action=add', {
                method: 'POST',
                body: JSON.stringify(payload),
            });
        }

        if (result && result.id) {
            setCartId(result.id);
            updateCartCount(result.totalQuantity || 0);
        }

        return result;
    }

    async function updateCartCount(count) {
        const el = document.getElementById('cart-count');
        if (el) el.textContent = count;
    }

    async function syncCartCount() {
        const cartId = getCartId();
        if (!cartId) return;
        const cart = await api('/api/cart-endpoint.php?action=get&cartId=' + encodeURIComponent(cartId));
        if (cart && cart.totalQuantity != null) {
            updateCartCount(cart.totalQuantity);
        }
    }

    // --- event handlers ---
    document.addEventListener('click', async function(e) {
        const btn = e.target.closest('.add-to-cart');
        if (!btn) return;

        e.preventDefault();
        const variantId = btn.dataset.variantId;
        const title = btn.dataset.productTitle || 'product';

        btn.textContent = 'thinking...';
        btn.disabled = true;

        const result = await addToCart(variantId);

        if (result && result.id) {
            btn.textContent = '✓ added to context';
            setTimeout(() => {
                btn.textContent = 'add to context window';
                btn.disabled = false;
            }, 2000);
        } else {
            btn.textContent = 'error — try again';
            setTimeout(() => {
                btn.textContent = 'add to context window';
                btn.disabled = false;
            }, 2000);
        }
    });

    // --- init ---
    document.addEventListener('DOMContentLoaded', function() {
        syncCartCount();
    });

})();
