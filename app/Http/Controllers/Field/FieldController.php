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
            $fields = Field::select('id', 'field_type_id', 'price_morning', 'price_evening', 'status', 'name')->get();
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
                'field_type_id' => $validated['field_type_id'],
                'name' => $validated['name'],
                'price_morning' => $validated['price_morning'], 
                'price_evening' => $validated['price_evening'], 
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
                'field_type_id' => $validated['field_type_id'] ?? $field->field_type_id,
                'name' => $validated['name'] ?? $field->name,
                'price_morning' => $validated['price_morning'] ?? $field->price_morning,
                'price_evening' => $validated['price_evening'] ?? $field->price_evening, 
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
            $field->delete();
            return $this->sendResponse([], 'Campo eliminado exitosamente');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }
}
