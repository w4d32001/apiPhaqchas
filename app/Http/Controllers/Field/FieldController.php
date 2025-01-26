<?php

namespace App\Http\Controllers\Field;

use App\Http\Controllers\Controller;
use App\Http\Requests\Field\StoreRequest;
use App\Http\Requests\Field\UpdateRequest;
use App\Http\Resources\Field\FieldResource;
use App\Models\Field;
use Illuminate\Http\Request;

class FieldController extends Controller
{
    public function index()
    {
        try {
            $fields = Field::select('id', 'status', 'name')->get();
            return $this->sendResponse(['field' => FieldResource::collection($fields)], 'Lista de campos');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function store(StoreRequest $request)
    {
        try {
            $validated = $request->validated();

            $field = Field::create([
                'name' => $validated['name'],
            ]);

            return $this->sendResponse(['field' => $field], 'Campo creado exitosamente', 'success', 201);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function update(UpdateRequest $request, Field $field)
    {
        try {
            $validated = $request->validated();

            $field->update([
                'name' => $validated['name'] ?? $field->name
            ]);

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

    public function destroy(Field $field)
    {
        try {
            if($field->bookings()->count() > 0) {
                return $this->sendError('No se puede eliminar el campo porque tiene reservas asociadas');
            }
            $field->delete();
            return $this->sendResponse([], 'Campo eliminado exitosamente');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }
}
