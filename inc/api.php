<?php

require_once('lib/TikTok/vendor/autoload.php');
use TikTok\Authentication\Authentication;
use TikTok\User\User;
use TikTok\Request\Params;

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

    $subscribers = api_request([
        'curl_url'  => 'https://api.twitch.tv/helix/channels/followers?' . http_build_query([
            'broadcaster_id' => $broadcasterId
        ]),
        'headers'   => [
            'Content-Type: application/json',
            "Authorization: Bearer $token",
            "Client-Id: $clientId"
        ]
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

function get_twitch_user_id(string $username = '', string $token = '', string $clientId = ''): int
{
    $twitchUsers = get_option('twitch_users', []);
    
    if ($username && !empty($twitchUsers[$username])) {
        return !empty($twitchUsers[$username]['id']) ? $twitchUsers[$username]['id'] : 0;
    }

    if (empty($token) || empty($clientId)) {
        return 0;
    }

    $broadcaster = api_request([
        'curl_url'  => 'https://api.twitch.tv/helix/users?' . http_build_query([
            'login' => $username
        ]),
        'headers'   => [
            'Content-Type: application/json',
            "Authorization: Bearer $token",
            "Client-Id: $clientId"
        ]
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

function send_response_x_api(string $xName = '')
{
    $apiKey = 'KOgYtOBxeo6Z9Gwo9WQOJMb4I';
    $apiKeySecret = 'DqJi3Y4lefH6dfRkaMbZJ8l1wPsRgwASJnrdb2mTbXey7MtiK5';
    $bearerToken = 'AAAAAAAAAAAAAAAAAAAAAHLwuAEAAAAAjX7tgXSoANvb4Q%2Fy5kkeh%2BB0Y24%3DS597sNYUHsNzFGcwOaMGwg5oNNAo3Mogsy09PMSrtNcRHxlDJE';
    $accessToken = '1800165922830798848-Hp6gQyLST9TR0uquqUx9t0Dv3l7iqm';
    $accessTokenSecret = '6u8FQqHia90cqNBpA7TWGG4Lsb8KIV2n6OqbzC6afptpg';

    $xName = 'elonmusk';
    if (!$xName) {
        return;
    }

    $response = api_request([
        'curl_url'  => 'https://api.twitter.com/1.1/lists/list.json?' . http_build_query([
            'screen_name' => $xName
        ]),
        'headers'   => [
            'Content-Type: application/json',
            "Authorization: Bearer $bearerToken"
        ]
    ]);
}

function send_response_tiktok_api(string $username = '', string $token = '')
{
    $response = api_request([
        'curl_url'  => 'https://open.tiktokapis.com/v2/user/info/',
        'headers'   => [
            'Content-Type: application/x-www-form-urlencoded',
            "Authorization: Bearer $token"
        ]
    ]);
}

function tiktok_token()
{
    $response = api_request([
        'curl_url' => 'https://open.tiktokapis.com/v2/oauth/token?' . http_build_query([
            'client_key'    => 'awlczkamy5ho78ja',
            'client_secret' => '5ZpuVFYZNs1uKrJS9ciGY5sGwJDpCWy4',
            'grant_type'    => 'client_credentials'
        ]),
        'headers'  => [
            'Content-Type: application/x-www-form-urlencoded'
        ]
    ]);
}

function tiktok_auth()
{
    $clientKey = get_api_key('tiktok_client_key');
    $clientSecret = get_api_key('tiktok_client_secret');

    if (!$clientKey || !$clientSecret) {
        return '';
    }

    return new Authentication([
        'client_key'    => $clientKey,
        'client_secret' => $clientSecret
    ]);
}

function tiktok_token_request(): string
{
    $authentication = tiktok_auth();
    $redirectUri = home_url();

    $scopes = [
        'user.info.basic',
        'user.info.stats'
    ];

    return $authentication->getAuthenticationUrl($redirectUri, $scopes);
}

function tiktok_get_token(): string
{
    $authentication = tiktok_auth();
    $redirectUri = home_url();

    $tokenFromCode = $authentication->getAccessTokenFromCode($_GET['code'], $redirectUri);

    return $tokenFromCode['access_token'] ?? '';
}

function tiktok_refresh_token(string $token = ''): string
{
    if (!$token) {
        return '';
    }

    $authentication = tiktok_auth();

    $tokenRefresh = $authentication->getRefreshAccessToken($token);

    return $tokenRefresh['access_token'] ?? '';
}

function tiktok_get_user_info(string $token = '')
{
    if (!$token) {
        return '';
    }

    $config = [
        'access_token' => $token
    ];

    $user = new User($config);

    $params = Params::getFieldsParam([
        'follower_count'
    ]);

    return $user->getSelf($params);
}