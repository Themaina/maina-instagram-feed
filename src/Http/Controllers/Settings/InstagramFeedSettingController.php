<?php

namespace MainaSuperintelligence\InstagramFeed\Http\Controllers\Settings;

use Botble\Setting\Http\Controllers\SettingController;
use MainaSuperintelligence\InstagramFeed\Forms\Settings\InstagramFeedSettingForm;
use MainaSuperintelligence\InstagramFeed\Http\Requests\Settings\InstagramFeedSettingRequest;
use MainaSuperintelligence\InstagramFeed\Support\InstagramFeedHelper;
use Illuminate\Support\Arr;

class InstagramFeedSettingController extends SettingController
{
    public function edit()
    {
        $this->pageTitle(trans('plugins/instagram-feed::instagram-feed.settings.name'));

        return InstagramFeedSettingForm::create()->renderForm();
    }

    public function update(InstagramFeedSettingRequest $request, InstagramFeedHelper $helper)
    {
        $helper->saveSettings(Arr::only($request->validated(), $helper->settingKeys()));

        return $this
            ->httpResponse()
            ->withUpdatedSuccessMessage();
    }
}
