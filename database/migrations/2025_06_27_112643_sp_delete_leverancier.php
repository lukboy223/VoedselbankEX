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
            DROP PROCEDURE IF EXISTS sp_delete_leverancier;
            CREATE PROCEDURE sp_delete_leverancier(IN SuppliersID INT)
            BEGIN
                DECLARE UserID INT;
                DECLARE ContactsID INT;

                SELECT User_id INTO UserID FROM Suppliers WHERE id = SuppliersID;
                SELECT Contacts_id INTO ContactsID FROM Users WHERE id = UserID;

                DELETE FROM Suppliers WHERE id = SuppliersID;
                DELETE FROM Users WHERE id = UserID;
                DELETE FROM Contacts WHERE id = ContactsID;
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
