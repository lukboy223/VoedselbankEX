<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\User;
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
        return view('Suppliers.create');
    }

    public function store(Request $request) 
    {
        //validate the request
        $request->validate([
            'SuppliersName' => 'required|string|max:100|min:2|regex:/^[a-zA-Z\s]+$/',
            'ContactsPersonName' => 'required|string|max:100|regex:/^[a-zA-Z\s]+$/',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'required|string|max:10|unique:contacts,PhoneNumber',
            'street_name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'house_number' => 'required|string|max:10',
            'addition' => 'nullable|string|max:10|regex:/^[a-zA-Z]+$/',
            'postal_code' => 'required|string|max:6|min:6',
            'place' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
        ]);
        
        // Hash the password
        $hashedPassword = bcrypt($request->password);
        
        try {
            // Call the stored procedure with the updated parameters
            $result = DB::select('CALL sp_create_leverancier(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [
                $request->SuppliersName,
                $request->ContactsPersonName,
                $request->phone,
                $request->street_name,
                $request->house_number,
                $request->addition,
                $request->postal_code,
                $request->place,
                $request->email,
                $hashedPassword,
               
            ]);
            
            // Redirect with success message
            return redirect()->route('supplier.index')
                ->with('success', "Leverancier succesvol toegevoegd");
                
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error creating supplier: ' . $e->getMessage());
            
            // Redirect back with error message
            return redirect()->back()
                ->withInput()
                ->with('error', 'Er is een fout opgetreden bij het toevoegen van de leverancier. Probeer het later opnieuw.');
        }
    }

    public function edit($id)
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
        //redirect the user to the edit page with the Supplier
        return view('Suppliers.edit', ['supplier' => $Supplier[0]]);
    }

    public function update(Request $request, $id)
    {

        $userId = Supplier::where('id', $id)->value('user_id');
        $contactsId = User::where('id', $userId)->value('contacts_id');
        //validate the request
        $request->validate([
            'SuppliersName' => 'required|string|max:100|min:2|regex:/^[a-zA-Z\s]+$/',
            'ContactsPersonName' => 'required|string|max:100|regex:/^[a-zA-Z\s]+$/',
            'email' => 'required|email|max:255|unique:users,email,' . $userId,
            'phone' => 'nullable|string|max:10|unique:contacts,PhoneNumber,' . $contactsId,
            'street_name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'house_number' => 'required|string|max:10',
            'addition' => 'nullable|string|max:10|regex:/^[a-zA-Z]+$/',
            'postal_code' => 'required|string|max:6|min:6',
            'place' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'password' => 'nullable|string|min:8|confirmed',
        ]);
        
        // Only hash password if it's provided
        $hashedPassword = $request->filled('password') ? bcrypt($request->password) : null;
        
        try {
            // Call the stored procedure with the updated parameters
            $result = DB::select('CALL sp_update_leverancier(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [
                $id,
                $request->SuppliersName,
                $request->ContactsPersonName,
                $request->phone,
                $request->street_name,
                $request->house_number,
                $request->addition,
                $request->postal_code,
                $request->place,
                $request->email,
                $hashedPassword,
               
            ]);
            
            // Redirect with success message
            return redirect()->route('supplier.index')
                ->with('success', "Leverancier succesvol bijgewerkt");
                
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error updating supplier: ' . $e->getMessage());
            
            // Redirect back with error message
            return redirect()->back()
                ->withInput()
                ->with('error', 'Er is een fout opgetreden bij het bijwerken van de leverancier. Probeer het later opnieuw.');
        }
    }

    public function destroy($id)
    {
        // try catch looks if the SP exists
        try{
            DB::select('call sp_delete_leverancier(?)', [$id]);
        } catch (\Exception $e) {
            //logs the error in the log
            Log::error('error deleting Supplier: ' . $e->getMessage());
            //redirects the user to the index page with an error message
            return redirect()->route('supplier.index')->with('error', 'Er is een fout opgetreden bij het verwijderen van de leverancier. Probeer het later opnieuw.');
        }
        
        //redirects the user to the index page with a success message
        return redirect()->route('supplier.index')->with('success', 'Leverancier succesvol verwijderd');
    }
}
