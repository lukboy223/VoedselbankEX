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
        // Create stored procedure to read customers
        DB::unprepared('
            DROP PROCEDURE IF EXISTS sp_read_Customers;
            CREATE PROCEDURE sp_read_Customers(
                IN givLIMIT INT,
                IN givOFFSET INT
            )
            BEGIN
                SELECT 
                    cu.id,
                    cu.GezinsNaam,
                    co.Streetname AS Straat,
                    co.Housenumber AS Huisnummer,
                    co.Zipcode AS Zipcode,
                    co.Place AS Plaats,
                    co.PhoneNumber AS Telefoonnummer,
                    u.email AS Email
                FROM Customers cu
                INNER JOIN users u ON u.id = cu.User_id
                INNER JOIN Contacts co ON co.id = u.Contacts_id
                WHERE cu.IsActive = 1
                ORDER BY cu.GezinsNaam ASC
                LIMIT givLIMIT OFFSET givOFFSET;
            END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_read_Customers;');
    }
};
