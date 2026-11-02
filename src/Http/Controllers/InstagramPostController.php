<?php

namespace MainaSuperintelligence\InstagramFeed\Http\Controllers;

use Botble\Base\Http\Actions\DeleteResourceAction;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Base\Supports\Breadcrumb;
use MainaSuperintelligence\InstagramFeed\Forms\InstagramPostForm;
use MainaSuperintelligence\InstagramFeed\Http\Requests\InstagramPostRequest;
use MainaSuperintelligence\InstagramFeed\Models\InstagramPost;
use MainaSuperintelligence\InstagramFeed\Tables\InstagramPostTable;

class InstagramPostController extends BaseController
{
    protected function breadcrumb(): Breadcrumb
    {
        return parent::breadcrumb()
            ->add(trans('plugins/instagram-feed::instagram-feed.name'), route('instagram-feed.index'));
    }

    public function index(InstagramPostTable $table)
    {
        $this->pageTitle(trans('plugins/instagram-feed::instagram-feed.name'));

        return $table->renderTable();
    }

    public function create()
    {
        $this->pageTitle(trans('plugins/instagram-feed::instagram-feed.create'));

        return InstagramPostForm::create()->renderForm();
    }

    public function store(InstagramPostRequest $request)
    {
        $form = InstagramPostForm::create()->setRequest($request);
        $form->save();

        return $this
            ->httpResponse()
            ->setPreviousRoute('instagram-feed.index')
            ->setNextRoute('instagram-feed.edit', $form->getModel()->getKey())
            ->withCreatedSuccessMessage();
    }

    public function edit(InstagramPost $post)
    {
        $this->pageTitle(trans('core/base::forms.edit_item', ['name' => $post->title ?: $post->post_url]));

        return InstagramPostForm::createFromModel($post)->renderForm();
    }

    public function update(InstagramPost $post, InstagramPostRequest $request)
    {
        InstagramPostForm::createFromModel($post)
            ->setRequest($request)
            ->save();

        return $this
            ->httpResponse()
            ->setPreviousRoute('instagram-feed.index')
            ->withUpdatedSuccessMessage();
    }

    public function destroy(InstagramPost $post)
    {
        return DeleteResourceAction::make($post);
    }
}
