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
    }else {
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