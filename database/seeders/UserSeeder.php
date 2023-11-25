<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdmin = User::factory()->create([
            'name' => 'Butrint Babuni',
            'email' => 'butrint.xh.babuni@gmail.com',
            'password' => Hash::make('temp1234')
        ]);

        $superAdmin->assignRole('super-admin');

        $admin = User::factory()->create([
            'name' => 'Butrint Master',
            'email' => '230327026.m@uni-prizren.com',
            'password' => Hash::make('temp1234')
        ]);

        $admin->assignRole('admin');

        $admin = User::factory()->create([
            'name' => 'Shkelzen Muja',
            'email' => 'shkelzen_muja@yahoo.com',
            'password' => Hash::make('temp1234')
        ]);

        $admin->assignRole('admin');

        $users = User::factory(12)->create([
            'password' => Hash::make('temp1234')
        ]);
        foreach($users as $user){
            $user->assignRole('member');
        }
    }
}
