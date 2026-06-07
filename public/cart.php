<?php
/**
 * cart.php — cart page
 */

require_once __DIR__ . '/../src/config.php';
require_once __DIR__ . '/../src/components/header.php';
require_once __DIR__ . '/../src/components/footer.php';

render_header('cart — llm satire');
?>

<section class="section cart-page">
    <h1 class="section-title">context window</h1>
    <p class="section-sub">items you've decided to include in inference</p>

    <div id="cart-contents">
        <div class="cart-empty">
            <p>your context window is empty.</p>
            <a href="/products.php" class="btn">browse products →</a>
        </div>
    </div>

    <div id="cart-summary" class="cart-summary" style="display:none;">
        <div class="cart-total">
            <span>total tokens</span>
            <span id="cart-total-amount">—</span>
        </div>
        <a id="checkout-button" href="#" class="btn btn-primary">
            run inference (checkout)
        </a>
    </div>
</section>

<script>
function loadCart() {
    const cartId = localStorage.getItem('cartId');
    if (!cartId) return;

    fetch('/api/cart-endpoint.php?action=get&cartId=' + encodeURIComponent(cartId))
        .then(r => r.json())
        .then(cart => {
            if (!cart || !cart.lines?.edges?.length) {
                document.querySelector('.cart-empty').style.display = 'block';
                document.getElementById('cart-summary').style.display = 'none';
                document.getElementById('cart-count').textContent = '0';
                return;
            }

            document.querySelector('.cart-empty').style.display = 'none';
            document.getElementById('cart-summary').style.display = 'block';

            const container = document.getElementById('cart-contents');
            let html = '<div class="cart-lines">';
            let total = 0;
            cart.lines.edges.forEach(edge => {
                const item = edge.node;
                const merch = item.merchandise;
                const price = parseFloat(merch.price.amount);
                const subtotal = price * item.quantity;
                total += subtotal;
                html += `
                    <div class="cart-line">
                        <div class="cart-line-info">
                            <h4>${merch.product.title}</h4>
                            <p>${merch.title} × ${item.quantity}</p>
                        </div>
                        <div class="cart-line-price">$${subtotal.toFixed(2)}</div>
                    </div>
                `;
            });
            html += '</div>';
            container.innerHTML = html;

            document.getElementById('cart-total-amount').textContent = '$' + total.toFixed(2);
            document.getElementById('cart-count').textContent = cart.totalQuantity;
            document.getElementById('checkout-button').href = cart.checkoutUrl;
        })
        .catch(() => {});
}

loadCart();
</script>

<?php render_footer(); ?>
