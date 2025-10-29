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
        Schema::create('package_purchase_mst', function (Blueprint $table) {
            $table->id();
            $table->integer('package_mst_id')->nullable();
            $table->integer('package_break_down_id')->nullable();
            $table->bigInteger('user_id')->nullable();
            $table->integer('payment_for')->nullable();
            $table->float('package_value')->nullable();
            $table->float('discount_per')->nullable();
            $table->float('payment_amount')->nullable();
            $table->integer('payment_method')->nullable();
            $table->integer('payment_type')->nullable();
            $table->integer('company_account_id')->nullable()->default(0);
            $table->integer('company_bank_id')->nullable()->default(0);
            $table->integer('bank_name')->nullable();
            $table->string('account_holder')->nullable()->max(255);
            $table->string('company_account_no')->nullable()->max(50);
            $table->string('account_no')->nullable()->max(50);
            $table->string('branch')->nullable()->max(255);
            $table->string('transaction_id')->nullable()->max(255);
            $table->string('image')->nullable()->max(255);
            $table->string('reference_no')->nullable()->max(30);
            $table->text('remarks')->nullable();
            $table->integer('payment_status')->default(0)->comment('0 for pending 1for confirmed 2 for reject');
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
        Schema::dropIfExists('package_purchase_mst');
    }
};
