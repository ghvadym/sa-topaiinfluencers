<?php
$posts = _get_posts([
    'post_type'    => $post_type ?? 'blog',
    'numberposts'  => 4,
    'post__not_in' => !empty($post_id) ? [$post_id] : []
]);
?>

<div class="articles_slider_wrap">
    <div class="articles_slider swiper">
        <div class="swiper-wrapper">
            <?php foreach ($posts as $post) {
                get_template_part_var('cards/card-post', [
                    'post'           => $post,
                    'full_card_info' => !empty($post_type) && $post_type !== 'post',
                    'slider'         => true
                ]);
            } ?>
        </div>
    </div>
</div>
<div class="articles__btn">
    <a href="<?php echo get_post_type_archive_link('blog'); ?>" class="btn">
        <?php _e('View More Posts', DOMAIN); ?>
    </a>
</div>