<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdateAdmin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdmiController extends Controller
{
    public function index()
    {
        try {
            $userId = Auth::id();

            $admins = User::role(['Administrador', 'trabajador'])
                ->where('id', '!=', $userId)
                ->with('roles:id,name') 
                ->with('permissions:id,name')
                ->get();

            return $this->sendResponse($admins, 'Lista de administradores (excluyéndote a ti)');
        } catch (\Exception $e) {
            return $this->sendError('Error: ' . $e->getMessage());
        }
    }


    public function show(User $user)
    {
        try {
            return $this->sendResponse($user, 'Administrador o trabajador encontrado');
        } catch (\Exception $e) {
            return $this->sendError('Error: ' . $e->getMessage());
        }
    }

    public function updateAdmi(UpdateAdmin $request, $admi, $id)
    {
        try {
            $admi = User::findOrFail($admi);
            $worker = User::findOrFail($id);

            if ($admi->rol_id != 1) {
                return $this->sendError('No tienes permisos suficientes para editar los datos de este trabajador. Solo los administradores pueden hacerlo.');
            }

            $worker->update($request->all());

            return $this->sendResponse($worker, 'Trabajador actualizado correctamente');
        } catch (\Exception $e) {
            return $this->sendError('Error: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            if ($user->bookings()->count() > 0) {
                return $this->sendError('No se puede eliminar el campo porque tiene reservas asociadas');
            }
            $user->delete();
            return $this->sendResponse([], "Usuario eliminado con exito");
        } catch (\Exception $e) {
            return $this->sendError('Error: ' . $e->getMessage());
        }
    }
}
