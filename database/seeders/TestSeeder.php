<?php

namespace Database\Seeders;

use App\Models\Status;
use App\Models\StatusRecord;
use Carbon\Carbon;
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


        $sr = StatusRecord::create(
            [
                'segment_code' => "ZONE A",
                'employee_code' => "JOHN",
                'machine_code' => "SAW-03",
                'status_id' => 1,
                'origin' => "REI",
                'attended_at' => Carbon::now()->addSeconds(99),
                'attend_duration_second' => 99
            ]
        );

        $sr->responses()->create([
            'employee_code' => "TOM",
            'response_option' => 'Unable to attend',
            'attending' => false,
            'response_duration_second' => 10,
        ]);

        $sr->responses()->create([
            'employee_code' => "CHRIS",
            'response_option' => 'I will attend',
            'attending' => true,
            'response_duration_second' => 30,
        ]);

        StatusRecord::create(
            [
                'segment_code' => "ZONE B",
                'employee_code' => "MAX",
                'machine_code' => "DFD-03",
                'status_id' => 2,
                'origin' => "WATCH"
            ]
        );
    }
}
