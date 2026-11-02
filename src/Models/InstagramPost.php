<?php

namespace Maina888\InstagramFeed\Models;

use Botble\Base\Casts\SafeContent;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Models\BaseModel;
use Maina888\InstagramFeed\Support\InstagramUrl;

class InstagramPost extends BaseModel
{
    protected $table = 'instagram_feed_posts';

    protected $fillable = [
        'title',
        'post_url',
        'post_code',
        'product_url',
        'cover_image',
        'order',
        'status',
    ];

    protected $casts = [
        'status' => BaseStatusEnum::class,
        'title' => SafeContent::class,
    ];

    protected static function booted(): void
    {
        static::saving(function (self $post): void {
            $post->post_code = static::extractPostCode($post->post_url);
            $post->order = (int) $post->order;
        });
    }

    public static function extractPostCode(?string $url): ?string
    {
        return InstagramUrl::postCode($url);
    }

    public function embedUrl(): ?string
    {
        return $this->post_code ? InstagramUrl::embedUrl($this->post_code) : null;
    }
}
