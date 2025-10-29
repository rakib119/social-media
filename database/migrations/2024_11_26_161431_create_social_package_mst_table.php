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
        Schema::create('social_package_mst', function (Blueprint $table) {
            $table->id();
            $table->string('package_name')->max(255)->nullable();
            $table->text('short_desc')->max(500)->nullable();
            $table->float('price')->nullable();
            $table->float('discount_per')->nullable();
            $table->float('discounted_amount')->nullable();
            $table->float('renewal_fee')->nullable();
            $table->string('renewable_message')->nullable();
            $table->integer('status_active')->default(1);
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
        Schema::dropIfExists('social_package_mst');
    }
};
