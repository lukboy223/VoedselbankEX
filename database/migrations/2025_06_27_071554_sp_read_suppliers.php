<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared('
        drop procedure if exists sp_read_Suppliers;
        CREATE PROCEDURE sp_read_Suppliers(
        IN givLIMIT int, 
        IN givOFFSET int
        )
        begin
            SELECT 
            SUP.id,
            SUP.SuppliersName,
            SUP.ContactsPersonName,
            CON.PhoneNumber,
            max(SHI.DateDelivery) as LastShipmentDate

            from Suppliers as SUP

            inner join Users as USR
            on SUP.User_id = USR.id

            inner join Contacts as CON 
            on USR.Contacts_id = CON.id

            inner join shipments as SHI
            on SUP.id = SHI.Suppliers_id

            group by SUP.id

            ORDER BY SUP.SuppliersName ASC

            LIMIT givLIMIT 
            OFFSET givOFFSET;
        end

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
