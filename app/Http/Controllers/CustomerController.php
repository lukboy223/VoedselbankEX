<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;


class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $perPage = 25;
        $page = $request->input('page', 1);
        $offset = ($page - 1) * $perPage;

        try {
            // Tel actieve klanten
            $total = DB::table('Customers')->where('IsActive', 1)->count();

            // Probeer stored procedure uit te voeren
            $customers = DB::select('CALL sp_read_Customers(?, ?)', [$perPage, $offset]);

            // Zet resultaat om naar paginator
            $customers = new LengthAwarePaginator(
                $customers,
                $total,
                $perPage,
                $page,
                [
                    'path' => $request->url(),
                    'query' => $request->query(),
                ]
            );
        } catch (\Exception $e) {
            Log::warning('Stored procedure mislukt of bestaat niet: ' . $e->getMessage());

            // Geef lege collection terug
            $customers = new LengthAwarePaginator(
                collect([]), // lege collectie
                0, // totaal
                $perPage,
                $page,
                [
                    'path' => $request->url(),
                    'query' => $request->query(),
                ]
            );
        }

        return view('customers.index', ['customers' => $customers]);
    }
}
