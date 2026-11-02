<?php

use Botble\Base\Facades\AdminHelper;
use MainaSuperintelligence\InstagramFeed\Http\Controllers\Settings\InstagramFeedSettingController;
use MainaSuperintelligence\InstagramFeed\Http\Controllers\InstagramPostController;
use Illuminate\Support\Facades\Route;

AdminHelper::registerRoutes(function (): void {
    Route::group(['prefix' => 'instagram-feed', 'as' => 'instagram-feed.'], function (): void {
        Route::resource('', InstagramPostController::class)->parameters(['' => 'post']);
    });

    Route::group(['prefix' => 'settings/instagram-feed', 'as' => 'instagram-feed.settings', 'permission' => 'instagram-feed.settings'], function (): void {
        Route::get('/', [InstagramFeedSettingController::class, 'edit']);
        Route::put('/', [InstagramFeedSettingController::class, 'update'])->name('.edit');
    });
});
