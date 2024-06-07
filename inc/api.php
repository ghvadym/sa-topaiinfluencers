<?php

function send_response_youtube_api(string $channelId = '', int $userId = 0): array
{
    $channelId = 'UCYPG0U6cSqfqSV8E7OoGWoA';
    if (!$channelId) {
        return [];
    }

    //$apiKey = get_field('youtube_api_key', 'options');
    $apiKey = 'AIzaSyBtEkAa53OkQ0yL5A6PWkeJBcVvkXd4ki0';

    if (!$apiKey) {
        return [];
    }

    $responseUrl = sprintf(
        'https://www.googleapis.com/youtube/v3/channels?part=statistics&id=%s&key=%s',
        $channelId,
        $apiKey
    );

    $response = file_get_contents($responseUrl);

    $responseArray = json_decode($response, true);

    if (empty($responseArray['items'])) {
        return [];
    }

    $statistics = $responseArray['items'][0]['statistics'] ?? [];

    if (empty($statistics)) {
        return [];
    }

    $statisticsData = [
        'subscribers'  => $statistics['subscriberCount'] ?? '',
        'videos_count' => $statistics['videoCount'] ?? '',
        'views_count'  => $statistics['viewCount'] ?? ''
    ];

    if ($userId) {
        foreach ($statisticsData as $key => $val) {
            if ($val === '') {
                continue;
            }

            update_post_meta($userId, $key, $val);
        }
    }

    return $statisticsData;
}