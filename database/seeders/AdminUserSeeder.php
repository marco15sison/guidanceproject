<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // User::create([
        //     'name' => 'Administrator',
        //     'email' => 'SNCA', 
        //     'password' => Hash::make('administrator'),
        //     'user_type' => 'admin',
        // ]);


        // // Faculty user with FAC-SC as email
        User::create([
            'name' => 'Faculty',
            'email' => 'FAC-SC',  // Using plain FAC-SC as email/login ID
            'password' => Hash::make('faculty'),
            'user_type' => 'faculty',
        ]);

        // // Student user with 22-SC-0000 as email
        User::create([
            'name' => 'Ella Mae Devera',
            'email' => '22-SC-0216', // Using plain 22-SC-0000 as email/login ID
            'password' => Hash::make('student'),
            'user_type' => 'student',
        ]);

        

        // User::create([
        //     'name' => 'Marco D. Sison',
        //     'email' => '22-SC-3905', // Using plain 22-SC-0000 as email/login ID
        //     'password' => Hash::make('student'),
            
        //     'user_type' => 'student',
        // ]);

        User::create([
            'name' => 'Cliff Dazel O. Hisita',
            'email' => '22-SC-3923', // Using plain 22-SC-0000 as email/login ID
            'password' => Hash::make('student'),
            'user_type' => 'student',
        ]);

        $this->command->info('Users created successfully.');
    }
}