<?php


class TAI_Google_API
{
    const GOOGLE_API_CHANNEL_URL = 'https://www.googleapis.com/youtube/v3/channels/';
    const GOOGLE_API_SEARCH_URL = 'https://youtube.googleapis.com/youtube/v3/search/';

    private static string $apiKey = '';

    static function init()
    {
        self::$apiKey = get_api_key('youtube_api');
    }

    static function updateSubscribers(string $channelName = '', int $userId = 0)
    {
        if (!self::$apiKey || !$channelName) {
            return null;
        }

        $channelId = TAI_Google_API::getChannelIdByName($channelName);

        if (!$channelId) {
            return null;
        }

        $getChannelDataUrl = self::generateChannelRequestLink($channelId);

        if (!$getChannelDataUrl) {
            return null;
        }

        $response = file_get_contents($getChannelDataUrl);
        $responseArray = json_decode($response, true);

        return self::getSubscribers($responseArray, $userId);
    }

    static function getChannelIdByName($channelName)
    {
        $responseUrl = self::generateSearchRequestLink($channelName);

        if (!$responseUrl) {
            return null;
        }

        $response = file_get_contents($responseUrl);
        $responseArray = json_decode($response, true);

        return self::getChannelId($responseArray);
    }

    private static function generateChannelRequestLink($channelId): string
    {
        return self::GOOGLE_API_CHANNEL_URL . '?' . http_build_query([
            'part' => 'statistics',
            'id'   => $channelId,
            'key'  => self::$apiKey
        ]);
    }

    private static function generateSearchRequestLink($channelName): string
    {
        return self::GOOGLE_API_SEARCH_URL . '?' . http_build_query([
            'part' => 'snippet',
            'q'    => $channelName,
            'type' => 'channel',
            'key'  => self::$apiKey
        ]);
    }

    private static function getSubscribers($response, $userId)
    {
        if (empty($response['items'])) {
            return null;
        }

        $statistics = $response['items'][0]['statistics'] ?? [];

        if (empty($statistics)) {
            return null;
        }

        $total = $statistics['subscriberCount'] ?? 0;

        if ($userId) {
            update_field('youtube_subscribers', $total, $userId);
        }

        return $total;
    }

    private static function getChannelId($response)
    {
        if (empty($response['items'])) {
            return null;
        }

        $channelIds = $response['items'][0]['id'] ?? [];

        if (empty($channelIds)) {
            return null;
        }

        return $channelIds['channelId'] ?? 0;
    }
}