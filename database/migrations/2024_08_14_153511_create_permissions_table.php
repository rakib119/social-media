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
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('menu_id')->nullable();
            $table->integer('link_id')->nullable();
            $table->string('permission_string')->nullable();

            /* $table->integer('view')->default(0);
            $table->integer('save')->default(0);
            $table->integer('update')->default(0);
            $table->integer('delete')->default(0);
            $table->integer('details')->default(0);
            $table->integer('published')->default(0);
            $table->integer('status_active')->default(1); */
            $table->integer('is_deleted')->default(0);
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
        Schema::dropIfExists('permissions');
    }
};
