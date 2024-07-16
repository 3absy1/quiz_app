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
        Schema::create('user_answers', function (Blueprint $table) {
            $table->id();
            $table->string('user_name')->nullable();
            $table->string('user_email')->nullable();
            $table->string('token')->nullable();
            $table->timestamp('start_time')->nullable();
            $table->timestamp('end_time')->nullable();
            $table->boolean('finish_in_time')->nullable();
            $table->string('degree')->nullable();
            $table->integer('form_id')->nullable();
            // $table->foreignId('form_id')->nullable()->references('id')->on('forms')->cascadeOnDelete();
            $table->integer('questions_count')->nullable();
            $table->integer('user_questions_count')->nullable();
            $table->integer('right_answers_count')->nullable();
            $table->integer('wrong_answers_count')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_histories');
    }
};
