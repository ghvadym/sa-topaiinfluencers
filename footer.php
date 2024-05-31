<?php
wp_footer();
?>

</main>

<footer id="footer" class="footer">
    <div class="container">
        <div class="row">
            <?php if (function_exists('the_custom_logo') && has_custom_logo()): ?>
                <div class="footer__logo logo">
                    <?php the_custom_logo(); ?>
                </div>
            <?php endif; ?>
            <div class="footer__menu">
                <?php /*get_widgets([
                    'Footer nav 1'
                ]);*/ ?>
            </div>
        </div>
    </div>
</footer>

</body>
</html>
