<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UserListSheet implements WithMapping, WithHeadings, FromQuery, WithTitle, WithStyles
{
    public function headings(): array
    {
        return [
            'Employee Code',
            'Name',
            'Badge No',
            'User Role',
            'Groups',
            'Watch Code'
        ];
    }

    public function query()
    {
        return User::query()->with('groups');
    }

    /**
     * @param User $user
     */
    public function map($user): array
    {
        $groups = [];
        foreach ($user->groups as $g) {
            $groups[] = $g->code;
        }
        return [
            $user->username,
            $user->name,
            $user->badge_no,
            $user->user_type,
            implode(', ', $groups),
            $user->watch->code ?? ''
        ];
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'User List';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],
        ];
    }
}
