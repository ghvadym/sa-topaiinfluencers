<?php

get_header();
$post = get_post();

if (get_field('use_options_banner', 'options')) {
    $optionsThumbnailId = get_field('posts_banner', 'options');
    $bannerUrl = get_field('banner_url', 'options');
    $bannerImg = $optionsThumbnailId ? wp_get_attachment_image($optionsThumbnailId, 'large') : '';
} else {
    $postThumbnailId = get_field('banner_img', $post->ID);
    $bannerUrl = get_field('banner_url', $post->ID);
    $bannerImg = wp_get_attachment_image($postThumbnailId, 'large');
}

$contentBlocks = $post->post_content ? explode('<!-- wp:heading -->', $post->post_content) : [];
$contentBlocks = array_filter($contentBlocks);
?>

<section class="single">
    <div class="container">
        <?php if ($bannerImg) { ?>
            <?php if ($bannerUrl) { ?>
                <a href="<?php echo esc_url($bannerUrl); ?>" class="thumbnail" target="_blank" rel="noopener nofollow">
                    <?php echo $bannerImg; ?>
                </a>
            <?php } else { ?>
                <div class="thumbnail">
                    <?php echo $bannerImg; ?>
                </div>
            <?php } ?>
        <?php } ?>
        <div class="text_block">
            <div class="single__content card">
                <?php get_template_part_var('cards/card-single', [
                    'post' => $post
                ]); ?>
            </div>

            <?php if (!empty($contentBlocks)) { ?>
                <?php foreach ($contentBlocks as $content) { ?>
                    <div class="single__content">
                        <?php echo apply_filters('the_content', $content); ?>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
    </div>
</section>

<?php

get_template_part_var('global/faq', [
    'faq_list' => get_field('faq', $post->ID)
]);

get_footer();