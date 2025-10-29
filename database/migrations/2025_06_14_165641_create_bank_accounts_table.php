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
        Schema::create('bank_accounts', function (Blueprint $table) {
            $table->id();
			$table->integer('bank_id');
			$table->string('branch_name', 255)->nullable();
			$table->string('account_number', 50)->nullable();
			$table->string('account_holder', 255)->nullable();
			$table->string('routing_no', 255)->nullable();
			$table->string('branch_code', 255)->nullable();
			$table->integer('bank_type')->nullable();
			$table->integer('status_active')->default(1);
			$table->integer('is_deleted')->default(0);
			$table->integer('created_by')->nullable();
			$table->integer('updated_by')->default(0);
			$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_accounts');
    }
};
