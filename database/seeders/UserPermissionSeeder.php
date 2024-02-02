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
            'name' => self::NAME_MAIN,
            'guard_name' => 'web',
        ]);

        $role->syncPermissions(
            Permission::pluck('id','id')->all()
        );

        User::where(['email' => env('EMAIL_ADMIN')])
            ->firstOrFail()
            ->assignRole([$role->id]);
    }
}
