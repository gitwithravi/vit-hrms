<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\PermissionRegistrar;

return new class extends Migration
{
    private const ROLE = 'attendance-leave-manager';

    public function up(): void
    {
        $permissionNames = collect(Arr::get(Arr::getVar('permission'), 'permissions', []))
            ->flatMap(fn (array $permissions) => collect($permissions)
                ->filter(fn (array $roles) => in_array(self::ROLE, $roles, true))
                ->keys());
        $permissionIds = DB::table('permissions')
            ->whereIn('name', $permissionNames)
            ->pluck('id');
        $roleIds = DB::table('roles')
            ->where('name', self::ROLE)
            ->where('guard_name', 'web')
            ->pluck('id');

        DB::table('role_has_permissions')->whereIn('role_id', $roleIds)->delete();

        $assignments = $roleIds->flatMap(fn (int $roleId) => $permissionIds
            ->map(fn (int $permissionId) => [
                'permission_id' => $permissionId,
                'role_id' => $roleId,
            ]))
            ->all();

        if ($assignments) {
            DB::table('role_has_permissions')->insert($assignments);
        }

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }

    public function down(): void
    {
        // The role remains usable with the permissions provisioned by its original migration.
    }
};
