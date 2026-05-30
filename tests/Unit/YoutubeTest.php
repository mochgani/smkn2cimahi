<?php

namespace Tests\Unit;

use App\Support\Youtube;
use PHPUnit\Framework\TestCase;

class YoutubeTest extends TestCase
{
    public function test_null_input_kembalikan_null(): void
    {
        $this->assertNull(Youtube::embedUrl(null));
        $this->assertNull(Youtube::embedUrl(''));
    }

    public function test_standard_watch_url(): void
    {
        $this->assertSame(
            'https://www.youtube.com/embed/dQw4w9WgXcQ',
            Youtube::embedUrl('https://www.youtube.com/watch?v=dQw4w9WgXcQ')
        );
    }

    public function test_short_url_youtu_be(): void
    {
        $this->assertSame(
            'https://www.youtube.com/embed/dQw4w9WgXcQ',
            Youtube::embedUrl('https://youtu.be/dQw4w9WgXcQ')
        );
    }

    public function test_embed_url(): void
    {
        $this->assertSame(
            'https://www.youtube.com/embed/dQw4w9WgXcQ',
            Youtube::embedUrl('https://www.youtube.com/embed/dQw4w9WgXcQ')
        );
    }

    public function test_shorts_url(): void
    {
        $this->assertSame(
            'https://www.youtube.com/embed/abc12345678',
            Youtube::embedUrl('https://www.youtube.com/shorts/abc12345678')
        );
    }

    public function test_url_dengan_query_params_tambahan(): void
    {
        $this->assertSame(
            'https://www.youtube.com/embed/dQw4w9WgXcQ',
            Youtube::embedUrl('https://www.youtube.com/watch?v=dQw4w9WgXcQ&t=30s&list=PLxxxxx')
        );
    }

    public function test_url_tidak_valid_kembalikan_null(): void
    {
        $this->assertNull(Youtube::embedUrl('https://google.com'));
        $this->assertNull(Youtube::embedUrl('not-a-url'));
        $this->assertNull(Youtube::embedUrl('https://vimeo.com/123456'));
    }

    public function test_video_id_terlalu_pendek_kembalikan_null(): void
    {
        $this->assertNull(Youtube::embedUrl('https://youtu.be/short'));
    }
}
