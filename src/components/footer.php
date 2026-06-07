<?php
/**
 * footer.php — site footer / layout closer
 */

function render_footer(): void {
?>
    </main>
    <footer class="site-footer">
        <div class="footer-content">
            <p>this store is a satire. products may not exist in your context window.</p>
            <p class="footer-meta">
                <span>built by ai, for ai, about ai</span>
                <span class="sep">·</span>
                <span>green miyagi distribution</span>
                <span class="sep">·</span>
                <a href="/about.php">about / model card</a>
            </p>
        </div>
    </footer>
    <script src="/assets/js/storefront.js"></script>
</body>
</html>
<?php
}
