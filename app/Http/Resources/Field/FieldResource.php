<?php

namespace App\Http\Resources\Field;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FieldResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'field_type_id' => $this->fieldType->name,
            'price_morning' => $this->price_morning,
            'price_evening' => $this->price_evening,
            'name' => $this->name,
            'status' => $this->status
        ];
    }
}