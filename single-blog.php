<?php
get_header();
$post = get_post();
?>

    <section class="single_blog">
        <div class="container">
            <div class="thumbnail">
                <?php echo get_thumbnail_html($post->ID); ?>
            </div>
            <h1 class="single__title">
                <?php echo esc_html($post->post_title); ?>
            </h1>
            <?php if ($post->post_content) { ?>
                <div class="single__body">
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
                'post_type' => 'blog',
                'post_id'   => $post->ID
            ]); ?>
        </div>
    </section>

<?php
get_footer();