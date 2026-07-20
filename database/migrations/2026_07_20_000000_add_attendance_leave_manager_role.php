<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Spatie\Permission\PermissionRegistrar;

return new class extends Migration
{
    private const ROLE = 'attendance-leave-manager';

    public function up(): void
    {
        $acl = Arr::getVar('permission');
        $permissionNames = collect(Arr::get($acl, 'permissions', []))
            ->flatMap(fn (array $permissions) => collect($permissions)
                ->filter(fn (array $roles) => in_array(self::ROLE, $roles, true))
                ->keys())
            ->all();
        $permissionIds = DB::table('permissions')
            ->whereIn('name', $permissionNames)
            ->pluck('id');

        DB::table('teams')->orderBy('id')->each(function ($team) use ($permissionIds) {
            $roleId = DB::table('roles')
                ->where('team_id', $team->id)
                ->where('name', self::ROLE)
                ->where('guard_name', 'web')
                ->value('id');

            if (! $roleId) {
                $roleId = DB::table('roles')->insertGetId([
                    'uuid' => (string) Str::uuid(),
                    'team_id' => $team->id,
                    'name' => self::ROLE,
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            DB::table('role_has_permissions')->insertOrIgnore(
                $permissionIds->map(fn (int $permissionId) => [
                    'permission_id' => $permissionId,
                    'role_id' => $roleId,
                ])->all()
            );
        });

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }

    public function down(): void
    {
        DB::table('roles')->where('name', self::ROLE)->delete();

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
};
