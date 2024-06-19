<?php
get_header();
$term = get_queried_object();

$posts = _get_posts([
    'category_name' => $term->slug
]);

$allPostsCount = count_posts();

$postWithCategoriesIds = get_posts([
    'posts_per_page' => -1,
    'tax_query'      => [
        [
            'taxonomy' => 'category',
            'field'    => 'term_id',
            'terms'    => $term->term_id,
        ],
    ],
    'fields'         => 'ids'
]);
?>

    <section class="archive">
    <div class="container">
        <h1 class="title">
            <?php echo $term->name; ?>
        </h1>

        <?php if (empty($posts)) { ?>
            <h3>
                <?php _e('Posts not found', DOMAIN) ?>
            </h3>
        <?php } else { ?>
            <div class="archive__wrap">
                <form class="archive__filter_wrap">
                    <div class="archive__filter">
                        <div class="archive__filter_list">
                            <div class="archive__filter_item">
                                <?php get_template_part_var('global/select-terms', [
                                    'name'  => 'medias',
                                    'title' => __('Social media', DOMAIN),
                                    'terms' => wp_get_object_terms($postWithCategoriesIds, 'social_media')
                                ]); ?>
                            </div>
                            <div class="archive__filter_item">
                                <?php get_template_part_var('global/select-custom', [
                                    'name'    => 'subscribers',
                                    'type'    => 'radio',
                                    'title'   => __('Subscribers', DOMAIN),
                                    'options' => [
                                        '0'          => '0+',
                                        '1000'       => '1K+',
                                        '10000'      => '10K+',
                                        '100000'     => '100K+',
                                        '1000000'    => '1M+',
                                        '10000000'   => '10M+',
                                        '100000000'  => '100M+',
                                        '1000000000' => '1B+'
                                    ]
                                ]); ?>
                            </div>
                            <div class="archive__filter_item">
                                <?php get_template_part_var('global/select-terms', [
                                    'name'  => 'niches',
                                    'title' => __('Niches', DOMAIN),
                                    'terms' => wp_get_object_terms($postWithCategoriesIds, 'niche')
                                ]); ?>
                            </div>
                            <div class="archive__filter_item">
                                <?php get_template_part_var('global/select-terms', [
                                    'name'  => 'languages',
                                    'title' => __('Languages', DOMAIN),
                                    'terms' => wp_get_object_terms($postWithCategoriesIds, 'language')
                                ]); ?>
                            </div>
                            <div class="archive__filter_item">
                                <div class="archive__filter_reset">
                                    <img src="<?php img_url('Close.svg'); ?>" alt="">
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="term" value="<?php echo $term->term_id; ?>">
                    </div>
                </form>
                <div class="archive__posts_wrap">
                    <div class="archive__posts">
                        <div class="articles">
                            <?php foreach ($posts as $post) {
                                get_template_part_var('cards/card-post', [
                                    'post' => $post
                                ]);
                            } ?>
                        </div>
                    </div>
                    <?php if ($allPostsCount > POSTS_PER_PAGE) { ?>
                        <div class="articles__btn">
                            <span id="articles_load" class="btn" data-page="1">
                                <?php _e('View More', DOMAIN); ?>
                            </span>
                        </div>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
    </div>
</section>

<?php

get_footer();