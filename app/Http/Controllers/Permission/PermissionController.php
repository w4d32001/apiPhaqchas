<?php

namespace App\Http\Controllers\Permission;

use App\Http\Controllers\Controller;
use App\Http\Requests\Permissions\UpdateRequest;
use App\Http\Requests\Roles\StoreRequest;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index()
    {
        try {
            $permissions = Permission::all();
            return $this->sendResponse($permissions, 'Lista de permisos');
        } catch (\Exception $e) {
            return $this->sendError('Error: ' . $e->getMessage());
        }
    }

    /**
     * Crear permiso
     */
    public function store(StoreRequest $request)
    {
        try {
            $validated = $request->validated();
            $permission = Permission::create(['name' => $validated['name']]);
            return $this->sendResponse($permission, 'Permiso creado con éxito', 'success', 201);
        } catch (\Exception $e) {
            return $this->sendError('Error: '. $e->getMessage());
        }
    }

    /**
     * Mostrar un permiso
     */
    public function show($id)
    {
        try {
            $permission = Permission::findOrFail($id);
            return $this->sendResponse($permission, 'Detalle del permiso');
        } catch (\Exception $e) {
            return $this->sendError('Error: '. $e->getMessage(), 404);
        }
    }

    /**
     * Actualizar un permiso
     */
    public function update(UpdateRequest $request, $id)
    {
        try {
            $permission = Permission::findOrFail($id);
            $validated = $request->validated();
            $permission->update(['name' => $validated['name']]);
            return $this->sendResponse($permission, 'Permiso actualizado');
        } catch (\Exception $e) {
            return $this->sendError('Error: '. $e->getMessage());
        }
    }

    /**
     * Eliminar un permiso
     */
    public function destroy($id)
    {
        try {
            $permission = Permission::findOrFail($id);
            $permission->delete();
            return $this->sendResponse([], 'Permiso eliminado');
        } catch (\Exception $e) {
            return $this->sendError('Error: '. $e->getMessage());
        }
    }
}
