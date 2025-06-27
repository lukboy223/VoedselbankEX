<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

uses(RefreshDatabase::class);


test('it can create a supplier successfully', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    
    // No DB mocking - let it hit the actual test database
    $response = $this->post(route('supplier.store'), [
        'SuppliersName' => 'Test Leverancier',
        'ContactsPersonName' => 'John Doe',
        'email' => 'test@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'phone' => '0612345678',
        'street_name' => 'Test Straat',
        'house_number' => '123',
        'addition' => null,
        'postal_code' => '1234AB',
        'place' => 'Test Plaats',
    ]);

    $response->assertRedirect();
    $response->assertSessionHas('success'); // Expect error due to missing stored procedure
});

test('it validates required fields', function () {
    $user = User::factory()->create();
$this->actingAs($user);
    $response = $this->post(route('supplier.store'), []);

    $response->assertSessionHasErrors([
        'SuppliersName',
        'ContactsPersonName',
        'email',
        'password',
        'phone',
        'street_name',
        'house_number',
        'postal_code',
        'place',
        // Note: 'addition' are nullable, so they shouldn't be in required field errors
    ]);
});

test('it validates email format', function () {
    $user = User::factory()->create();
$this->actingAs($user);
    $response = $this->post(route('supplier.store'), [
        'SuppliersName' => 'Test Leverancier',
        'ContactsPersonName' => 'John Doe',
        'email' => 'invalid-email',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'phone' => '0612345678',
        'street_name' => 'Test Straat',
        'house_number' => '123',
        'postal_code' => '1234AB',
        'place' => 'Test Plaats',
    ]);

    $response->assertSessionHasErrors(['email']);
});

test('it validates password confirmation', function () {
    $user = User::factory()->create();
$this->actingAs($user);
    $response = $this->post(route('supplier.store'), [
        'SuppliersName' => 'Test Leverancier',
        'ContactsPersonName' => 'John Doe',
        'email' => 'test@example.com',
        'password' => 'password123',
        'password_confirmation' => 'different_password',
        'phone' => '0612345678',
        'street_name' => 'Test Straat',
        'house_number' => '123',
        'postal_code' => '1234AB',
        'place' => 'Test Plaats',
    ]);

    $response->assertSessionHasErrors(['password']);
});

test('it validates postal code length', function () {
    $user = User::factory()->create();
$this->actingAs($user);
    $response = $this->post(route('supplier.store'), [
        'SuppliersName' => 'Test Leverancier',
        'ContactsPersonName' => 'John Doe',
        'email' => 'test@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'phone' => '0612345678',
        'street_name' => 'Test Straat',
        'house_number' => '123',
        'postal_code' => '123', // Too short
        'place' => 'Test Plaats',
    ]);

    $response->assertSessionHasErrors(['postal_code']);
});
