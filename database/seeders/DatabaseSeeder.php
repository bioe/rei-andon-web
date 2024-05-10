<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\MachineType;
use App\Models\Segment;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        //Create admin
        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'username' => 'admin',
            'password' => Hash::make('12345678'),
            'user_type' => ADMIN,
            'active' => true,
        ]);


        //Create Machine Types
        $types = [
            ['code' => 'DFD651', 'name' => 'DFD651'],
            ['code' => 'DFD6361', 'name' => 'DFD6361'],
            ['code' => 'DFD6362', 'name' => 'DFD6362'],
            ['code' => 'DFD7161', 'name' => 'DFD7161'],
            ['code' => 'DFM2800', 'name' => 'DFM2800'],
            ['code' => 'DGP8761', 'name' => 'DGP8761'],
            ['code' => 'EAGLETI', 'name' => 'EAGLETI'],
            ['code' => 'RAD2010', 'name' => 'RAD2010'],
            ['code' => 'DRY_ETCH', 'name' => 'DRY_ETCH'],
            ['code' => 'DIEBOND', 'name' => 'DIEBOND'],
            ['code' => 'VIA_PLASMA', 'name' => 'VIA_PLASMA'],
            ['code' => 'LASER_VIA', 'name' => 'LASER_VIA'],
            ['code' => 'CU_SPUTTER', 'name' => 'CU_SPUTTER'],
            ['code' => 'TAPPING', 'name' => 'TAPPING'],
            ['code' => 'UV_CURE', 'name' => 'UV_CURE'],
            ['code' => 'LASER_GROOVE', 'name' => 'LASER_GROOVE'],
            ['code' => 'W_SORTER', 'name' => 'W_SORTER'],
            ['code' => 'W_AOI_PANEL', 'name' => 'W_AOI_PANEL'],
            ['code' => 'W_PLASMA', 'name' => 'W_PLASMA'],
            ['code' => 'AP', 'name' => 'AP'],
            ['code' => 'ABF_CURE', 'name' => 'ABF_CURE'],
            ['code' => 'CAPCON', 'name' => 'CAPCON'],
        ];

        foreach ($types as $type) {
            MachineType::create($type);
        }

        //Create Segment
        $segments = [
            ['code' => 'ZONE A', 'name' => 'ZONE A'],
            ['code' => 'ZONE B', 'name' => 'ZONE B'],
            ['code' => 'ZONE C', 'name' => 'ZONE C'],
            ['code' => 'ZONE D', 'name' => 'ZONE D'],
            ['code' => 'ZONE E', 'name' => 'ZONE E'],
            ['code' => 'ZONE F', 'name' => 'ZONE F'],
            ['code' => 'ZONE G', 'name' => 'ZONE G'],
            ['code' => 'ZONE H', 'name' => 'ZONE H'],
        ];

        foreach ($segments as $v) {
            Segment::create($v);
        }
    }
}
