<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;
use App\Http\Requests\Permission\AssignPermissionRequest;
use App\Http\Requests\Permission\RemovePermissionRequest;
use App\Http\Requests\Role\AssignPermissionsToRoleRequest;
use App\Http\Requests\Role\AssignRoleRequest;
use App\Http\Requests\Role\RemoveRoleRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionController extends Controller
{
    public function assignRole(AssignRoleRequest $request, $userId)
    {
        $user = User::findOrFail($userId);
        $role = Role::findByName($request->role);

        $user->assignRole($role);
        return response()->json(['message' => 'Rol asignado correctamente'], 200);
    }

    public function removeRole(RemoveRoleRequest $request, $userId)
    {
        $user = User::findOrFail($userId);
        $role = Role::findByName($request->role);

        $user->removeRole($role);
        return response()->json(['message' => 'Rol eliminado correctamente'], 200);
    }

    public function assignPermission(AssignPermissionRequest $request, $userId)
    {
        $user = User::findOrFail($userId);
        $permission = Permission::findByName($request->permission);

        $user->givePermissionTo($permission);
        return response()->json(['message' => 'Permiso asignado correctamente'], 200);
    }

    public function removePermission(RemovePermissionRequest $request, $userId)
    {
        $user = User::findOrFail($userId);
        $permission = Permission::findByName($request->permission);

        $user->revokePermissionTo($permission);
        return response()->json(['message' => 'Permiso eliminado correctamente'], 200);
    }

    public function assignPermissionsToRole(AssignPermissionsToRoleRequest $request, $roleId)
    {
        $role = Role::findOrFail($roleId);
        $permissions = Permission::whereIn('name', $request->permissions)->get();

        $role->syncPermissions($permissions);
        return response()->json(['message' => 'Permisos asignados al rol correctamente'], 200);
    }


    public function getUserRoles($userId)
    {
        $user = User::findOrFail($userId);
        return $this->sendResponse($user->roles, 'Roles del usuario', 'success', 200);
    }

    public function getUserPermissions($userId)
    {
        $user = User::findOrFail($userId);
        return $this->sendResponse($user->permissions, 'Permisos del usuario', 'success', 200);
    }
}
