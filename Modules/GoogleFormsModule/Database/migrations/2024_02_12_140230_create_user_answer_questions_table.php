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
        Schema::create('user_answer_questions', function (Blueprint $table) {
            $table->id();
            $table->integer('question_id')->nullable();
            // $table->foreignId('question_id')->nullable()->references('id')->on('questions')->cascadeOnDelete();
            $table->text('question_type')->nullable();
            $table->integer('form_id')->nullable();
            // $table->foreignId('form_id')->nullable()->references('id')->on('forms')->cascadeOnDelete();
            $table->integer('user_answers_id')->nullable();
            // $table->foreignId('user_answers_id')->nullable()->references('id')->on('user_answers')->cascadeOnDelete();
            $table->string('degree')->nullable();
            $table->boolean('is_right')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_answer_questions');
    }
};
