<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Super User',
                'email' => 'super@email.com',
                'email_verified_at' => Carbon::now(),
                'password' => bcrypt('secret'),
                'role_id' => 1,
                'accessed_first_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null,
            ],
            [
                'name' => 'Admin User',
                'email' => 'admin@email.com',
                'email_verified_at' => Carbon::now(),
                'password' => bcrypt('secret'),
                'role_id' => 1,
                'accessed_first_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null,
            ],
            [
                'name' => 'Common User',
                'email' => 'common@email.com',
                'email_verified_at' => Carbon::now(),
                'password' => bcrypt('secret'),
                'role_id' => 2,
                'accessed_first_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null,
            ],
        ]);

        User::factory()->count(100)->create();
    }
}
