<?php

namespace Modules\GoogleFormsModule\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\GoogleFormsModule\Database\factories\FormFactory;

class Form extends Model
{
    use HasFactory ;
    protected $guarded = [];


    public function questions()
    {
        return $this->hasMany(Question::class);
    }
    public function userAnswers()
    {
        return $this->hasMany(UserAnswer::class);
    }
    public function userAnswerOptions()
    {
        return $this->hasMany(UserAnswerOption::class);
    }
    public function userAnswerQuestions()
    {
        return $this->hasMany(UserAnswerQuestion::class);
    }

    protected static function boot()
    {

        parent::boot();
        static::deleting(function ($model) {
            $questions = $model->questions();
            $questions->delete();

            $userAnswers = $model->userAnswers();
            $userAnswers->delete();

            $userAnswerOptions = $model->userAnswerOptions();
            $userAnswerOptions->delete();

            $userAnswerQuestions = $model->userAnswerQuestions();
            $userAnswerQuestions->delete();

        });
    }

}
