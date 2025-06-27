<?php

// tests/Feature/CustomerIndexTest.php
namespace Tests\Feature;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

uses(RefreshDatabase::class);

beforeEach(function () {
    // Zorg dat migraties draaien voor elke test
    $this->artisan('migrate');
});

test('index returns customers via sp_read_Customers', function () {
    // Simuleer dat er een klant bestaat
    DB::table('Customers')->insert([
        [
            'id' => 1,
            'IsActive' => 1,
            'GezinsNaam' => 'Testgezin',
            'AmountAdults' => 2,
            'AmoundChilderen' => 1,
            'Amountbabies' => 0,
            'Wishes' => 'Vegetarisch',
            'Streetname' => 'Voorbeeldstraat',
            'Housenumber' => '12',
            'Zipcode' => '1234AB',
            'Place' => 'Utrecht',
            'PhoneNumber' => '0612345678',
            'email' => 'test@example.com',
            'password' => bcrypt('secret'),
            'User_id' => 1,
            'Contacts_id' => 1
        ]
    ]);

    // Verwacht dat de stored procedure wordt aangeroepen
    DB::shouldReceive('select')
        ->once()
        ->withArgs(
            fn($query, $params) =>
            str_contains($query, 'sp_read_Customers') &&
                is_array($params) && count($params) === 2
        )
        ->andReturn(collect(
            DB::table('Customers')->where('IsActive', 1)->get()
        ));

    // Voer een GET-verzoek uit naar de indexroute
    $response = $this->get('/customers');

    // Controleer of de response correct is
    $response->assertStatus(200);
    $response->assertSee('Testgezin');
});
