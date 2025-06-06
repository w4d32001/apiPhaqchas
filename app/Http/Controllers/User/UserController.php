<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
       try{
              $users = User::all();
              return $this->sendResponse($users, "Lista de usuarios");
       }catch(\Exception $e){
           return $this->sendError($e->getMessage());
       }
    }

    

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        try {
            $validated = $request->validated();
            $user = User::create($validated);
            $user->assignRole('usuario');
            return $this->sendResponse($user, "Usuario creado con exito", 'success', 201);
        } catch (\Exception $e) {
            return $this->sendError('Error: '.$e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        try {
            return $this->sendResponse($user, 'Usuario encontrado');
        } catch (\Exception $e) {
            return $this->sendError('Error: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, $id)
    {
        try {
            $user = User::findOrFail($id);
            $validated = $request->validated();
            $user->update();
            return $this->sendResponse($user, 'Usuario actualizado');
        } catch (\Exception $e) {
            return $this->sendError('Error: '.$e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            if($user->bookings()->count() > 0) {
                return $this->sendError('No se puede eliminar el campo porque tiene reservas asociadas');
            }
            $user->delete();
            return $this->sendResponse([], "Usuario eliminado con exito");
        } catch (\Exception $e) {
            return $this->sendError('Error: '.$e->getMessage());
        }
    }
}
