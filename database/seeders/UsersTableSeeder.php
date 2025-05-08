<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        User::create([
            'name' => 'Riyad',
            'email' => 'riyadhfadhel97@example.com',
            'password' => Hash::make('password123'), // Always hash passwords!
        ]);

        // Creating the second user
        User::create([
            'name' => 'Akram',
            'email' => 'ryadhfadhel86886@example.com',
            'password' => Hash::make('password123'),
        ]);
    }
}
