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
        Schema::create('user_answer_options', function (Blueprint $table) {
            $table->id();
            $table->integer('form_id')->nullable();
            // $table->foreignId('form_id')->nullable()->references('id')->on('forms')->cascadeOnDelete();
            $table->integer('question_id')->nullable();
            // $table->foreignId('question_id')->nullable()->references('id')->on('questions')->cascadeOnDelete();
            $table->integer('user_answers_id')->nullable();
            // $table->foreignId('user_answers_id')->nullable()->references('id')->on('user_answers')->cascadeOnDelete();
            $table->integer('user_answers_question_id')->nullable();
            // $table->foreignId('user_answers_question_id')->nullable()->references('id')->on('user_answer_questions')->cascadeOnDelete();
            $table->text('user_option_id')->nullable();
            // $table->foreignId('user_option_id')->nullable()->references('id')->on('options')->cascadeOnDelete();
            $table->text('right_option_id')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_answer_options');
    }
};
