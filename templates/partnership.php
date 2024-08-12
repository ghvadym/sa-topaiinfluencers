<?php
/*
 * Template Name: Partnership
 */
get_header();
$post = get_post();
$fields = get_fields($post->ID);
$contents = $fields['content'] ?? [];

$contentBlocks = $post->post_content ? explode('<!-- wp:heading -->', $post->post_content) : [];
$contentBlocks = array_filter($contentBlocks);
?>

<section class="page">
    <div class="container">
        <h1>
            <?php if (!empty($fields['custom_title'])) {
                echo esc_html($fields['custom_title']);
            } else {
                echo esc_html($post->post_title);
            } ?>
        </h1>
        <?php if (!empty($contents)) { ?>
            <div class="content_blocks">
                <?php foreach ($contents as $content) {
                    $imgId = $content['img'] ?? '';
                    $text = $content['text'] ?? '';

                    if ($imgId) {
                        $imgUrl = wp_get_attachment_image_url($imgId, 'large');
                        $label = get_post_meta($imgId, '_wp_attachment_image_alt', true);
                    }
                    ?>
                    <div class="content_block text_block">
                        <?php if ($text) { ?>
                            <div class="content_block__text">
                                <?php echo $text; ?>
                            </div>
                        <?php } ?>
                        <?php if (!empty($imgUrl)) { ?>
                            <div class="content_block__img">
                                <img src="<?php echo esc_url($imgUrl); ?>" alt="<?php echo $label ?? ''; ?>">
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
        <?php if ($post->post_content) { ?>
            <div class="page_content">
                <?php echo do_shortcode('[ez-toc]'); ?>
                <div class="text_block_full">
                    <?php if (!empty($contentBlocks)) { ?>
                        <?php foreach ($contentBlocks as $content) { ?>
                            <div class="single__content">
                                <?php echo apply_filters('the_content', $content); ?>
                            </div>
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
    </div>
</section>

<?php
get_footer();