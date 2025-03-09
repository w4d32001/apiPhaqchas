<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;
use App\Http\Requests\Roles\StoreRequest;
use App\Http\Requests\Roles\UpdateRequest;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        try {
            $roles = Role::all();
            return $this->sendResponse($roles, "Lista de roles");
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), 500);
        }
    }

    public function store(StoreRequest $request)
    {
        try {
            $validated = $request->validated();
            $role = Role::create(['name' => $validated['name']]);

            if ($request->has('permissions')) {
                $role->syncPermissions($validated['permissions']);
            }

            return $this->sendResponse($role, 'Rol creado con éxito', 'success', 201);
        } catch (\Exception $e) {
            return $this->sendError('Error: ' . $e->getMessage(), 500);
        }
    }

    public function show(string $id)
    {
        try {
            $role = Role::findOrFail($id);
            return $this->sendResponse($role, "Detalle del rol");
        } catch (\Exception $e) {
            return $this->sendError('Error: ' . $e->getMessage(), 404);
        }
    }

    public function update(UpdateRequest $request, string $id)
    {
        try {
            $role = Role::findOrFail($id);
            $validated = $request->validated();

            $role->update(['name' => $validated['name']]);

            if ($request->has('permissions')) {
                $role->syncPermissions($validated['permissions']);
            }

            return $this->sendResponse($role, 'Rol actualizado con éxito', 'success', 200);
        } catch (\Exception $e) {
            return $this->sendError('Error: ' . $e->getMessage(), 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $role = Role::findOrFail($id);
            $role->delete();

            return $this->sendResponse([], "Rol eliminado con éxito");
        } catch (\Exception $e) {
            return $this->sendError('Error: ' . $e->getMessage(), 500);
        }
    }
}
