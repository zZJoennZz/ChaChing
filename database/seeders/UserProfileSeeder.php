<?php

namespace Database\Seeders;

use App\Models\UserProfile;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        UserProfile::create([
            'users_id' => 1,
            'first_name' => 'Eien',
            'middle_name' => '',
            'last_name' => 'Dev',
            'others' => '',
            'positions_id' => 1,
        ]);
    }
}
