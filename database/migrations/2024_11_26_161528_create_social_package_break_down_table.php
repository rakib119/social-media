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
        Schema::create('social_package_break_down', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('mst_id');
            $table->string('sub_package_name')->max(50)->nullable();
            $table->text('desc_link')->max(500)->nullable();
            $table->float('price')->nullable();
            $table->float('discount_per')->nullable();
            $table->float('discounted_amount')->nullable();
            $table->integer('status_active')->default(1);
            $table->integer('is_deleted')->default(0);
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('social_package_break_down');
    }
};
