<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::updateOrCreate([
            'email' => 'email@email.com'
        ], [
            'first_name' => 'Admin',
            'last_name' => 'CA',
            'email'=>'email@email.com',
            'password' => bcrypt('password')
        ]);
    }
}
