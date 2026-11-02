<?php

namespace Maina888\InstagramFeed\Forms;

use Botble\Base\Forms\FieldOptions\MediaImageFieldOption;
use Botble\Base\Forms\FieldOptions\NumberFieldOption;
use Botble\Base\Forms\FieldOptions\StatusFieldOption;
use Botble\Base\Forms\FieldOptions\TextFieldOption;
use Botble\Base\Forms\Fields\MediaImageField;
use Botble\Base\Forms\Fields\NumberField;
use Botble\Base\Forms\Fields\SelectField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Base\Forms\FormAbstract;
use Maina888\InstagramFeed\Http\Requests\InstagramPostRequest;
use Maina888\InstagramFeed\Models\InstagramPost;

class InstagramPostForm extends FormAbstract
{
    public function setup(): void
    {
        $this
            ->model(InstagramPost::class)
            ->setValidatorClass(InstagramPostRequest::class)
            ->add(
                'title',
                TextField::class,
                TextFieldOption::make()
                    ->label(trans('plugins/instagram-feed::instagram-feed.title'))
                    ->helperText(trans('plugins/instagram-feed::instagram-feed.title_helper'))
            )
            ->add(
                'post_url',
                TextField::class,
                TextFieldOption::make()
                    ->label(trans('plugins/instagram-feed::instagram-feed.post_url'))
                    ->required()
                    ->placeholder('https://www.instagram.com/reel/Cxxxxxxxxxx/')
                    ->helperText(trans('plugins/instagram-feed::instagram-feed.post_url_helper'))
            )
            ->add(
                'product_url',
                TextField::class,
                TextFieldOption::make()
                    ->label(trans('plugins/instagram-feed::instagram-feed.product_url'))
                    ->helperText(trans('plugins/instagram-feed::instagram-feed.product_url_helper'))
            )
            ->add(
                'cover_image',
                MediaImageField::class,
                MediaImageFieldOption::make()
                    ->label(trans('plugins/instagram-feed::instagram-feed.cover_image'))
                    ->helperText(trans('plugins/instagram-feed::instagram-feed.cover_image_helper'))
            )
            ->add(
                'order',
                NumberField::class,
                NumberFieldOption::make()
                    ->label(trans('plugins/instagram-feed::instagram-feed.order'))
                    ->defaultValue(0)
                    ->helperText(trans('plugins/instagram-feed::instagram-feed.order_helper'))
            )
            ->add('status', SelectField::class, StatusFieldOption::make())
            ->setBreakFieldPoint('status');
    }
}
