<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        if (! Schema::hasTable('instagram_feed_posts')) {
            Schema::create('instagram_feed_posts', function (Blueprint $table): void {
                $table->id();
                $table->string('title', 250)->nullable();
                $table->string('post_url', 400);
                $table->string('post_code', 60)->nullable();
                $table->string('product_url', 400)->nullable();
                $table->integer('order')->default(0);
                $table->string('status', 60)->default('published');
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('instagram_feed_posts');
    }
};
