<?php

namespace Maina888\InstagramFeed;

use Botble\PluginManagement\Abstracts\PluginOperationAbstract;
use Botble\Setting\Facades\Setting;
use Illuminate\Support\Facades\Schema;

class Plugin extends PluginOperationAbstract
{
    public static function remove(): void
    {
        Schema::dropIfExists('instagram_feed_posts');

        Setting::newQuery()
            ->where('key', 'LIKE', 'instagram_feed_%')
            ->delete();
    }
}
