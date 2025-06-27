<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SuppliersController extends Controller
{
    public function index(Request $request) {

       $perPage = 25;
        $page = $request->input('page', 1);
        $offset = ($page - 1) * $perPage;

        $total = DB::table('Supplierss')->count();

        // try catch looks if the SP exists
        try{
            $Supplierss = DB::select('call sp_read_suppiers(?, ?)', [$perPage, $offset]);

        } catch (\Exception $e) {
            //logs the error in the log
            Log::error('error reading Supplierss: ' . $e->getMessage());
            //makes an empty array if the SP doesn't exist
            $Supplierss = [];
        }
        
        //paginate

        $Supplierss = new LengthAwarePaginator($Supplierss, $total, $perPage, $page, [
            'path' => $request->url(),
            'query' => $request->query(),
        ]);

        //redirect the user to the index page with all the Supplierss
       
        return view('Supplierss.index', ['Supplierss' => $Supplierss]);

    }
}
