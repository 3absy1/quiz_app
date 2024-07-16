<?php

namespace Modules\GoogleFormsModule\App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Modules\GoogleFormsModule\App\Models\UserAnswer;

class UserAnswersExport implements FromCollection, WithHeadings
{
    protected $ids;

    public function __construct(array $ids)
    {
        $this->ids = $ids;
    }

    public function collection()
    {
        return UserAnswer::whereIn('id', $this->ids)->get([ 'user_name','user_email', 'degree','questions_count','right_answers_count','wrong_answers_count']);
    }

    public function headings(): array
    {
        return [
            'Name',
            'Email',
            'Degree',
            'Number Of Questions',
            'Correct Answers',
            'Wrong Answers',
        ];
    }
}
