<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('lessons', function (Blueprint $table) {
            $table->dropColumn(['type', 'content_url', 'attachment_file', 'embed_link']);
        });

        Schema::table('lessons', function (Blueprint $table) {
            $table->json('links')->nullable()->after('body');
            $table->json('attachments')->nullable()->after('links');
        });
    }

    public function down(): void
    {
        Schema::table('lessons', function (Blueprint $table) {
            $table->dropColumn(['links', 'attachments']);
        });

        Schema::table('lessons', function (Blueprint $table) {
            $table->string('type')->default('video')->after('title');
            $table->string('content_url')->nullable();
            $table->string('attachment_file')->nullable();
            $table->string('embed_link')->nullable();
        });
    }
};
