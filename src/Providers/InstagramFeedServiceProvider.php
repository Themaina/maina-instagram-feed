<?php

namespace MainaSuperintelligence\InstagramFeed\Providers;

use Botble\Base\Facades\DashboardMenu;
use Botble\Base\Facades\PanelSectionManager;
use Botble\Base\PanelSections\PanelSectionItem;
use Botble\Base\Supports\ServiceProvider;
use Botble\Base\Traits\LoadAndPublishDataTrait;
use Botble\Setting\PanelSections\SettingOthersPanelSection;
use Illuminate\Foundation\Application;

class InstagramFeedServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function boot(): void
    {
        $this
            ->setNamespace('plugins/instagram-feed')
            ->loadAndPublishConfigurations(['permissions'])
            ->loadAndPublishTranslations()
            ->loadAndPublishViews()
            ->loadMigrations()
            ->publishAssets()
            ->loadRoutes();

        $this->app->booted(fn (Application $app) => $app->register(HookServiceProvider::class));

        DashboardMenu::beforeRetrieving(function (): void {
            DashboardMenu::make()
                ->registerItem([
                    'id' => 'cms-plugins-instagram-feed',
                    'priority' => 6,
                    'parent_id' => null,
                    'name' => 'plugins/instagram-feed::instagram-feed.name',
                    'icon' => 'ti ti-brand-instagram',
                    'url' => route('instagram-feed.index'),
                    'permissions' => ['instagram-feed.index'],
                ]);
        });

        PanelSectionManager::beforeRendering(function (): void {
            PanelSectionManager::default()
                ->registerItem(
                    SettingOthersPanelSection::class,
                    fn () => PanelSectionItem::make('instagram-feed-settings')
                        ->setTitle(trans('plugins/instagram-feed::instagram-feed.settings.name'))
                        ->withIcon('ti ti-brand-instagram')
                        ->withDescription(trans('plugins/instagram-feed::instagram-feed.settings.description'))
                        ->withPriority(200)
                        ->withRoute('instagram-feed.settings')
                );
        });
    }
}
