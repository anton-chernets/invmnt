<?php

namespace Database\Seeders;

use App\Enums\RolesEnum;
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
        foreach (array_column(RolesEnum::cases(), 'value') as $role) {
            Role::firstOrCreate([
                'name' => $role,
                'guard_name' => 'web',
            ]);
        }

        foreach (array_column(PermissionsEnum::cases(), 'value') as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $role = Role::firstWhere(['name' => RolesEnum::ADMIN]);

        $role->syncPermissions(
            Permission::pluck('id','id')->all()
        );

        User::where(['email' => env('EMAIL_ADMIN')])
            ->firstOrFail()
            ->assignRole([$role->id]);
    }
}
