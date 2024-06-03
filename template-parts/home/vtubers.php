<?php
$posts = get_posts([
    'numberposts'   => wp_is_mobile() ? 4 : 8,
    'orderby'       => 'comment_count',
    'order'         => 'DESC',
    'category_name' => 'popular-vtubers'
]);

if (empty($posts)) {
    echo sprintf('<h3>%s</h3>', __('There are no VTubers', DOMAIN));
    return;
}
?>

<section class="influencers_section">
    <div class="container">
        <h2 class="articles__title">
            <?php _e('VTubers', DOMAIN); ?>
        </h2>
        <div class="articles influencers__list">
            <?php foreach ($posts as $post) {
                get_template_part_var('cards/card-post', [
                    'post' => $post
                ]);
            } ?>
        </div>
        <div class="articles__btn">
            <span class="btn">
                <?php _e('View All VTubers'); ?>
            </span>
        </div>
    </div>
</section>
