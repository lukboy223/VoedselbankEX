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
                c.id,
                cu.GezinsNaam,
                co.Streetname AS Straat,
                co.Housenumber AS Huisnummer,
                co.Zipcode AS Toevoeging,
                co.Place AS Plaats,
                co.PhoneNumber AS Telefoonnummer,
                u.email AS Email
            FROM Customers cu
            LEFT JOIN Contacts co ON c.Address_id = a.id
            LEFT JOIN Contacts p ON c.Contact_id = p.id
            WHERE c.IsActive = 1
            ORDER BY c.Name ASC
            LIMIT givLIMIT OFFSET givOFFSET;
        END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
