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
        drop procedure if exists sp_read_Supplierss;
        CREATE PROCEDURE sp_read_Supplierss(
        IN givLIMIT int, 
        IN givOFFSET int
        )
        begin
            SELECT 
                s.id, 
                s.Name, 
                s.IsActive, 
                s.Created_at, 
                s.Updated_at, 
                s.Note,
                c.Name AS ContactsName,
                c.Email AS ContactsEmail,
                c.Phone AS ContactsPhone
            FROM Suppliers s
            LEFT JOIN Contacts c ON s.Contacts_id = c.id
            WHERE s.IsActive = 1
            ORDER BY s.Name ASC
            LIMIT givLIMIT OFFSET givOFFSET;
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
