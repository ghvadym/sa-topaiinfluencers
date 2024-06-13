<?php

require_once('lib/TikTok/vendor/autoload.php');
use TikTok\Authentication\Authentication;
use TikTok\User\User;
use TikTok\Request\Params;

function send_request_x_api(string $xName = '')
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

function facebook_auth_token()
{
    $appId = get_api_key('facebook_app_id');
    $appSecret = get_api_key('facebook_app_secret');

    $params = [
        'client_id'     => $appId,
        'client_secret' => $appSecret,
        'grant_type'    => 'client_credentials'
    ];

    $data = file_get_contents('https://graph.facebook.com/oauth/access_token?' . urldecode(http_build_query($params)));
    $data = json_decode($data, true);

    return $data['access_token'] ?? '';
}

function get_facebook_long_term_token(string $token = '')
{
    $token = get_option('facebook_access_token', '');
    $tokenExpirationTime = get_option('facebook_access_token_expires_in', '');

    if ($token && $tokenExpirationTime && $tokenExpirationTime > time()) {
        return $token;
    }

    $appId = get_api_key('facebook_app_id');
    $appSecret = get_api_key('facebook_app_secret');
    $accessToken = get_api_key('facebook_access_token');
//    $token = 'EABv2GZALb40QBO1gSZAGsvYZBZCOrwubOK8GJtkrqa4IPXi2sB2p7NJIrY3Xnu87jMWGWUZAEGtDlnK5vD02y1WjZBpcfrJcVRrCEOwJKgQ7ZBf48ZA74HZCiChWSNglx3F8ZAINZCHwJaRZBFZBPyWZB02CYCvRPNxx2lPee8DNOzv3MCkw4IeWbz3YxdQnKs0YusZCUN5DwzzZCaVoX0ZCpiIBajQZDZD';

    $params = [
//        'client_id'         => '7870414069687108',
//        'client_secret'     => '859d3add6a1f838e7bc3957ee42c7fc6',
//        'grant_type'        => 'fb_exchange_token',
        'client_id'         => $appId,
        'client_secret'     => $appSecret,
        'grant_type'        => 'fb_exchange_token',
        'fb_exchange_token' => $accessToken
    ];

    $data = file_get_contents('https://graph.facebook.com/v20.0/oauth/access_token?' . urldecode(http_build_query($params)));
    $data = json_decode($data, true);

    $token = $data['access_token'] ?? '';
    $expiresIn = $data['expires_in'] ?? '';

    if ($token && $expiresIn) {
        update_option('facebook_access_token', $token);
        update_option('facebook_access_token_expires_in', time() + $expiresIn);
    }

    return $token;
}

function instagram_subscribers()
{
    $userId = 1096;
    $instAccId = get_api_key('instagram_business_account_id');
    $accessToken = get_api_key('facebook_access_token');
    $username = 'nasa';
    //$instAccId = '17841453170571388';
    //$token = 'EABv2GZALb40QBO1gSZAGsvYZBZCOrwubOK8GJtkrqa4IPXi2sB2p7NJIrY3Xnu87jMWGWUZAEGtDlnK5vD02y1WjZBpcfrJcVRrCEOwJKgQ7ZBf48ZA74HZCiChWSNglx3F8ZAINZCHwJaRZBFZBPyWZB02CYCvRPNxx2lPee8DNOzv3MCkw4IeWbz3YxdQnKs0YusZCUN5DwzzZCaVoX0ZCpiIBajQZDZD';
    //$token = 'EABv2GZALb40QBOZCKf5Lt4dhHtFmzx5U8bMUigxjTbgnheFOfsAJJmZASwaJS8lZAFZBr2ZCdNgovYaosTkidhxubcosZAO9iaiS6rzkADobZCrogZC6Ill57FdH83I6ZAAfkZAMD9MoJIPx8VUMzCyNbeT9TYMweYOQnh9cf4ZCNZCAovbZAGl8CiGUDbXhOg';

    $data = file_get_contents(
        sprintf(
        'https://graph.facebook.com/v20.0/%s?fields=business_discovery.username(%s){followers_count}&access_token=%s',
            $instAccId,
            $username,
            $accessToken
        )
    );

    $data = json_decode($data, true);

    $businessDiscovery = $data['business_discovery'] ?? [];

    if (!empty($businessDiscovery)) {
        $subscribers = $businessDiscovery['followers_count'] ?? 0;

        if ($userId) {
            update_field('instagram_subscribers', $subscribers, $userId);
        }
    }

    return $subscribers ?? 0;
}