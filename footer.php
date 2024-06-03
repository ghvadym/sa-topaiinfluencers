<?php
wp_footer();
if (is_home() || is_front_page() || is_archive() || is_single()) {
    get_template_part_var('global/faq');
}
?>

</main>

<footer id="footer" class="footer">
    <div class="container">
        <div class="footer__body">
            <div class="footer__row">
                <div class="footer__col">
                    <div class="footer__content">
                        <?php if (function_exists('the_custom_logo') && has_custom_logo()): ?>
                            <div class="footer__logo logo">
                                <?php the_custom_logo(); ?>
                            </div>
                        <?php endif; ?>
                        <?php if ($footer_text = get_field('footer_text', 'options')) { ?>
                            <div class="footer__text">
                                <?php echo $footer_text; ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <?php get_widgets([
                    'Footer nav 1',
                    'Footer nav 2',
                ]); ?>
                <?php
                $socials = get_field('socials', 'options');
                if (!empty($socials)) { ?>
                    <div class="footer__col">
                        <div class="socials">
                            <?php foreach ($socials as $social) {
                                $image_url = $social['img'] ?? '';
                                $link = $social['link'] ?? '';

                                if (!$image_url || !$link) {
                                    continue;
                                }
                                ?>
                                <div class="social__item">
                                    <a href="<?php echo esc_url($link); ?>" target="_blank" rel="noopener nofollow">
                                        <img src="<?php echo esc_url($image_url); ?>" alt="Social">
                                    </a>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="footer__copyright">
                <?php echo sprintf(
                    '© %s %s',
                    date('Y'),
                    __('Top AI. All Rights Reserved', DOMAIN)
                ); ?>
            </div>
        </div>
    </div>
</footer>

</body>
</html>
