<?php


class TAI_Instagram_API
{
    const INSTAGRAM_API_TOKEN_URL = 'https://graph.facebook.com/v20.0/oauth/access_token/';
    const INSTAGRAM_API_FOLLOWERS_URL = 'https://graph.facebook.com/v20.0/%s?fields=business_discovery.username(%s){followers_count}&access_token=%s';

    static function updateSubscribers(string $username = '', int $userId = 0)
    {
        if (!$username) {
            return null;
        }

        $token = self::getToken();

        if (!$token) {
            return null;
        }

        return self::getSubscribers($token, $username, $userId);
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
        $accessToken = get_api_key('facebook_access_token');

        if (!$appId || !$appSecret || !$accessToken) {
            return null;
        }

        $params = [
            'client_id'         => $appId,
            'client_secret'     => $appSecret,
            'grant_type'        => 'fb_exchange_token',
            'fb_exchange_token' => $accessToken
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

    static function getSubscribers($token, $username, $userId)
    {
        if (!$username) {
            return null;
        }

        $accountId = get_api_key('instagram_business_account_id');

        if (!$accountId) {
            return null;
        }

        $data = file_get_contents(
            sprintf(
                self::INSTAGRAM_API_FOLLOWERS_URL,
                $accountId,
                $username,
                $token
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