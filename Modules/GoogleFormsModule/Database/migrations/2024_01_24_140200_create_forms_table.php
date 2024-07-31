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
        Schema::create('forms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->longText('desc');
            $table->foreignId('teacher_id')->nullable()->references('id')->on('teachers')->cascadeOnDelete();
            $table->string('generated_id')->nullable();
            $table->string('image_dir')->nullable();
            $table->string('image')->nullable();
            $table->integer('question_count')->nullable();
            $table->integer('user_question_count');
            $table->integer('degree');
            // $table->string('phone')->nullable();
            $table->enum('require_phone', [0, 1])->default(0);
            $table->enum('require_password', [0, 1])->default(0);
            $table->string('password')->nullable();
            $table->enum('require_email', [0, 1])->default(0);
            $table->enum('using_count', [0, 1])->nullable();
            $table->enum('is_any_time', [0, 1])->default(0);
            $table->enum('is_answered', [0, 1])->default(0);
            $table->string('time_out')->nullable();

            $table->enum('is_specific_time', [0, 1])->default(0);
            $table->date('date')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->enum('is_duration', [0, 1])->default(0);
            $table->string('duration')->nullable();


            $table->integer('created_by')->default(0);
            $table->integer('updated_by')->default(0);
            $table->integer('deleted_by')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forms');
    }
};
