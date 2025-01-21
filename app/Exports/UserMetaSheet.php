<?php

namespace App\Exports;

use App\Models\Group;
use App\Models\Watch;
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
            'User Role',
            '',
            'Watch Code'
        ];
    }

    public function collection()
    {
        $groups = Group::where('active', true)->get();
        $watches = Watch::where('active', true)->get();

        // First, determine the maximum number of rows needed
        $maxRows = max(3, $groups->count(), $watches->count()); // At least 3 rows for roles, or more if we have more watches
        // Create the base array with the required number of rows
        $array = array_fill(0, $maxRows, ['', '', '', '', '']);

        // Fill in the roles for the first 3 rows
        $array[0][2] = ADMIN;
        $array[1][2] = ENGINEER;
        $array[2][2] = OPERATOR;

        foreach ($groups as $index => $group) {
            $array[$index][0] = $group->code;
        }

        foreach ($watches as $index => $watch) {
            $array[$index][4] = $watch->code;
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
