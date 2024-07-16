<?php

namespace Modules\GoogleFormsModule\App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Modules\GoogleFormsModule\App\Models\Teacher;


class TeacherExport implements FromCollection,WithHeadings
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
            'name',
            'email',


    ];
    }

}
