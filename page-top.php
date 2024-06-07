<?php
/*
 * Template Name: Top 10
 */
get_header();
$post = get_post();
?>

<section class="page">
    <div class="container">
        <div class="thumbnail">
            <?php echo get_thumbnail_html($post->ID); ?>
        </div>
        <?php if ($post->post_content) { ?>
            <div class="text_block_full">
                <?php the_content(); ?>
            </div>
        <?php } ?>
    </div>
</section>
<section class="more_posts">
    <div class="container">
        <h2 class="title">
            <?php _e('More blog posts', DOMAIN); ?>
        </h2>
        <?php get_template_part_var('global/more-posts', [
            'post_type' => 'blog'
        ]); ?>
    </div>
</section>

<?php
get_footer();
