<?php

namespace MainaSuperintelligence\InstagramFeed\Forms\Settings;

use Botble\Base\Forms\FieldOptions\CheckboxFieldOption;
use Botble\Base\Forms\FieldOptions\NumberFieldOption;
use Botble\Base\Forms\FieldOptions\SelectFieldOption;
use Botble\Base\Forms\FieldOptions\TextFieldOption;
use Botble\Base\Forms\Fields\HtmlField;
use Botble\Base\Forms\Fields\MultiCheckListField;
use Botble\Base\Forms\Fields\NumberField;
use Botble\Base\Forms\Fields\OnOffCheckboxField;
use Botble\Base\Forms\Fields\SelectField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Setting\Forms\SettingForm;
use MainaSuperintelligence\InstagramFeed\Http\Requests\Settings\InstagramFeedSettingRequest;
use MainaSuperintelligence\InstagramFeed\Support\InstagramFeedHelper;

class InstagramFeedSettingForm extends SettingForm
{
    public function setup(): void
    {
        parent::setup();

        $helper = app(InstagramFeedHelper::class);

        $this
            ->setSectionTitle(trans('plugins/instagram-feed::instagram-feed.settings.name'))
            ->setSectionDescription(trans('plugins/instagram-feed::instagram-feed.settings.description'))
            ->setValidatorClass(InstagramFeedSettingRequest::class)
            ->add(
                'enabled',
                OnOffCheckboxField::class,
                CheckboxFieldOption::make()
                    ->label(trans('plugins/instagram-feed::instagram-feed.enable'))
                    ->value($helper->getSetting('enabled', true))
                    ->helperText(trans('plugins/instagram-feed::instagram-feed.enable_helper'))
            )
            ->add(
                'instagram_username',
                TextField::class,
                TextFieldOption::make()
                    ->label(trans('plugins/instagram-feed::instagram-feed.instagram_username'))
                    ->placeholder('yourshop')
                    ->value($helper->getSetting('instagram_username'))
                    ->helperText(trans('plugins/instagram-feed::instagram-feed.instagram_username_helper'))
            )
            ->add(
                'position',
                SelectField::class,
                SelectFieldOption::make()
                    ->label(trans('plugins/instagram-feed::instagram-feed.position'))
                    ->choices($helper->positions())
                    ->selected($helper->getSetting('position', 'bottom-right'))
                    ->helperText(trans('plugins/instagram-feed::instagram-feed.position_helper'))
            )
            ->add(
                'draggable',
                OnOffCheckboxField::class,
                CheckboxFieldOption::make()
                    ->label(trans('plugins/instagram-feed::instagram-feed.draggable'))
                    ->value($helper->getSetting('draggable', true))
                    ->helperText(trans('plugins/instagram-feed::instagram-feed.draggable_helper'))
            )
            ->add(
                'widget_size',
                SelectField::class,
                SelectFieldOption::make()
                    ->label(trans('plugins/instagram-feed::instagram-feed.widget_size'))
                    ->choices($helper->sizes())
                    ->selected($helper->getSetting('widget_size', 'compact'))
                    ->helperText(trans('plugins/instagram-feed::instagram-feed.widget_size_helper'))
            )
            ->add(
                'follow_button_text',
                TextField::class,
                TextFieldOption::make()
                    ->label(trans('plugins/instagram-feed::instagram-feed.follow_button_text_label'))
                    ->value($helper->getSetting('follow_button_text'))
                    ->helperText(trans('plugins/instagram-feed::instagram-feed.follow_button_text_helper'))
            )
            ->add(
                'shop_button_text',
                TextField::class,
                TextFieldOption::make()
                    ->label(trans('plugins/instagram-feed::instagram-feed.shop_button_text'))
                    ->value($helper->getSetting('shop_button_text', trans('plugins/instagram-feed::instagram-feed.shop_button_text_default')))
            )
            ->add(
                'shop_button_url',
                TextField::class,
                TextFieldOption::make()
                    ->label(trans('plugins/instagram-feed::instagram-feed.shop_button_url'))
                    ->value($helper->getSetting('shop_button_url', $helper->defaultShopButtonUrl()))
                    ->helperText(trans('plugins/instagram-feed::instagram-feed.shop_button_url_helper'))
            )
            ->add(
                'display_pages[]',
                MultiCheckListField::class,
                [
                    'label' => trans('plugins/instagram-feed::instagram-feed.display_pages_label'),
                    'choices' => $helper->displayPages(),
                    'value' => old('display_pages', $helper->getDisplayPages()),
                    'inline' => true,
                    'help_block' => [
                        'text' => trans('plugins/instagram-feed::instagram-feed.display_pages_helper'),
                    ],
                ]
            )
            ->add(
                'limit_posts',
                NumberField::class,
                NumberFieldOption::make()
                    ->label(trans('plugins/instagram-feed::instagram-feed.limit_posts'))
                    ->value($helper->getSetting('limit_posts', 6))
                    ->helperText(trans('plugins/instagram-feed::instagram-feed.limit_posts_helper'))
            )
            ->add(
                'show_on_mobile',
                OnOffCheckboxField::class,
                CheckboxFieldOption::make()
                    ->label(trans('plugins/instagram-feed::instagram-feed.show_on_mobile'))
                    ->value($helper->getSetting('show_on_mobile', true))
                    ->helperText(trans('plugins/instagram-feed::instagram-feed.show_on_mobile_helper'))
            )
            ->add(
                'mobile_bottom_offset',
                NumberField::class,
                NumberFieldOption::make()
                    ->label(trans('plugins/instagram-feed::instagram-feed.mobile_bottom_offset'))
                    ->value($helper->getSetting('mobile_bottom_offset', 20))
                    ->helperText(trans('plugins/instagram-feed::instagram-feed.mobile_bottom_offset_helper'))
            )
            ->add(
                'click_to_load',
                OnOffCheckboxField::class,
                CheckboxFieldOption::make()
                    ->label(trans('plugins/instagram-feed::instagram-feed.click_to_load'))
                    ->value($helper->getSetting('click_to_load', false))
                    ->helperText(trans('plugins/instagram-feed::instagram-feed.click_to_load_helper'))
            )
            ->add(
                'auto_open',
                OnOffCheckboxField::class,
                CheckboxFieldOption::make()
                    ->label(trans('plugins/instagram-feed::instagram-feed.auto_open'))
                    ->value($helper->getSetting('auto_open', false))
                    ->helperText(trans('plugins/instagram-feed::instagram-feed.auto_open_helper'))
                    ->attributes([
                        'data-bb-toggle' => 'collapse',
                        'data-bb-target' => '#instagram-feed-auto-open-delay',
                    ])
            )
            ->add(
                'openAutoOpenWrapper',
                HtmlField::class,
                [
                    'html' => sprintf(
                        '<div id="instagram-feed-auto-open-delay" style="display: %s">',
                        $helper->getSetting('auto_open', false) ? 'block' : 'none'
                    ),
                ]
            )
            ->add(
                'auto_open_delay',
                NumberField::class,
                NumberFieldOption::make()
                    ->label(trans('plugins/instagram-feed::instagram-feed.auto_open_delay'))
                    ->value($helper->getSetting('auto_open_delay', 5))
                    ->helperText(trans('plugins/instagram-feed::instagram-feed.auto_open_delay_helper'))
            )
            ->add(
                'closeAutoOpenWrapper',
                HtmlField::class,
                [
                    'html' => '</div>',
                ]
            );
    }
}
