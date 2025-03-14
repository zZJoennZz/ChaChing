<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        User::create([
            'branches_id' => 1,
            'type' => 'DEV',
            'username' => "webdev",
            'email' => "joennsa@gmail.com",
            'password' => bcrypt("pokemon14"),
        ]);
    }
}
