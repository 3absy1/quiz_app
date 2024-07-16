<?php

namespace Modules\GoogleFormsModule\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\GoogleFormsModule\Database\factories\FormHistoryFactory;

class UserAnswer extends Model
{
    use HasFactory;
    protected $table= 'user_answers';

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = [];


    public function userAnswerQuestions()
    {
        return $this->hasMany(UserAnswerQuestion::class);
    }

    public function userAnswerOptions()
    {
        return $this->hasMany(UserAnswerOption::class);
    }

}
