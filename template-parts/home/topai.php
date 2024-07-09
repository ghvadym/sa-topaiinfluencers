<?php

$posts = _get_posts([
    'post_type'   => 'blog',
    'numberposts' => wp_is_mobile() ? 4 : 8
]);

if (empty($posts)) {
    echo sprintf('<h3>%s</h3>', __('There are no AI Models', DOMAIN));
    return;
}
?>

<section class="influencers_section">
    <div class="container">
        <h2 class="title">
            <?php _e('Blog', DOMAIN); ?>
        </h2>
        <div class="articles influencers__list">
            <?php foreach ($posts as $post) {
                get_template_part_var('cards/card-post', [
                    'post'           => $post,
                    'full_card_info' => true
                ]);
            } ?>
        </div>
        <div class="articles__btn">
            <a href="<?php echo get_post_type_archive_link('blog'); ?>" class="btn">
                <?php _e('View More Posts', DOMAIN); ?>
            </a>
        </div>
    </div>
</section>
