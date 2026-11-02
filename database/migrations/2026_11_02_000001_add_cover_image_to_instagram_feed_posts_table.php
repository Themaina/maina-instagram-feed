<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('instagram_feed_posts') && ! Schema::hasColumn('instagram_feed_posts', 'cover_image')) {
            Schema::table('instagram_feed_posts', function (Blueprint $table): void {
                $table->string('cover_image', 255)->nullable()->after('product_url');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('instagram_feed_posts', 'cover_image')) {
            Schema::table('instagram_feed_posts', function (Blueprint $table): void {
                $table->dropColumn('cover_image');
            });
        }
    }
};
