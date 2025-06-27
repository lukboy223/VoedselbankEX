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
            // voor een unhappy path, gebruik een try-catch en verander de naam van de stored procedure
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
        // Geef de view weer met de klanten
        return view('customers.index', ['customers' => $customers]);
    }

    // Toon formulier voor het aanmaken van een nieuwe klant
    public function create()
    {
        return view('customers.create');
    }

    // Sla de nieuwe klant op in de database
    // Gebruik een stored procedure om de klant aan te maken
    // Zorg ervoor dat de validatie correct is ingesteld
    // en dat de juiste velden worden gevalideerd
    public function store(Request $request)
    {
        $validated = $request->validate([
            'Streetname' => 'required|string|max:255',
            'Housenumber' => 'required|string|max:10',
            'Place' => 'required|string|max:255',
            'Zipcode' => 'required|string|max:10',
            'GezinsNaam' => 'required|string|max:255',
            'AmountAdults' => 'required|integer|min:0',
            'AmountChildren' => 'required|integer|min:0',
            'Amountbabies' => 'required|integer|min:0',
            'Wishes' => 'nullable|string|max:500',
            'PhoneNumber' => 'required|string|max:20',
            'Email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
        ]);

        try {
            DB::select('CALL sp_create_Customer(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [
                $validated['GezinsNaam'],
                $validated['Streetname'],
                $validated['Housenumber'],
                $validated['toevoeging'] ?? null,
                $validated['Zipcode'],
                $validated['Place'],
                $validated['PhoneNumber'],
                $validated['Email'],
                bcrypt($request->input('password')),
                $validated['AmountAdults'] ?? 0,
                $validated['AmountChildren'] ?? 0,
                $validated['AmountBabies'] ?? 0,
                $validated['Wishes'] ?? null,
                $validated['IsActive'] ?? 1,
            ]);



            return redirect()->route('customers.index')
                ->with('success', "Klant succesvol toegevoegd: {$validated['GezinsNaam']}");
        } catch (\Exception $e) {
            Log::error('Fout bij het aanmaken van klant: ' . $e->getMessage());

            return redirect()->back()
                ->withInput()
                ->with('error', 'Er is een fout opgetreden bij het toevoegen van de klant.');
        }
    }
}
