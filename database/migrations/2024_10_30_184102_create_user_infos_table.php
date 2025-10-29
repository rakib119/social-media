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
        Schema::create('user_infos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->string('verification_type',20)->nullable();
            $table->string('full_name',255)->nullable();
            $table->string('first_name',80)->nullable();
            $table->string('middle_name',80)->nullable();
            $table->string('last_name',80)->nullable();
            $table->integer('gender')->nullable();
            $table->integer('profession')->nullable();
            $table->integer('religion')->nullable();
            $table->string('mobile',15)->nullable();
            $table->string('email',255)->nullable();
            $table->text('nid_or_dob')->nullable();
            $table->text('documents')->nullable();
            $table->integer('country')->nullable();
            $table->integer('division')->nullable();
            $table->integer('district')->nullable();
            $table->integer('upazila')->nullable();
            $table->string('postcode',20)->nullable();
            $table->text('address',400)->nullable();
            $table->string('audio_verification_code',30)->nullable();
            $table->string('video_verification_code',30)->nullable();
            $table->integer('is_personal_info_approved')->nullable();
            $table->integer('personal_info_approved_by')->nullable();
            $table->timestamp('personal_info_created_at')->nullable();
            $table->timestamp('personal_info_updated_at')->nullable();
            $table->timestamp('personal_info_approved_at')->nullable();
            //Father
            $table->string('father_full_name',255)->nullable();
            $table->string('father_first_name',80)->nullable();
            $table->string('father_middle_name',80)->nullable();
            $table->string('father_last_name',80)->nullable();
            $table->text('father_address',400)->nullable();
            $table->integer('father_profession')->nullable();
            $table->integer('father_religion')->nullable();
            $table->string('father_mobile',15)->nullable();
            $table->string('father_email',255)->nullable();
            $table->text('father_nid_or_dob')->nullable();
            $table->text('father_documents')->nullable();
            $table->integer('father_approved_status')->nullable();
            $table->integer('father_info_approved_by')->nullable();

            $table->timestamp('father_info_created_at')->nullable();
            $table->timestamp('father_info_updated_at')->nullable();
            $table->timestamp('father_info_approved_at')->nullable();
            //Mother
            $table->string('mother_full_name',255)->nullable();
            $table->string('mother_first_name',80)->nullable();
            $table->string('mother_middle_name',80)->nullable();
            $table->string('mother_last_name',80)->nullable();
            $table->text('mother_address',400)->nullable();
            $table->integer('mother_profession')->nullable();
            $table->integer('mother_religion')->nullable();
            $table->string('mother_mobile',15)->nullable();
            $table->string('mother_email',255)->nullable();
            $table->text('mother_nid_or_dob')->nullable();
            $table->text('mother_documents')->nullable();
            $table->integer('mother_approved_status')->nullable();
            $table->integer('mother_info_approved_by')->nullable();

            $table->timestamp('mother_info_created_at')->nullable();
            $table->timestamp('mother_info_updated_at')->nullable();
            $table->timestamp('mother_info_approved_at')->nullable();
            //Emergency
            $table->string('emergency_full_name',255)->nullable();
            $table->string('emergency_first_name',80)->nullable();
            $table->string('emergency_middle_name',80)->nullable();
            $table->string('emergency_last_name',80)->nullable();
            $table->text('emergency_address',400)->nullable();
            $table->integer('emergency_profession')->nullable();
            $table->integer('emergency_religion')->nullable();
            $table->string('emergency_relation')->nullable();
            $table->string('emergency_mobile',15)->nullable();
            $table->string('emergency_email',255)->nullable();
            $table->text('emergency_nid_or_dob')->nullable();
            $table->text('emergency_documents')->nullable();
            $table->integer('emergency_approved_status')->nullable();

            $table->timestamp('emergency_info_created_at')->nullable();
            $table->timestamp('emergency_info_updated_at')->nullable();
            $table->timestamp('emergency_info_approved_at')->nullable();

            $table->integer('is_final_submited')->nullable();
            $table->bigInteger('final_approved_by')->nullable();

            $table->timestamp('final_info_created_at')->nullable();
            $table->timestamp('final_info_updated_at')->nullable();
            $table->timestamp('final_info_approved_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_infos');
    }
};
