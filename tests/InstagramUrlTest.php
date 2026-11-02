<?php

namespace MainaSuperintelligence\InstagramFeed\Tests;

use MainaSuperintelligence\InstagramFeed\Support\InstagramUrl;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class InstagramUrlTest extends TestCase
{
    public static function postLinks(): array
    {
        return [
            ['https://www.instagram.com/p/Cabc123XYZ_/', 'p/Cabc123XYZ_'],
            ['https://www.instagram.com/reel/Cabc123-XYZ/?igsh=abc', 'reel/Cabc123-XYZ'],
            ['https://instagram.com/reels/Cabc123XYZ/', 'reel/Cabc123XYZ'],
            ['https://www.instagram.com/tv/Cabc123XYZ', 'tv/Cabc123XYZ'],
            ['https://www.instagram.com/yourshop/p/Cabc123XYZ/', 'p/Cabc123XYZ'],
            ['Cabc123XYZ', 'p/Cabc123XYZ'],
            ['https://www.instagram.com/yourshop/', null],
            ['https://example.com/p/Cabc123XYZ/', null],
            ['', null],
            [null, null],
        ];
    }

    #[DataProvider('postLinks')]
    public function test_it_extracts_the_post_code(?string $url, ?string $code): void
    {
        $this->assertSame($code, InstagramUrl::postCode($url));
    }

    public function test_it_builds_the_embed_url(): void
    {
        $this->assertSame('https://www.instagram.com/reel/Cabc123XYZ/embed/', InstagramUrl::embedUrl('reel/Cabc123XYZ'));
    }

    public static function handles(): array
    {
        return [
            ['yourshop', 'https://www.instagram.com/yourshop/'],
            ['@your.shop_1', 'https://www.instagram.com/your.shop_1/'],
            ['https://www.instagram.com/yourshop/', 'https://www.instagram.com/yourshop/'],
            ['', null],
            [null, null],
            ['your shop', null],
            ['"><script>', null],
        ];
    }

    #[DataProvider('handles')]
    public function test_it_builds_the_profile_url(?string $handle, ?string $url): void
    {
        $this->assertSame($url, InstagramUrl::profileUrl($handle));
    }
}
