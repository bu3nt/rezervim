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
        $user = User::factory()->create([
            'name' => 'Butrint Babuni',
            'email' => 'butrint.xh.babuni@gmail.com',
            'password' => Hash::make('temp1234')
        ]);

        $user->assignRole('super-admin');

        $users = User::factory(12)->create([
            'password' => Hash::make('temp1234')
        ]);
        foreach($users as $user){
            $user->assignRole('member');
        }
    }
}
