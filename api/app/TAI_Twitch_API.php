<?php


class TAI_Twitch_API
{
    const TWITCH_API_USERS_URL = 'https://api.twitch.tv/helix/users/';
    const TWITCH_API_TOKEN_URL = 'https://id.twitch.tv/oauth2/token/';
    const TWITCH_API_FOLLOWERS_URL = 'https://api.twitch.tv/helix/channels/followers/';

    private static string $clientId = '';

    static function init()
    {
        self::$clientId = get_api_key('twitch_client_id');
    }

    static function updateSubscribers(string $channelName = '', int $userId = 0)
    {
        if (!self::$clientId || !$channelName) {
            return null;
        }

        $token = self::getToken();

        if (empty($token)) {
            return null;
        }

        $broadcasterId = self::getBroadcasterId($channelName, $token);
        
        if (empty($broadcasterId)) {
            return null;
        }

        return self::getSubscribers($broadcasterId, $token, $userId);
    }

    static function getToken()
    {
        if (!self::$clientId) {
            return '';
        }

        $token = get_option('twitch_access_token', '');
        $tokenExpirationTime = get_option('twitch_access_token_expires_in', '');
        $clientSecret = get_api_key('twitch_client_secret');

        if (!$clientSecret) {
            return $token;
        }

        if (!$token || !$tokenExpirationTime || $tokenExpirationTime < time()) {
            $response = http(self::TWITCH_API_TOKEN_URL, [
                'grant_type'    => 'client_credentials',
                'client_id'     => self::$clientId,
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

    private static function getBroadcasterId(string $username = '', string $token = '')
    {
        $twitchBroadcasters = get_option('twitch_users', []);

        if ($username && !empty($twitchBroadcasters[$username])) {
            return !empty($twitchBroadcasters[$username]['id']) ? $twitchBroadcasters[$username]['id'] : 0;
        }

        if (empty($token) || empty(self::$clientId)) {
            return 0;
        }

        $user = api_request([
            'curl_url'  => self::TWITCH_API_USERS_URL . '?' . http_build_query([
                'login' => $username
            ]),
            'headers'   => [
                'Content-Type: application/json',
                "Authorization: Bearer $token",
                'Client-Id: ' . self::$clientId
            ]
        ]);

        if (empty($user->data)) {
            return 0;
        }

        $twitchBroadcasters = array_merge([
            $username => [
                'id' => $user->data[0]->id
            ]
        ], $twitchBroadcasters);

        update_option('twitch_users', $twitchBroadcasters);

        return $user->data[0]->id ?? 0;
    }

    private static function getSubscribers($broadcasterId, $token, $userId): int
    {
        $subscribers = api_request([
            'curl_url'  => self::TWITCH_API_FOLLOWERS_URL . '?' . http_build_query([
                'broadcaster_id' => $broadcasterId
            ]),
            'headers'   => [
                'Content-Type: application/json',
                "Authorization: Bearer $token",
                'Client-Id: ' . self::$clientId
            ]
        ]);
        
        $total = $subscribers->total ?? 0;

        if ($userId) {
            update_field('twitch_subscribers', $total, $userId);   
        }
        
        return $total;
    }
}