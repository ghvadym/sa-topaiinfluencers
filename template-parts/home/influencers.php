<?php

$categoryName = 'ai-influencers-list';

$posts = _get_posts([
    'numberposts'   => wp_is_mobile() ? 4 : 8,
    'category_name' => $categoryName
]);

if (empty($posts)) {
    echo sprintf('<h3>%s</h3>', __('There are no influencers', DOMAIN));
    return;
}
?>

<section class="influencers_section">
    <div class="container">
        <h2 class="title">
            <?php _e('AI Influencers', DOMAIN); ?>
        </h2>
        <div class="articles influencers__list">
            <?php foreach ($posts as $post) {
                get_template_part_var('cards/card-post', [
                    'post' => $post
                ]);
            } ?>
        </div>
        <div class="articles__btn">
            <a href="<?php echo home_url($categoryName.DIRECTORY_SEPARATOR); ?>" class="btn">
                <?php _e('View All Influencers', DOMAIN); ?>
            </a>
        </div>
    </div>
</section>
