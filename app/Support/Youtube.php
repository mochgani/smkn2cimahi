<?php

namespace App\Support;

class Youtube
{
    /**
     * Convert YouTube URL ke embed URL.
     * Support:
     * - https://www.youtube.com/watch?v=ID
     * - https://youtu.be/ID
     * - https://www.youtube.com/embed/ID
     * - https://www.youtube.com/shorts/ID
     */
    public static function embedUrl(?string $url): ?string
    {
        if ($url === null || $url === '') {
            return null;
        }

        if (preg_match(
            '~(?:youtu\.be/|youtube\.com/(?:watch\?v=|embed/|shorts/))([A-Za-z0-9_-]{11})~',
            $url,
            $matches
        )) {
            return 'https://www.youtube.com/embed/'.$matches[1];
        }

        return null;
    }
}
