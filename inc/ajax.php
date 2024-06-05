<?php

register_ajax([
    'archive_filter'
]);

function archive_filter()
{
    check_ajax_referer('archive-nonce', 'nonce');

    $data = sanitize_post($_POST);
    $page = $data['page'] ?? 1;
    $postsPerPage = get_option('posts_per_page') ?: 16;
    $terms = [];
    $args = [
        'post_status'    => 'publish',
        'posts_per_page' => $postsPerPage,
        'paged'          => $page,
        'offset'         => ($page - 1) * $postsPerPage,
        'orderby'        => 'comment_count',
        'order'          => 'DESC',
        'tax_query'      => [
            'relation' => 'AND'
        ]
    ];

    if (empty($data)) {
        wp_send_json_error('There is no data');
        return;
    }

    $term = $data['term'] ?? '';
    if ($term) {
        $args['tax_query'][] = [
            'taxonomy' => 'category',
            'field'    => 'id',
            'terms'    => [$term]
        ];
    }

    if (!empty($data['medias'])) {
        $terms['social_media'] = $data['medias'];
    }

    if (!empty($data['niches'])) {
        $terms['niche'] = $data['niches'];
    }

    if (!empty($data['languages'])) {
        $terms['language'] = $data['languages'];
    }

    if (!empty($terms)) {
        foreach ($terms as $slug => $termsList) {
            if (empty($termsList)) {
                continue;
            }

            $args['tax_query'][] = [
                'taxonomy' => $slug,
                'field'    => 'id',
                'terms'    => $termsList,
                'operator' => 'AND'
            ];
        }
    }

    $subscribers = $data['subscribers'] ?? [];

    if (!empty($subscribers)) {
        $subscribersRange = explode(',', $subscribers);

        $args['meta_query']['price_query'] = [
            'key'     => 'subscribers',
            'value'   => $subscribersRange,
            'type'    => 'numeric',
            'compare' => 'BETWEEN'
        ];
    }

    $posts = new WP_Query($args);

    ob_start();

    if ($posts->have_posts()) {
        while ($posts->have_posts()) {
            $posts->the_post();
            get_template_part_var('cards/card-post', [
                'post' => $posts->post
            ]);
        }
    } else {
        echo '<p>' . __('Posts not found', DOMAIN) . '</p>';
    }

    $html = ob_get_contents();
    ob_end_clean();

    wp_send_json([
        'posts'     => $html,
        'args'      => $args,
        'max_pages' => $posts->max_num_pages,
        'append'    => $page > 1,
    ]);
}