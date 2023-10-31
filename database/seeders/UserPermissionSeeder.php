<?php

namespace Database\Seeders;

use App\Models\User;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Enums\PermissionsEnum;

class UserPermissionSeeder extends UserSeeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $values = array_column(PermissionsEnum::cases(), 'value');
        foreach ($values as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $role = Role::firstOrCreate([
            'name' => 'Admin',
            'guard_name' => 'web',
        ]);

        $permissions = Permission::pluck('id','id')->all();
        $role->syncPermissions($permissions);

        User::where(['email' => self::EMAIL_MAIN])
            ->firstOrFail()
            ->assignRole([$role->id]);
    }
}
