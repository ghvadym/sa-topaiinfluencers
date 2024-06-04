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
            'taxonomy' => $term,
            'operator' => 'EXISTS'
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

    dd($args);

    $posts = _get_posts($args);

    ob_start();

    if (!empty($posts)) {
        foreach ($posts as $post) {
            get_template_part_var('template-parts/cards/card/card-post', [
                'post' => $post
            ]);
        }
    } else {
        echo '<p>' . __('Posts not found', DOMAIN) . '</p>';
    }

    $html = ob_get_contents();
    ob_end_clean();

    wp_send_json([
        'result' => $html
    ]);
}