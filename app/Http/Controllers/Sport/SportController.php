<?php

namespace App\Http\Controllers\Sport;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sport\StoreRequest;
use App\Http\Requests\Sport\UpdateImage;
use App\Http\Requests\Sport\UpdatePrice;
use App\Http\Requests\Sport\UpdateRequest;
use App\Models\Sport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SportController extends Controller
{
    public function index()
    {
        try{

            $sports = Sport::select('id', 'name', 'description', 'price_morning', 'price_evening', 'image')->get();

            return $this->sendResponse($sports, "Lista de deportes");

        }catch(\Exception $e){
            return $this->sendError('Error: '.$e->getMessage());
        }
    }


    public function store(StoreRequest $request)
    {
        try{

            $validated = $request->validated();
            if($request->hasFile('image')){
                $image = $request->file('image')->store('public/images');
                $validated['image'] = Storage::url($image);
            }

            $sport = Sport::create($validated);

            return $this->sendResponse($sport, 'Deporte creado con exito', 'success', 201);

        }catch(\Exception $e){
            return $this->sendError('Error: '.$e->getMessage());
        }
    }

    public function show(string $id)
    {
        //
    }

    public function update(UpdateRequest $request, $id)
    {
        try{
            $validated = $request->validated();

            $sport = Sport::findOrFail($id);
            $sport->update($validated);

            return $this->sendResponse($sport, "Deporte actualizado", 'success', 201);

        }catch(\Exception $e){
            return $this->sendError("Error: ".$e->getMessage());
        }
    }

    public function destroy($id)
    {
        try{

            $sport = Sport::findOrFail($id);
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

    public function updateImage(UpdateImage $request, $id){
        try {
            $data = Sport::findOrFail($id);
            if ($request->hasFile('image')) {
                if ($data->image) {
                    $previousImage = str_replace(Storage::url(''), 'public/', $data->image);
                    if (Storage::exists($previousImage)) {
                        Storage::delete($previousImage);
                    }
                }
                $image = $request->file('image')->store('public/images');
                $validated['image'] = Storage::url($image);
            }
    
            $data->update([
                'image' => $validated['image'] ?? $data->image, 
            ]);
            return $this->sendResponse($data, "Imagen actualizada con exito");
        } catch (\Exception $e) {
            return $this->sendError('Error: '.$e->getMessage());
        }
    }

}
