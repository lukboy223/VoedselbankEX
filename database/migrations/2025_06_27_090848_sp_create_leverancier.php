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
            DROP PROCEDURE IF EXISTS sp_create_leverancier;
            CREATE PROCEDURE sp_create_leverancier(
                IN SuppliersName VARCHAR(255),
                IN ContactsPersonName VARCHAR(255),
                IN PhoneNumber VARCHAR(20),
                IN Streetname VARCHAR(255),
                IN Housenumber VARCHAR(10),
                IN ZipCode VARCHAR(10),
                IN Place VARCHAR(100),
                IN Email VARCHAR(255)
                IN Password VARCHAR(255)
            )
            BEGIN
                INSERT INTO Suppliers (SuppliersName, ContactsPersonName, User_id)
                VALUES (SuppliersName, ContactsPersonName, LAST_INSERT_ID());

                INSERT INTO Contacts (PhoneNumber, Streetname, Housenumber, ZipCode, Place)
                VALUES (PhoneNumber, Streetname, Housenumber, ZipCode, Place);

                INSERT INTO Users (Email, Password, Name, Contacts_id)
                VALUES (Email, Password, SuppliersName, LAST_INSERT_ID());
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
