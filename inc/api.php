<?php

function send_response_youtube_api(string $channelId = '', int $userId = 0)
{
    /* temporary */
    $channelId = 'UCYPG0U6cSqfqSV8E7OoGWoA';
    $userId = 1096;
    /* temporary end */

    if (!$channelId) {
        return;
    }

    $apiKey = get_api_key('youtube_api');

    if (empty($apiKey)) {
        return;
    }

    $responseUrl = 'https://www.googleapis.com/youtube/v3/channels?' . http_build_query([
        'part' => 'statistics',
        'id'   => $channelId,
        'key'  => $apiKey
    ]);

    $response = file_get_contents($responseUrl);

    $responseArray = json_decode($response, true);

    if (empty($responseArray['items'])) {
        return;
    }

    $statistics = $responseArray['items'][0]['statistics'] ?? [];

    if (empty($statistics)) {
        return;
    }

    if (isset($statistics['subscriberCount'])) {
        update_field('youtube_subscribers', $statistics['subscriberCount'] ?? 0, $userId);
    }
}

function send_response_twitch_api(string $username = '', int $userId = 0)
{
    /* temporary */
    $username = 'gust_taid';
    $userId = 1096;
    /* temporary end */

    if (!$username || !$userId) {
        return;
    }

    $clientId = get_api_key('twitch_client_id');

    if (empty($clientId)) {
        return;
    }

    $token = twitch_token($clientId);

    if (empty($token)) {
        return;
    }

    $broadcasterId = get_twitch_user_id($username, $token, $clientId);

    if (!$broadcasterId) {
        return;
    }

    $subscribers = twitch_api_request([
        'token'     => $token,
        'client_id' => $clientId,
        'curl_url'  => 'https://api.twitch.tv/helix/channels/followers?' . http_build_query([
            'broadcaster_id' => $broadcasterId
        ])
    ]);

    if (!empty($subscribers->total)) {
        update_field('twitch_subscribers', $subscribers->total, $userId);
    }
}

function twitch_token($clientId = 0): string
{
    if (!$clientId) {
        return '';
    }

    $token = get_option('twitch_access_token', '');
    $tokenExpirationTime = get_option('twitch_access_token_expires_in', '');
    $clientSecret = get_api_key('twitch_client_secret');

    if (!$clientSecret) {
        return $token;
    }

    if (!$token || !$tokenExpirationTime || $tokenExpirationTime < time()) {
        $response = http('https://id.twitch.tv/oauth2/token', [
            'grant_type'    => 'client_credentials',
            'client_id'     => $clientId,
            'client_secret' => $clientSecret,
            'redirect_uri'  => home_url()
        ]);

        if (!empty($response->access_token)) {
            $token = $response->access_token;
            update_option('twitch_access_token', $token);
            update_option('twitch_access_token_expires_in', time() + $response->expires_in);
        }
    }

    return $token;
}

function twitch_api_request(array $args = [])
{
    if (empty($args)) {
        return [];
    }

    $clientId = $args['client_id'] ?? '';
    $token = $args['token'] ?? '';
    $curlUrl = $args['curl_url'] ?? '';
    $method = $args['method'] ?? 'GET';
    $data = $args['data'] ?? [];

    $curl = curl_init();

    $header = [
        'Content-Type: application/json',
        "Authorization: Bearer $token",
        "Client-Id: $clientId",
    ];

    $params = [
        CURLOPT_URL            => $curlUrl,
        CURLINFO_HEADER_OUT    => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER     => $header,
        CURLOPT_CUSTOMREQUEST  => $method
    ];

    if ($method !== 'GET' && !empty($data)) {
        $params[CURLOPT_POSTFIELDS] = json_encode($data);
    }

    curl_setopt_array($curl, $params);

    $response = curl_exec($curl);

    curl_close($curl);

    return json_decode($response);
}

function get_twitch_user_id(string $username = '', string $token = '', string $clientId = ''): int
{
    $twitchUsers = get_option('twitch_users', []);
    
    if ($username && !empty($twitchUsers[$username])) {
        return !empty($twitchUsers[$username]['id']) ? $twitchUsers[$username]['id'] : 0;
    }

    if (empty($token) || empty($clientId)) {
        return 0;
    }

    $broadcaster = twitch_api_request([
        'token'     => $token,
        'client_id' => $clientId,
        'curl_url'  => 'https://api.twitch.tv/helix/users?' . http_build_query([
            'login' => $username
        ])
    ]);

    if (!empty($broadcaster->data)) {
        $twitchUsers = array_merge([
            $username => [
                'id' => $broadcaster->data[0]->id
            ]
        ], $twitchUsers);

        update_option('twitch_users', $twitchUsers);

        return $broadcaster->data[0]->id;
    }

    return 0;
}