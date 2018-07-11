<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\User;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        User::truncate();

        $password = Hash::make('sikimiki');

        User::create([
            'name' => 'Nemanja Mili',
            'email' => 'nemanjamili@gmail.com',
            'password' => $password,
        ]);

    }
}
