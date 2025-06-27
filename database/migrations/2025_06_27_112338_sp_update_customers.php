<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_update_Customers;');
        // Create stored procedure to update customers
        // Deze stored procedure update de klantgegevens, inclusief adres en contactinformatie
        DB::unprepared('
        DROP PROCEDURE IF EXISTS sp_update_Customers;
        CREATE PROCEDURE sp_update_Customers(
        IN p_CustomerId INT,
        IN p_GezinsNaam VARCHAR(255),
        IN p_AmountAdults INT,
        IN p_AmoundChilderen INT,
        IN p_Amountbabies INT,
        IN p_Wishes TEXT,
        IN p_Streetname VARCHAR(255),
        IN p_Housenumber VARCHAR(10),
        IN p_Zipcode VARCHAR(20),
        IN p_Place VARCHAR(255),
        IN p_PhoneNumber VARCHAR(20),
        IN p_email VARCHAR(255),
        IN p_UpdatedAt DATETIME
    )
    BEGIN
        DECLARE v_UserId INT;
        DECLARE v_ContactId INT;

        -- Haal de bijbehorende user_id en contacts_id op
        SELECT User_id INTO v_UserId FROM Customers WHERE id = p_CustomerId;
        SELECT Contacts_id INTO v_ContactId FROM users WHERE id = v_UserId;

        START TRANSACTION;

        -- Update Contacts tabel
        UPDATE Contacts
        SET Streetname = p_Streetname,
            Housenumber = p_Housenumber,
            Zipcode = p_Zipcode,
            Place = p_Place,
            PhoneNumber = p_PhoneNumber,
            updated_at = p_UpdatedAt
        WHERE id = v_ContactId;

        -- Update Users tabel (zonder wachtwoord)
        UPDATE users
        SET email = p_email,
            name = p_GezinsNaam,
            updated_at = p_UpdatedAt
        WHERE id = v_UserId;

        -- Update Customers tabel
        UPDATE Customers
        SET GezinsNaam = p_GezinsNaam,
            AmountAdults = p_AmountAdults,
            AmoundChilderen = p_AmoundChilderen,
            Amountbabies = p_Amountbabies,
            Wishes = p_Wishes,
            updated_at = p_UpdatedAt
        WHERE id = p_CustomerId;

        COMMIT;
    END
        ');
    }

    public function down(): void
    {
    //..
    }
};
