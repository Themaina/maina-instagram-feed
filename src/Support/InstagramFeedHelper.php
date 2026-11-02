<?php

namespace Maina888\InstagramFeed\Support;

use Botble\Setting\Facades\Setting;
use Maina888\InstagramFeed\Models\InstagramPost;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Route;
use Throwable;

class InstagramFeedHelper
{
    public function getSettingKeyPrefix(): string
    {
        return 'instagram_feed';
    }

    public function getSetting(string $key, mixed $default = null): mixed
    {
        return setting("{$this->getSettingKeyPrefix()}_$key", $default);
    }

    public function saveSettings(array $settings): void
    {
        foreach ($settings as $settingKey => $settingValue) {
            Setting::set("{$this->getSettingKeyPrefix()}_$settingKey", $settingValue);
        }

        Setting::save();
    }

    public function settingKeys(): array
    {
        return [
            'enabled',
            'position',
            'draggable',
            'instagram_username',
            'shop_button_text',
            'shop_button_url',
            'show_on_mobile',
            'limit_posts',
            'auto_open',
            'auto_open_delay',
            'display_pages',
            'widget_size',
            'follow_button_text',
            'click_to_load',
            'mobile_bottom_offset',
        ];
    }

    public function positions(): array
    {
        return [
            'bottom-left' => trans('plugins/instagram-feed::instagram-feed.positions.bottom_left'),
            'bottom-right' => trans('plugins/instagram-feed::instagram-feed.positions.bottom_right'),
            'top-left' => trans('plugins/instagram-feed::instagram-feed.positions.top_left'),
            'top-right' => trans('plugins/instagram-feed::instagram-feed.positions.top_right'),
        ];
    }

    public function sizes(): array
    {
        return [
            'compact' => trans('plugins/instagram-feed::instagram-feed.sizes.compact'),
            'standard' => trans('plugins/instagram-feed::instagram-feed.sizes.standard'),
            'spacious' => trans('plugins/instagram-feed::instagram-feed.sizes.spacious'),
        ];
    }

    public function displayPages(): array
    {
        $pages = [
            'all' => trans('plugins/instagram-feed::instagram-feed.display_pages.all'),
            'public.index' => trans('plugins/instagram-feed::instagram-feed.display_pages.homepage'),
        ];

        // Shop pages only exist when the Ecommerce plugin is active.
        if (is_plugin_active('ecommerce')) {
            $pages += [
                'public.products' => trans('plugins/instagram-feed::instagram-feed.display_pages.products'),
                'product_detail' => trans('plugins/instagram-feed::instagram-feed.display_pages.product_detail'),
                'public.cart' => trans('plugins/instagram-feed::instagram-feed.display_pages.cart'),
                'public.checkout.information' => trans('plugins/instagram-feed::instagram-feed.display_pages.checkout'),
            ];
        }

        return $pages;
    }

    public function getDisplayPages(): array
    {
        $pages = $this->getSetting('display_pages', ['all']);

        if (is_string($pages)) {
            $pages = json_decode($pages, true) ?: [];
        }

        return is_array($pages) && $pages ? $pages : ['all'];
    }

    public function defaultShopButtonUrl(): string
    {
        try {
            if (Route::has('public.products')) {
                return route('public.products');
            }
        } catch (Throwable) {
            // fallback to homepage below
        }

        return url('/');
    }

    public function profileUrl(): ?string
    {
        return InstagramUrl::profileUrl($this->getSetting('instagram_username'));
    }

    public function getPosts(): Collection
    {
        $limit = (int) $this->getSetting('limit_posts', 6);

        return InstagramPost::query()
            ->wherePublished()
            ->orderBy('order')
            ->orderByDesc('id')
            ->limit($limit > 0 ? $limit : 6)
            ->get()
            ->filter(fn (InstagramPost $post) => (bool) $post->post_code)
            ->values();
    }
}
