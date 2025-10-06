<?php

use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder {

    public function run()
    {
        DB::table('users')->delete();

        $user = new User();
        $user->name = 'brian';
        $user->email = 'brian@gmail.com';
        $user->password = Hash::make('Freddo911');
        $user->user_token = User::getNewToken();
        $user->admin = true;
        $user->save();

        $user = new User();
        $user->name = 'steve';
        $user->email = 'steve@gmail.com';
        $user->password = Hash::make('Freddo911');
        $user->user_token = User::getNewToken();
        $user->admin = false;
        $user->save();

    }

}
