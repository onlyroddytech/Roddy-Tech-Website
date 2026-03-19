<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// CMS — stores all editable website content (hero, about, contact, etc.)
// Admin edits these via dashboard. Blade reads from DB — no hardcoded text.

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cms_sections', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();   // e.g. 'hero_title', 'about_story', 'contact_email'
            $table->string('label');           // human-readable name shown in admin UI
            $table->longText('value')->nullable();
            $table->string('type')->default('text'); // text | textarea | image | html
            $table->string('group')->default('general'); // hero | about | contact | footer
            $table->timestamps();
            $table->index('group');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cms_sections');
    }
};
