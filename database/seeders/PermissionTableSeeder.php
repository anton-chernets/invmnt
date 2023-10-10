<?php

namespace Database\Seeders;

use App\Models\User;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionTableSeeder extends DatabaseSeeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ([
            'horizon',
            // another permissions
        ] as $permission) {
            Permission::firstOrNew(['name' => $permission]);
        }

        $role = Role::where(['name' => 'Admin'])->first();
        $permissions = Permission::pluck('id','id')->all();
        $role->syncPermissions($permissions);

        User::where(['email' => self::EMAIL_MAIN])
            ->firstOrFail()
            ->assignRole([$role->id]);
    }
}
