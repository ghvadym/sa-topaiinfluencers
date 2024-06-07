<?php
get_header();
$post = get_post();

$content = $post->post_content ? explode('<!-- wp:heading -->', $post->post_content) : [];
$content = array_filter($content);
?>

<section class="single">
    <div class="container">
        <div class="thumbnail">
            <?php echo get_thumbnail_html($post->ID); ?>
        </div>
        <div class="text_block">
            <div class="single__content card">
                <?php get_template_part_var('cards/card-single', [
                    'post' => $post
                ]); ?>
            </div>
            <?php if (!empty($content)) { ?>
                <?php foreach ($content as $key => $val) { ?>
                    <div class="single__content">
                        <?php echo $val; ?>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
    </div>
</section>

<?php
get_footer();