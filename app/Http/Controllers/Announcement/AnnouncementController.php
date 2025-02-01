<?php

namespace App\Http\Controllers\Announcement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Announcement\StoreRequest;
use App\Http\Requests\Announcement\UpdateImage;
use App\Http\Requests\Announcement\UpdateRequest;
use App\Models\Announcement;
use Illuminate\Support\Facades\Storage;
class AnnouncementController extends Controller
{
    public function index()
    {
        try {

            $annoucements = Announcement::select('id', 'title', 'image', 'description')
            ->where('status', 1)->get();

            return $this->sendResponse($annoucements, "Lista de anuncios");

        } catch (\Exception $e) {
            return $this->sendError("Error: ".$e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        try {
            $validated = $request->validated();
            if($request->hasFile('image')){
                $image = $request->file('image')->store('public/images');
                $validated['image'] = Storage::url($image);
            }
            $annoucement = Announcement::create($validated);
            return $this->sendResponse($annoucement, 'Anuncio creado correctamente', 'success', 201);
        } catch (\Exception $e) {
            return $this->sendError("Error: ".$e->getMessage());
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
    public function update(UpdateRequest $request, Announcement $annoucement)
    {
        try {
            $validated = $request->validated();
            $annoucement->update($validated);
            return $this->sendResponse($annoucement, 'Anuncio actualizado exitosamente', 'success', 201);
        } catch (\Exception $e) {
            return $this->sendError("Error: ".$e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $annoucement = Announcement::findOrFail($id);
            $annoucement->delete();
            return $this->sendResponse([], "Anucio eliminado exitosamente");
        } catch (\Exception $e) {
            return $this->sendError("Error: ".$e->getMessage());
        }
    }

    public function updateStatus($id){
        try {
            $data = Announcement::findOrFail($id);
            $data->update([
                'status' => !$data->status
            ]);
            return $this->sendResponse($data, "Estado actualizado");
        } catch (\Exception $e) {
            return $this->sendError('Error: '.$e->getMessage());
        }
    }

    public function updateImage(UpdateImage $request, $id){
        try {
            $data = Announcement::findOrFail($id);
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
