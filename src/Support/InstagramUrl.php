<?php

namespace MainaSuperintelligence\InstagramFeed\Support;

/**
 * Parses Instagram links without any framework dependency, so it can be unit tested on its own.
 */
class InstagramUrl
{
    /**
     * "p/<code>", "reel/<code>" or "tv/<code>" from an Instagram post or reel link (or a bare shortcode), or null.
     */
    public static function postCode(?string $url): ?string
    {
        $url = trim((string) $url);

        if ($url === '') {
            return null;
        }

        if (preg_match('#^https?://([a-z0-9-]+\.)*instagram\.com/(?:[A-Za-z0-9._]+/)?(p|reels?|tv)/([A-Za-z0-9_-]{5,})#i', $url, $matches)) {
            $type = strtolower($matches[2]) === 'reels' ? 'reel' : strtolower($matches[2]);

            return $type . '/' . $matches[3];
        }

        if (preg_match('/^([A-Za-z0-9_-]{5,})$/', $url, $matches)) {
            return 'p/' . $matches[1];
        }

        return null;
    }

    public static function embedUrl(string $postCode): string
    {
        return 'https://www.instagram.com/' . $postCode . '/embed/';
    }

    /**
     * Profile link for a handle. Accepts "shop", "@shop" or a full profile URL; anything else gives null.
     */
    public static function profileUrl(?string $username): ?string
    {
        $username = trim((string) $username);

        if (preg_match('#instagram\.com/([A-Za-z0-9._]+)#i', $username, $matches)) {
            $username = $matches[1];
        }

        $username = ltrim($username, '@');

        return preg_match('/^[A-Za-z0-9._]{1,30}$/', $username) ? 'https://www.instagram.com/' . $username . '/' : null;
    }
}
