<?php

register_ajax([
    'get_posts_request'
]);

function get_posts_request()
{
    $data = sanitize_post($_POST);
    $args = [];

    //dd($data);

    $categories = $data['categories'] ?? '';

    if ($categories) {
        $categories = explode(',', $categories);

        $args['tax_query'] = [
            [
                'taxonomy' => 'category',
                'field'    => 'id',
                'terms'    => $categories
            ]
        ];
    }

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