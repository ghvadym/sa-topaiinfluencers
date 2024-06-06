<?php

register_ajax([
    'archive_filter'
]);

function archive_filter()
{
    check_ajax_referer('archive-nonce', 'nonce');

    $data = sanitize_post($_POST);
    $page = $data['page'] ?? 1;
    $postType = $data['post_type'] ?? 'post';
    $terms = [];

    if (empty($data)) {
        wp_send_json_error('There is no data');
        return;
    }

    $args = [
        'post_type'      => $postType,
        'post_status'    => 'publish',
        'posts_per_page' => POSTS_PER_PAGE,
        'paged'          => $page,
        'offset'         => ($page - 1) * POSTS_PER_PAGE,
        'orderby'        => 'DATE',
        'order'          => 'DESC',
    ];

    if ($postType === 'post') {
        $args['tax_query'] = [
            'relation' => 'AND'
        ];

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
    }

    $posts = new WP_Query($args);

    ob_start();

    if ($posts->have_posts()) {
        while ($posts->have_posts()) {
            $posts->the_post();
            get_template_part_var('cards/card-post', [
                'post'           => $posts->post,
                'full_card_info' => $postType !== 'post'
            ]);
        }
    } else {
        echo '<h3>' . __('Posts not found', DOMAIN) . '</h3>';
    }

    $html = ob_get_contents();
    ob_end_clean();

    wp_send_json([
        'posts'     => $html,
        'args'      => $args,
        'max_pages' => $posts->max_num_pages,
        'append'    => $page > 1
    ]);
}