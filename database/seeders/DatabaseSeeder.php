<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call(RolePermissionSeeder::class);

        $user = User::factory()->create([
            'name' => 'user1',
            'username' => 'user',
            'email' => 'user@user.com',
            'password' =>  Hash::make('321'),
        ]);

        $user->assignRole('user');
    }
}
