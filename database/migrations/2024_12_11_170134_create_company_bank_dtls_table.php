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
        Schema::create('company_bank_dtls', function (Blueprint $table) {
            $table->id();
			$table->integer('bank_type')->nullable();;
			$table->integer('bank_id')->nullable();;
			$table->string('bank_name')->nullable();;
			$table->string('branch')->nullable();;
			$table->string('account_number')->nullable();
			$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_bank_dtls');
    }
};
