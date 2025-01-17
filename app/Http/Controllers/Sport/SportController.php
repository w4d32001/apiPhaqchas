<?php

namespace App\Http\Controllers\Sport;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sport\StoreRequest;
use App\Http\Requests\Sport\UpdatePrice;
use App\Http\Requests\Sport\UpdateRequest;
use App\Models\Sport;
use Illuminate\Http\Request;

class SportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{

            $sports = Sport::select('id', 'name', 'description', 'price_morning', 'price_evening')->get();

            return $this->sendResponse($sports, "Lista de deportes");

        }catch(\Exception $e){
            return $this->sendError('Error: '.$e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        try{

            $validated = $request->validated();

            $sport = Sport::create($validated);

            return $this->sendResponse($sport, 'Deporte creado con exito', 'success', 201);

        }catch(\Exception $e){
            return $this->sendError('Error: '.$e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, $sport)
    {
        try{
            $validated = $request->validated();

            $sport = Sport::findOrFail($sport);
            $sport->update($validated);

            return $this->sendResponse($sport, "Deporte actualizado", 'success', 201);

        }catch(\Exception $e){
            return $this->sendError("Error: ".$e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sport $sport)
    {
        try{

            if($sport->bookings()->exists()){
                return $this->sendError('Error: Este registro tiene otros registros asociados');
            }

            $sport->delete();

            return $this->sendResponse([], 'Deporte eliminado exitosamente');

        }catch(\Exception $e){
            return $this->sendError('Erro: '.$e->getMessage());
        }
    }

    public function updatePrice(UpdatePrice $request, $id)
    {
        try {
            
            $validated = $request->validated();

            $sport = Sport::findOrFail($id);

            $updates = array_filter([
                'price_morning' => $validated['price_morning'] ?? null,
                'price_evening' => $validated['price_evening'] ?? null,
            ]);
    
            if (!empty($updates)) {
                $sport->update($updates);
            }

            return $this->sendResponse($sport, 'Precio actualizado');

        } catch (\Exception $e) {
            return $this->sendError('Erro: '.$e->getMessage());
        }
    }

}
