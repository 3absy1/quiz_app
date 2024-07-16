<?php

namespace Modules\GoogleFormsModule\App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Modules\GoogleFormsModule\App\Models\UserAnswer;

class StudentExport implements FromCollection,WithHeadings
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return  $this->data;
    }

    public function headings(): array
    {
        return [
            'Name',
            'User Email',
            'Degree',
            'start time',
            'end time',
            'questions count',
            'right answers count',
            'wrong answers count',

    ];
    }

}
