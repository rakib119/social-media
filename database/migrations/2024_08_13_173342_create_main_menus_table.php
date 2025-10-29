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
        Schema::create('main_menus', function (Blueprint $table) {
            $table->id();
            $table->string('menu_name',150);
            $table->string('short_name')->nullable();
            $table->integer('menu_route')->nullable();
            $table->string('route_name')->nullable();
            $table->integer('root_menu_id')->nullable();
            $table->integer('sequence')->nullable();
            $table->integer('status_active')->default(0);
            $table->integer('is_deleted')->default(0);
            $table->integer('inserted_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('main_menus');
    }
};
