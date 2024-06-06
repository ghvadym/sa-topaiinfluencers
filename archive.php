<?php
get_header();
$taxonomy = get_queried_object();

$posts = _get_posts([
    'category_name' => $taxonomy->slug
]);

$postsInfo = wp_count_posts();
$allPostsCount = $postsInfo->publish ?? 0;
?>

<section class="archive">
    <div class="container">
        <h1 class="title">
            <?php echo $taxonomy->name; ?>
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
                                    'terms' => get_terms([
                                        'taxonomy'   => 'social_media',
                                        'hide_empty' => true
                                    ])
                                ]); ?>
                            </div>
                            <div class="archive__filter_item">
                                <?php get_template_part_var('global/select-custom', [
                                    'name'    => 'subscribers',
                                    'type'    => 'radio',
                                    'title'   => __('Subscribers', DOMAIN),
                                    'options' => [
                                        '0'                   => '0',
                                        '0,1000'              => '0 - 1.000',
                                        '1000,10000'          => '1.000 - 10.000',
                                        '10000,100000'        => '10.000 - 100.000',
                                        '100000,1000000'      => '100.000 - 1.000.000',
                                        '1000000,10000000'    => '1.000.000 - 10.000.000',
                                        '10000000,1000000000' => '10.000.000+'
                                    ]
                                ]); ?>
                            </div>
                            <div class="archive__filter_item">
                                <?php get_template_part_var('global/select-terms', [
                                    'name'  => 'niches',
                                    'title' => __('Niches', DOMAIN),
                                    'terms' => get_terms([
                                        'taxonomy'   => 'niche',
                                        'hide_empty' => true
                                    ])
                                ]); ?>
                            </div>
                            <div class="archive__filter_item">
                                <?php get_template_part_var('global/select-terms', [
                                    'name'  => 'languages',
                                    'title' => __('Languages', DOMAIN),
                                    'terms' => get_terms([
                                        'taxonomy'   => 'language',
                                        'hide_empty' => true
                                    ])
                                ]); ?>
                            </div>
                            <div class="archive__filter_item">
                                <div class="archive__filter_reset">
                                    <img src="<?php img_url('Close.svg'); ?>" alt="">
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="term" value="<?php echo $taxonomy->term_id; ?>">
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
                                <?php _e('Lazy load', DOMAIN); ?>
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