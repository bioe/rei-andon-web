<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class UsersExport implements WithMultipleSheets
{
    use Exportable;

    public function sheets(): array
    {
        $sheets = [new UserListSheet, new UserMetaSheet];

        return $sheets;
    }
}
