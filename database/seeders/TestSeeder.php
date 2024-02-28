<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 8; $i++) {
            $state = "warning";
            $name = "Require Assist";
            if ($i > 4) {
                $state = "error";
                $name = "Power Failure";
            }
            Status::create([
                'code' => 'W00' . $i,
                'name' => $name . $i,
                'state' => $state,
                'button_1' => 'I will attend',
                'button_2' => 'Unable to attend',
                'active' => true
            ]);
        }
    }
}
