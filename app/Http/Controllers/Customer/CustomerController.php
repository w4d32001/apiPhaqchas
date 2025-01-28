<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $customers = User::where('rol_id', '3')->get();
            return $this->sendResponse($customers, "Lista de clientes");

        }catch(\Exception $e){
            return $this->sendError($e->getMessage());
        }
    }
    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }

    public function topCustomers(){
        try {
            $customers = User::withCount('bookings')  
                ->where('rol_id', 3) 
                ->orderBy('bookings_count', 'desc') 
                ->limit(5)  
                ->get();
    
            return $this->sendResponse($customers, "Top 5 clientes");
    
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

}
