<?php
get_header();
$taxonomy = get_queried_object();

$posts = get_posts([
    'post_status'   => 'publish',
    'numberposts'   => get_option('posts_per_page') ?: 16,
    'orderby'       => 'comment_count',
    'order'         => 'DESC',
    'category_name' => $taxonomy->slug
]);
?>

    <div class="archive">
        <div class="container">
            <h1 class="title">
                <?php echo $taxonomy->name; ?>
            </h1>

            <form class="archive__filter_wrap">
                <div class="archive__filter">
                    <div class="archive__filter_list">
                        <div class="archive__filter_item">
                            <?php get_template_part_var('global/select', [
                                'name'    => 'medias',
                                'title'   => __('Social media', DOMAIN),
                                'options' => get_terms([
                                    'taxonomy'   => 'social_media',
                                    'hide_empty' => true,
                                    'fields'     => 'id=>slug',
                                ]),
                            ]); ?>
                        </div>
                        <div class="archive__filter_item">
                            <?php get_template_part_var('global/select', [
                                'name'    => 'subscribers',
                                'type'    => 'radio',
                                'title'   => __('Subscribers', DOMAIN),
                                'options' => [
                                    '0,1000'              => '0 - 1.000',
                                    '1000,10000'          => '1.000 - 10.000',
                                    '10000,100000'        => '10.000 - 100.000',
                                    '100000,1000000'      => '100.000 - 1.000.000',
                                    '1000000,10000000'    => '1.000.000 - 10.000.000',
                                    '10000000,1000000000' => '10.000.000+'
                                ],
                            ]); ?>
                        </div>
                        <div class="archive__filter_item">
                            <?php get_template_part_var('global/select', [
                                'name'    => 'niches',
                                'title'   => __('Niches', DOMAIN),
                                'options' => get_terms([
                                    'taxonomy'   => 'niche',
                                    'hide_empty' => true,
                                    'fields'     => 'id=>slug',
                                ]),
                            ]); ?>
                        </div>
                        <div class="archive__filter_item">
                            <?php get_template_part_var('global/select', [
                                'name'    => 'languages',
                                'title'   => __('Languages', DOMAIN),
                                'options' => get_terms([
                                    'taxonomy'   => 'language',
                                    'hide_empty' => true,
                                    'fields'     => 'id=>slug',
                                ]),
                            ]); ?>
                        </div>
                    </div>
                    <input type="hidden" name="term" value="<?php echo $taxonomy->slug; ?>">
                </div>
            </form>

            <div class="archive__posts">
                <div class="articles">
                    <?php foreach ($posts as $post) {
                        get_template_part_var('cards/card-post', [
                            'post' => $post,
                        ]);
                    } ?>
                </div>
                <div class="articles__btn" data-page="1">
                    <span class="btn">
                        <?php _e('Lazy load', DOMAIN); ?>
                    </span>
                </div>
            </div>
        </div>
    </div>

<?php

get_footer();