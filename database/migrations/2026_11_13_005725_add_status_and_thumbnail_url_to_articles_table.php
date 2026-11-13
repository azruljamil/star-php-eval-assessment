<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->string('status')->default('draft');
            $table->string('thumbnail_url')->nullable();
            $table->index(['status', 'published_at']);
        });
    }

    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropIndex(['status', 'published_at']);
            $table->dropColumn(['status', 'thumbnail_url']);
        });
    }
};
