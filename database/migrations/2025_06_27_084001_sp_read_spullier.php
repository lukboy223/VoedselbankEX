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
        drop procedure if exists sp_read_Supplier;
        CREATE PROCEDURE sp_read_Supplier(
        IN SUPid int
        )
        begin
            SELECT 
            SUP.id,
            SUP.SuppliersName,
            SUP.ContactsPersonName,
            CON.PhoneNumber,
            CON.Streetname,
            CON.Housenumber,
            CON.Addition,
            CON.ZipCode,
            CON.Place,
            USR.Email,
            max(SHI.DateDelivery) as LastShipmentDate

            from Suppliers as SUP

            inner join Users as USR
            on SUP.User_id = USR.id

            inner join Contacts as CON 
            on USR.Contacts_id = CON.id

            left join shipments as SHI
            on SUP.id = SHI.Suppliers_id

            where SUP.id = SUPid

            group by SUP.id;

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
