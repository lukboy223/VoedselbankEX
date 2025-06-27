<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // DROP bestaande procedures als ze bestaan
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_create_Customer;');

        // Stored Procedure om nieuwe klant aan te maken
        DB::unprepared('
        CREATE PROCEDURE sp_create_Customer(
            IN p_GezinsNaam VARCHAR(100),
            IN p_Streetname VARCHAR(100),
            IN p_Housenumber VARCHAR(10),
            IN p_Zipcode VARCHAR(10),
            IN p_Place VARCHAR(100),
            IN p_PhoneNumber VARCHAR(20),
            IN p_Email VARCHAR(255),
            IN p_IsActive BOOLEAN
        )
        BEGIN
            DECLARE contact_id INT;
            DECLARE user_id INT;

            -- Insert contact info
            INSERT INTO Contacts (Streetname, Housenumber, Zipcode, Place, PhoneNumber)
            VALUES (p_Streetname, p_Housenumber, p_Zipcode, p_Place, p_PhoneNumber);

            SET contact_id = LAST_INSERT_ID();

            -- Insert user
            INSERT INTO users (email, Contacts_id)
            VALUES (p_Email, contact_id);

            SET user_id = LAST_INSERT_ID();

            -- Insert customer
            INSERT INTO Customers (GezinsNaam, User_id, IsActive)
            VALUES (p_GezinsNaam, user_id, p_IsActive);
        END
    ');
    }
};
