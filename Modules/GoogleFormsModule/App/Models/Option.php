<?php

namespace Modules\GoogleFormsModule\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\GoogleFormsModule\Database\factories\OptionFactory;

class Option extends Model
{
    use HasFactory,  SoftDeletes;

    protected $table = "options";


    protected $guarded = ['id'];



    public function userAnswerOptions()
    {
        return $this->hasMany(UserAnswerOption::class);
    }

}
