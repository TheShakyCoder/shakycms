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
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('author');            // person giving the testimonial
            $table->string('role')->nullable();  // e.g. "Regular customer"
            $table->string('headline');          // short headline, e.g. "Great!"
            $table->text('quote');               // the testimonial text
            $table->unsignedTinyInteger('rating')->nullable(); // 1–5, optional
            $table->boolean('homepage')->default(false);  // show on the homepage
            $table->boolean('featured')->default(false);  // highlight as featured
            $table->unsignedInteger('order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('testimonials');
    }
};
