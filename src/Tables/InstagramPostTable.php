<?php

namespace MainaSuperintelligence\InstagramFeed\Tables;

use Botble\Table\Abstracts\TableAbstract;
use Botble\Table\Actions\DeleteAction;
use Botble\Table\Actions\EditAction;
use Botble\Table\BulkActions\DeleteBulkAction;
use Botble\Table\BulkChanges\CreatedAtBulkChange;
use Botble\Table\BulkChanges\StatusBulkChange;
use Botble\Table\Columns\Column;
use Botble\Table\Columns\CreatedAtColumn;
use Botble\Table\Columns\FormattedColumn;
use Botble\Table\Columns\IdColumn;
use Botble\Table\Columns\ImageColumn;
use Botble\Table\Columns\NameColumn;
use Botble\Table\Columns\StatusColumn;
use Botble\Table\HeaderActions\CreateHeaderAction;
use MainaSuperintelligence\InstagramFeed\Models\InstagramPost;
use Illuminate\Database\Eloquent\Builder;

class InstagramPostTable extends TableAbstract
{
    public function setup(): void
    {
        $this
            ->model(InstagramPost::class)
            ->addColumns([
                IdColumn::make(),
                ImageColumn::make('cover_image')
                    ->title(trans('plugins/instagram-feed::instagram-feed.cover_image')),
                NameColumn::make('title')
                    ->title(trans('plugins/instagram-feed::instagram-feed.title'))
                    ->route('instagram-feed.edit'),
                FormattedColumn::make('post_url')
                    ->title(trans('plugins/instagram-feed::instagram-feed.post_url'))
                    ->limit(60),
                Column::make('order')
                    ->title(trans('plugins/instagram-feed::instagram-feed.order'))
                    ->width(80),
                StatusColumn::make(),
                CreatedAtColumn::make(),
            ])
            ->addHeaderAction(CreateHeaderAction::make()->route('instagram-feed.create'))
            ->addActions([
                EditAction::make()->route('instagram-feed.edit'),
                DeleteAction::make()->route('instagram-feed.destroy'),
            ])
            ->addBulkAction(DeleteBulkAction::make()->permission('instagram-feed.destroy'))
            ->addBulkChanges([
                StatusBulkChange::make(),
                CreatedAtBulkChange::make(),
            ])
            ->queryUsing(function (Builder $query) {
                return $query
                    ->select([
                        'id',
                        'title',
                        'post_url',
                        'cover_image',
                        'status',
                        'created_at',
                        'order',
                    ])
                    ->orderBy('order')
                    ->orderByDesc('id');
            });
    }
}
