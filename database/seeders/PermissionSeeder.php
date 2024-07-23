<?php

namespace Database\Seeders;

use App\Enums\StatusEnum;
use App\Models\Permission;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::factory()->createMany([
            [
                'name' => 'create-users',
                'status' => StatusEnum::ACTIVE,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ],
            [
                'name' => 'view-any-users',
                'status' => StatusEnum::ACTIVE,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ],
            [
                'name' => 'view-users',
                'status' => StatusEnum::ACTIVE,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ],
            [
                'name' => 'update-users',
                'status' => StatusEnum::ACTIVE,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ],
            [
                'name' => 'delete-users',
                'status' => StatusEnum::ACTIVE,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ],
            [
                'name' => 'restore-users',
                'status' => StatusEnum::ACTIVE,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ],
            [
                'name' => 'create-roles',
                'status' => StatusEnum::ACTIVE,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ],
            [
                'name' => 'view-any-roles',
                'status' => StatusEnum::ACTIVE,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ],
            [
                'name' => 'view-roles',
                'status' => StatusEnum::ACTIVE,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ],
            [
                'name' => 'update-roles',
                'status' => StatusEnum::ACTIVE,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ],
            [
                'name' => 'restore-roles',
                'status' => StatusEnum::ACTIVE,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ],
            [
                'name' => 'delete-roles',
                'status' => StatusEnum::ACTIVE,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ],
            [
                'name' => 'create-permissions',
                'status' => StatusEnum::ACTIVE,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ],
            [
                'name' => 'view-any-permissions',
                'status' => StatusEnum::ACTIVE,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ],
            [
                'name' => 'view-permissions',
                'status' => StatusEnum::ACTIVE,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ],
            [
                'name' => 'update-permissions',
                'status' => StatusEnum::ACTIVE,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ],
            [
                'name' => 'delete-permissions',
                'status' => StatusEnum::ACTIVE,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ],
            [
                'name' => 'restore-permissions',
                'status' => StatusEnum::ACTIVE,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ],
        ]);
    }
}
