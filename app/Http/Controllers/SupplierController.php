<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SupplierController extends Controller
{
    public function index(Request $request)
    {

       $perPage = 25;
        $page = $request->input('page', 1);
        $offset = ($page - 1) * $perPage;

        $total = DB::table('Suppliers')->count();

        // try catch looks if the SP exists
        try{
            $Suppliers = DB::select('call sp_read_suppliers(?, ?)', [$perPage, $offset]);

        } catch (\Exception $e) {
            //logs the error in the log
            Log::error('error reading Suppliers: ' . $e->getMessage());
            //makes an empty array if the SP doesn't exist
            $Suppliers = [];
        }
        
        //paginate

        $Suppliers = new LengthAwarePaginator($Suppliers, $total, $perPage, $page, [
            'path' => $request->url(),
            'query' => $request->query(),
        ]);

        //redirect the user to the index page with all the Supplierss
       
        return view('Suppliers.index', ['suppliers' => $Suppliers]);

    }

    public function show($id)
    {
        // try catch looks if the SP exists
        try{
            $Supplier = DB::select('call sp_read_Supplier(?)', [$id]);
        } catch (\Exception $e) {
            //logs the error in the log
            Log::error('error reading Supplier: ' . $e->getMessage());
            //makes an empty array if the SP doesn't exist
           
            return view('Suppliers.index',)->with('error', 'Er is een fout opgetreden bij het ophalen van de leverancier. Probeer het later opnieuw.');
        }
        if( empty($Supplier)) {
            // If no supplier is found, redirect to the index with an error message
            return redirect()->route('supplier.index')->with('error', 'Leverancier niet gevonden.');
        }
        //redirect the user to the show page with the Supplier
        return view('Suppliers.show', ['supplier' => $Supplier[0]]);
    }

    public function create()
    {
        //redirect the user to the create page
        return view('Supplier.create');
    }
}
