<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdateAdmin;
use App\Models\User;
use Illuminate\Http\Request;

class AdmiController extends Controller
{
    public function index()
    {
        try {
            $admi = User::where('rol_id', 1)->orWhere('rol_id', 2)->get();
            return $this->sendResponse($admi, 'Lista de administradores y trabajadores');
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

            if($admi->rol_id != 1){
                return $this->sendError('No tienes permisos suficientes para editar los datos de este trabajador. Solo los administradores pueden hacerlo.');
            }

            $worker->update($request->all());

            return $this->sendResponse($worker, 'Trabajador actualizado correctamente');
        } catch (\Exception $e) {
            return $this->sendError('Error: ' . $e->getMessage());
        }
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
