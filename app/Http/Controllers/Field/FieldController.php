<?php

namespace App\Http\Controllers\Field;

use App\Http\Controllers\Controller;
use App\Http\Requests\Field\StoreRequest;
use App\Http\Requests\Field\UpdateImage;
use App\Http\Requests\Field\UpdateRequest;
use App\Http\Resources\Field\FieldResource;
use App\Models\Field;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FieldController extends Controller
{
    public function index()
    {
        try {
            $fields = Field::select('id', 'status', 'name', 'image', 'description')->get();
            return $this->sendResponse($fields, 'Lista de campos');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function store(StoreRequest $request)
    {
        try {
            $validated = $request->validated();

            if($request->hasFile('image')){
                $image = $request->file('image')->store('public/images');
                $validated['image'] = Storage::url($image);
            }

            $field = Field::create($validated);

            return $this->sendResponse(['field' => $field], 'Campo creado exitosamente', 'success', 201);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function update(UpdateRequest $request, $id)
    {
        try {
            $validated = $request->validated();
            $field = Field::findOrFail($id);
            $field->update($validated);

            return $this->sendResponse(['field' => $field], 'Campo actualizado exitosamente');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function show(Field $field)
    {
        try {
            return $this->sendResponse(['field' => $field], 'Campo encontrado');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $field = Field::findOrFail($id);
            if($field->bookings()->count() > 0) {
                return $this->sendError('No se puede eliminar el campo porque tiene reservas asociadas');
            }
            $field->delete();
            return $this->sendResponse([], 'Campo eliminado exitosamente');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function updateImage(UpdateImage $request, $id){
        try {
            $data = Field::findOrFail($id);
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

    public function updateStatus($id){
        try {
            $data = Field::findOrFail($id);
            $data->update([
                'status' => !$data->status
            ]);
            return $this->sendResponse($data, "Estado actualizado");
        } catch (\Exception $e) {
            return $this->sendError('Error: '.$e->getMessage());
        }
    }
}
