<?php
/*
 * Template Name: Blog
 * */
get_header();

$posts = _get_posts();
?>

<section class="archive">
    <div class="container">
        <h1 class="title">
            <?php the_title(); ?>
        </h1>
        <?php if (empty($posts)) { ?>
            <h3>
                <?php _e('Posts not found', DOMAIN) ?>
            </h3>
        <?php } else { ?>
            <div class="archive__posts_wrap">
                <div class="archive__posts">
                    <div class="articles">
                        <?php foreach ($posts as $post) {
                            get_template_part_var('cards/card-post', [
                                'post'           => $post,
                                'full_card_info' => true
                            ]);
                        } ?>
                    </div>
                </div>
                <?php if (ALL_POSTS_COUNT > POSTS_PER_PAGE) { ?>
                    <div class="articles__btn">
                        <span id="articles_load" class="btn" data-page="1" data-full-card="1">
                            <?php _e('Lazy load', DOMAIN); ?>
                        </span>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
</section>

<?php
get_footer();