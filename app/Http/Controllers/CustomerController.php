<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;



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
        $messages = [
            'GezinsNaam.unique' => 'The family name has already been taken.',
        ];
        $validated = $request->validate([
            'GezinsNaam' => 'required|string|max:255|unique:Customers,GezinsNaam',
            'AmountAdults' => 'required|integer|min:0',
            'AmoundChilderen' => 'required|integer|min:0',
            'Amountbabies' => 'required|integer|min:0',
            'Wishes' => 'nullable|string',
            'Streetname' => 'required|string|max:255',
            'Housenumber' => 'required|string|max:10',
            'Zipcode' => 'required|string|max:20',
            'Place' => 'required|string|max:255',
            'PhoneNumber' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:6|confirmed', // voorbeeld validatie
        ], $messages);

        try {
            DB::statement('CALL sp_create_Customers(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [
                $validated['GezinsNaam'],
                $validated['AmountAdults'],
                $validated['AmoundChilderen'],
                $validated['Amountbabies'],
                $validated['Wishes'],
                $validated['Streetname'],
                $validated['Housenumber'],
                $validated['Zipcode'],
                $validated['Place'],
                $validated['PhoneNumber'],
                $validated['email'],
                Hash::make($validated['password']),
            ]);

            return redirect()->route('customers.index')->with('success', 'Klant succesvol toegevoegd.');
        } catch (\Exception $e) {
            return back()->withErrors(['general' => 'Er is iets misgegaan bij het toevoegen van de klant: ' . $e->getMessage()])->withInput();
        }
    }

    // Toon formulier voor het bewerken van een klant
    public function edit($id)
    {
        $customer = DB::table('Customers')
            ->join('users', 'Customers.User_id', '=', 'users.id')
            ->join('Contacts', 'users.Contacts_id', '=', 'Contacts.id')
            ->where('Customers.id', $id)
            ->select('Customers.*', 'users.email', 'Contacts.*')
            ->first();

        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'GezinsNaam' => 'required|string|max:255|unique:Customers,GezinsNaam,' . $id,
            'AmountAdults' => 'required|integer|min:0',
            'AmoundChilderen' => 'required|integer|min:0',
            'Amountbabies' => 'required|integer|min:0',
            'Wishes' => 'nullable|string',
            'Streetname' => 'required|string|max:255',
            'Housenumber' => 'required|string|max:10',
            'Zipcode' => 'required|string|max:20',
            'Place' => 'required|string|max:255',
            'PhoneNumber' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'password' => 'nullable|string|min:6|confirmed',
        ], [
            'GezinsNaam.unique' => 'The family name has already been taken.',
        ]);

        try {
            DB::statement('CALL sp_update_Customers(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [
                $id,
                $validated['GezinsNaam'],
                $validated['AmountAdults'],
                $validated['AmoundChilderen'],
                $validated['Amountbabies'],
                $validated['Wishes'],
                $validated['Streetname'],
                $validated['Housenumber'],
                $validated['Zipcode'],
                $validated['Place'],
                $validated['PhoneNumber'],
                $validated['email'],
                now()
            ]);

            return redirect()->route('customers.index')->with('success', 'Klant succesvol bijgewerkt.');
        } catch (\Exception $e) {
            \Log::error('Fout bij het bijwerken van klant: ' . $e->getMessage());

            // Toon een algemene foutmelding
            return back()->withErrors([
                'general' => 'Er is een fout opgetreden bij het bijwerken van de klantgegevens.'
            ])->withInput();
        }
    }
}
