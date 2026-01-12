<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('modules', function (Blueprint $table) {
            $table->string('content_type')->nullable()->after('content'); // e.g. 'video'|'document'|'html'
            $table->string('content_url')->nullable()->after('content_type');
            $table->string('attachment_mime')->nullable()->after('content_url');
        });
    }

    public function down(): void
    {
        Schema::table('modules', function (Blueprint $table) {
            $table->dropColumn(['content_type', 'content_url', 'attachment_mime']);
        });
    }
};
