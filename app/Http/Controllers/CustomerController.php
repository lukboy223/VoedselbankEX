<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\LengthAwarePaginator;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $perPage = 25;
        $page = $request->input('page', 1);
        $offset = ($page - 1) * $perPage;

        try {
            // Totaal aantal actieve klanten ophalen
            $total = DB::table('Customers')->where('IsActive', 1)->count();

            // Stored procedure aanroepen
            $customers = DB::select('CALL sp_read_Customers(?, ?)', [$perPage, $offset]);

            // Resultaat omzetten naar een paginator
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

            // Teruggeven aan de view
            return view('customers.index', ['customers' => $customers]);
        } catch (\Exception $e) {
            // Fout loggen
            Log::error('Fout bij ophalen van klanten: ' . $e->getMessage());

            // Foutmelding tonen
            return view('customers.index')->withErrors([
                'general' => 'Er is een fout opgetreden bij het laden van de klanten. Probeer het later opnieuw.'
            ]);
        }
    }
}
