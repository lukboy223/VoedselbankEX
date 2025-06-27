<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared('
            DROP PROCEDURE IF EXISTS sp_create_Customers;
            CREATE PROCEDURE sp_create_Customers(
                IN p_GezinsNaam VARCHAR(150),
                IN p_AmountAdults TINYINT,
                IN p_AmoundChilderen TINYINT,
                IN p_Amountbabies TINYINT,
                IN p_Wishes TEXT,
                IN p_Note VARCHAR(255),
                IN p_PhoneNumber VARCHAR(20),
                IN p_Streetname VARCHAR(255),
                IN p_Housenumber VARCHAR(10),
                IN p_ZipCode VARCHAR(10),
                IN p_Place VARCHAR(100),
                IN p_Email VARCHAR(255),
                IN p_Password VARCHAR(255)
            )
            BEGIN
                -- Voeg eerst contactgegevens toe
                INSERT INTO Contacts (PhoneNumber, Streetname, Housenumber, Zipcode, Place)
                VALUES (p_PhoneNumber, p_Streetname, p_Housenumber, p_ZipCode, p_Place);

                -- Voeg daarna gebruiker toe met verwijzing naar laatst ingevoerde contact
                INSERT INTO Users (email, password, Contacts_id)
                VALUES (p_Email, p_Password, LAST_INSERT_ID());

                -- Voeg daarna klant toe met verwijzing naar laatst ingevoerde user
                INSERT INTO Customers (
                    User_id, GezinsNaam, AmountAdults, AmoundChilderen, Amountbabies,
                    Wishes, IsActive, Created_at, Updated_at, Note
                )
                VALUES (
                    LAST_INSERT_ID(),
                    p_GezinsNaam,
                    p_AmountAdults,
                    p_AmoundChilderen,
                    p_Amountbabies,
                    p_Wishes,
                    1,
                    NOW(6),
                    NOW(6),
                    p_Note
                );
            END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_create_Customers;');
    }
};
