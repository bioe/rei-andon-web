<?php

namespace App\Exports;

use App\Models\Group;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;


class UserMetaSheet implements WithHeadings, WithTitle, FromCollection, WithStyles
{
    public function headings(): array
    {
        return [
            'Group Code',
            '',
            'User Role'
        ];
    }

    public function collection()
    {
        $groups = Group::all();

        $array = [['', '', ADMIN], ['', '', ENGINEER], ['', '', OPERATOR]];
        foreach ($groups as $index => $group) {
            $array[$index][0] = $group->code;
        }

        return collect($array);
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'User Meta';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],
        ];
    }
}
