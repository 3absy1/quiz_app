<?php

namespace Modules\GoogleFormsModule\App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Modules\GoogleFormsModule\App\Models\UserAnswer;

class FormExport implements FromCollection,WithHeadings
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
            'Desc',
            'Degree',
            'question count',
            'password',
            'time out',
            'date',
            'start time',
            'end time',
            'duration',

    ];
    }

}
