<?php

namespace Modules\GoogleFormsModule\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\GoogleFormsModule\Database\factories\QuestionFactory;

class Question extends Model
{
    use HasFactory,  SoftDeletes;

    protected $table = 'questions';

    protected $guarded = ['id'];

    public function options()
    {
        return $this->hasMany(Option::class);
    }

    public function userAnswerQuestions()
    {
        return $this->hasMany(UserAnswerQuestion::class);
    }
    public function userAnswerOptions()
    {
        return $this->hasMany(UserAnswerOption::class);
    }
    protected static function boot()
    {

        
        parent::boot();
        static::deleted(function ($model) {

            $options = $model->options();
            $options->delete();

            $userAnswerQuestions = $model->userAnswerQuestions();
            $userAnswerQuestions->delete();

            $userAnswerOptions = $model->userAnswerOptions();
            $userAnswerOptions->delete();




        });
    }
}
