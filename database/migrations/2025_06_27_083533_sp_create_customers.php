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
            IN p_Password VARCHAR(255)
        )
        BEGIN
            DECLARE v_ContactId INT;
            DECLARE v_UserId INT;

            START TRANSACTION;

            INSERT INTO Contacts (Streetname, Housenumber, Zipcode, Place, PhoneNumber, created_at, updated_at)
            VALUES (p_Streetname, p_Housenumber, p_Zipcode, p_Place, p_PhoneNumber, NOW(), NOW());

            SET v_ContactId = LAST_INSERT_ID();

            INSERT INTO users (email, password, name, Contacts_id, created_at, updated_at)
            VALUES (p_email, p_Password, p_GezinsNaam, v_ContactId, NOW(), NOW());

            SET v_UserId = LAST_INSERT_ID();

            INSERT INTO Customers (GezinsNaam, AmountAdults, AmoundChilderen, Amountbabies, Wishes, User_id, IsActive, created_at, updated_at)
            VALUES (p_GezinsNaam, p_AmountAdults, p_AmoundChilderen, p_Amountbabies, p_Wishes, v_UserId, 1, NOW(), NOW());

            COMMIT;
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
