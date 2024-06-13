<?php


class TAI_Instagram_API
{
    const INSTAGRAM_API_TOKEN_URL = 'https://graph.facebook.com/v20.0/oauth/access_token/';
    const INSTAGRAM_API_FOLLOWERS_URL = 'https://graph.facebook.com/v20.0/%s?fields=business_discovery.username(%s){followers_count}&access_token=%s';

    private static string $accountId = '';
    private static string $accessToken = '';

    static function init()
    {
        self::$accountId = get_api_key('instagram_business_account_id');
        self::$accessToken = get_api_key('facebook_access_token');
    }

    static function updateSubscribers(string $username = '', int $userId = 0)
    {
        if (!$username || !self::$accessToken) {
            return null;
        }

        $token = self::getToken();

        if (!$token) {
            return null;
        }

        return self::getSubscribers($username, $userId);
    }

    static function getToken()
    {
        $token = get_option('facebook_access_token', '');
        $tokenExpirationTime = get_option('facebook_access_token_expires_in', '');

        if ($token && $tokenExpirationTime && $tokenExpirationTime > time()) {
            return $token;
        }

        $appId = get_api_key('facebook_app_id');
        $appSecret = get_api_key('facebook_app_secret');

        if (!$appId || !$appSecret) {
            return null;
        }

        $params = [
            'client_id'         => $appId,
            'client_secret'     => $appSecret,
            'grant_type'        => 'fb_exchange_token',
            'fb_exchange_token' => self::$accessToken
        ];

        $data = file_get_contents(self::INSTAGRAM_API_TOKEN_URL . '?' . urldecode(http_build_query($params)));

        if (empty($data)) {
            return null;
        }

        $data = json_decode($data, true);

        $token = $data['access_token'] ?? '';
        $expiresIn = $data['expires_in'] ?? '';

        if ($token && $expiresIn) {
            update_option('facebook_access_token', $token);
            update_option('facebook_access_token_expires_in', time() + $expiresIn);
        }

        return $token;
    }

    static function getSubscribers($username, $userId)
    {
        if (!$username) {
            return null;
        }

        $data = file_get_contents(
            sprintf(
                self::INSTAGRAM_API_FOLLOWERS_URL,
                self::$accountId,
                $username,
                self::$accessToken
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
}