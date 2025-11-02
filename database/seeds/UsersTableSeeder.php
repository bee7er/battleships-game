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
        $user->name = 'System';
        $user->email = 'system@gmail.com';
        $user->password = Hash::make('battle202');
        $user->user_token = User::getNewToken();
        $user->admin = true;
        $user->save();

        $user = new User();
        $user->name = 'brian';
        $user->email = 'brian@gmail.com';
        $user->password = Hash::make('battle101');
        $user->user_token = User::getNewToken();
        $user->admin = true;
        $user->save();

        $user = new User();
        $user->name = 'steve';
        $user->email = 'steve@gmail.com';
        $user->password = Hash::make('battle101');
        $user->user_token = User::getNewToken();
        $user->admin = false;
        $user->save();

        $user = new User();
        $user->name = 'phil';
        $user->email = 'phil@gmail.com';
        $user->password = Hash::make('battle101');
        $user->user_token = User::getNewToken();
        $user->admin = false;
        $user->save();

        $user = new User();
        $user->name = 'andrew';
        $user->email = 'andrew@gmail.com';
        $user->password = Hash::make('battle101');
        $user->user_token = User::getNewToken();
        $user->admin = false;
        $user->save();

        $user = new User();
        $user->name = 'greg';
        $user->email = 'greg@gmail.com';
        $user->password = Hash::make('battle101');
        $user->user_token = User::getNewToken();
        $user->admin = false;
        $user->save();

        $user = new User();
        $user->name = 'tim';
        $user->email = 'tim@gmail.com';
        $user->password = Hash::make('battle101');
        $user->user_token = User::getNewToken();
        $user->admin = false;
        $user->save();

        $user = new User();
        $user->name = 'ben';
        $user->email = 'ben@gmail.com';
        $user->password = Hash::make('battle101');
        $user->user_token = User::getNewToken();
        $user->admin = false;
        $user->save();

        $user = new User();
        $user->name = 'russ';
        $user->email = 'russ@gmail.com';
        $user->password = Hash::make('battle101');
        $user->user_token = User::getNewToken();
        $user->admin = false;
        $user->save();

        $user = new User();
        $user->name = 'kika';
        $user->email = 'kika@gmail.com';
        $user->password = Hash::make('battle101');
        $user->user_token = User::getNewToken();
        $user->admin = false;
        $user->save();

        $user = new User();
        $user->name = 'ayndie';
        $user->email = 'ayndie@gmail.com';
        $user->password = Hash::make('battle101');
        $user->user_token = User::getNewToken();
        $user->admin = false;
        $user->save();

    }

}
