<?php

require_once('lib/TikTok/vendor/autoload.php');
use TikTok\Authentication\Authentication;
use TikTok\User\User;
use TikTok\Request\Params;

function send_request_x_api(string $xName = '')
{
    $appId = '1800167080425066496';
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

function tiktok_get_access_token()
{
    $clientKey = get_api_key('tiktok_client_key');
    $clientSecret = get_api_key('tiktok_client_secret');

    if (!$clientKey || !$clientSecret) {
        return '';
    }

    return api_request([
        'method'   => 'POST',
        'curl_url' => 'https://open.tiktokapis.com/v2/oauth/token/',
        'headers'  => [
            'Content-Type: application/x-www-form-urlencoded'
        ],
        'body'     => [
            'client_key'    => $clientKey,
            'client_secret' => $clientSecret,
            'grant_type'    => 'client_credentials'
        ]
    ]);
}

function send_request_tiktok_api(string $username = '', string $token = '')
{
    $response = api_request([
        'curl_url'  => 'https://open.tiktokapis.com/v2/user/info/',
        'headers'   => [
            'Content-Type: application/x-www-form-urlencoded',
            "Authorization: Bearer $token"
        ]
    ]);
}

function tiktok_get_user_info_by_name(string $token = '', string $username = ''): string
{
    if (!$token || !$username) {
        return '';
    }

    $response = api_request([
        'method'   => 'POST',
        'curl_url' => 'https://open.tiktokapis.com/v2/research/user/info/?' . http_build_query([
            'fields' => 'follower_count'
        ]),
        'headers'  => [
            'Content-Type: text/plain',
            "Authorization: Bearer $token",
        ],
        'body'     => [
            'username' => $username
        ]
    ]);

    if (empty($response->data)) {
        return '';
    }

    return $response->data->follower_count ?? '';
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

function tiktok_token_auth_url(): string
{
    $authentication = tiktok_auth();
    $redirectUri = home_url();

    $scopes = [
        'user.info.basic',
        'user.info.stats'
    ];

    return $authentication->getAuthenticationUrl($redirectUri, $scopes);
}

function tiktok_auth_token(): string
{
    if (empty($_GET['code'])) {
        return '';
    }

    $authentication = tiktok_auth();
    $redirectUri = home_url();

    $tokenFromCode = $authentication->getAccessTokenFromCode($_GET['code'], $redirectUri);

    return $tokenFromCode['access_token'] ?? '';
}

function tiktok_client_access_token(): string
{
    $authentication = tiktok_auth();
    return $authentication->getClientAccessToken();
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