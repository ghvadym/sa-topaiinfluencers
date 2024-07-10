<?php

function breadcrumbs()
{
    if (function_exists('yoast_breadcrumb')) {
        yoast_breadcrumb('<p id="breadcrumbs" class="breadcrumbs">', '</p>');
    }
}

function custom_get_page_title(): string
{
    $blogName = get_bloginfo('name');
    if (is_archive() || is_tax()) {
        $postData = get_queried_object();
        $title = ucfirst($postData->name) . ' - ' . $blogName;
    } else if (is_home() || is_front_page()) {
        $title = get_bloginfo('name');
    } else {
        $title = get_the_title() . ' - ' . $blogName;;
    }

    return $title;
}

function api_request(array $args = [])
{
    if (empty($args)) {
        return [];
    }

    $curlUrl = $args['curl_url'] ?? '';
    $method = $args['method'] ?? 'GET';
    $postData = $args['data'] ?? [];
    $header = $args['headers'] ?? [];

    $curl = curl_init();

    $params = [
        CURLOPT_URL            => $curlUrl,
        CURLINFO_HEADER_OUT    => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER     => $header,
        CURLOPT_CUSTOMREQUEST  => $method
    ];

    if ($method !== 'GET' && !empty($postData)) {
        $params[CURLOPT_POSTFIELDS] = json_encode($postData);
    }

    curl_setopt_array($curl, $params);

    $response = curl_exec($curl);

    curl_close($curl);

    return json_decode($response);
}

function models_subscription_updates_control()
{
    $socials = socials_data();

    $args = [
        'numberposts' => -1
    ];

    if (!empty($socials)) {
        foreach ($socials as $socialKey => $class) {
            if (!isset($args['meta_query'])) {
                $args['meta_query'] = [
                    'relation' => 'OR'
                ];
            }

            $args['meta_query'][] = [
                'key'     => $socialKey,
                'compare' => '!=',
                'value'   => ''
            ];
        }
    }

    $posts = _get_posts($args);

    if (empty($posts)) {
        return;
    }

    $i = 0;

    foreach ($posts as $post) {
        if ($i > EVENT_COUNT_POSTS_PER_CALL) {
            break;
        }

        $subscription_update_time = get_post_meta($post->ID, 'subscription_update_time', true);

        /* If data updated recently */
        if ($subscription_update_time && $subscription_update_time > time()) {
            continue;
        }

        $fields = get_fields($post->ID);

        foreach ($socials as $social => $className) {
            if (!class_exists($className)) {
                continue;
            }

            $socialName = $fields[$social] ?? '';

            if (!$socialName) {
                continue;
            }

            try {
                $className::updateSubscribers($socialName, $post->ID);
            } catch (Exception $exception) {}
        }

        update_post_meta($post->ID, 'subscription_update_time', time() + EVENT_TIME_TO_CHECK);

        $i++;
    }
}

function count_posts(string $term = ''): array
{
    $args = [
        'numberposts' => -1,
        'fields'      => 'ids'
    ];

    if ($term) {
        $args['category_name'] = $term;
    }

    return _get_posts($args);
}