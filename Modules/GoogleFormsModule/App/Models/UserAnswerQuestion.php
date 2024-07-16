<?php

namespace Modules\GoogleFormsModule\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\GoogleFormsModule\Database\factories\UserAnswerQuestionFactory;

class UserAnswerQuestion extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = [];

}
