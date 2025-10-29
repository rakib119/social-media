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
        Schema::create('social_photos', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('original_photo');
            $table->string('thumbnail');
            $table->integer('status_active')->default(1);
            $table->integer('is_deleted')->default(0);
            $table->integer('photo_gallery')->comment('1->profile,2->coverphoto');
            $table->integer('is_current')->default(1);
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('social_photos');
    }
};
