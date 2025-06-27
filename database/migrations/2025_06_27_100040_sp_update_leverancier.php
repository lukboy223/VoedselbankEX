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
        drop procedure if exists sp_update_leverancier;
        create procedure sp_update_leverancier(
                IN SuppliersID INT,
                IN SuppliersName VARCHAR(255),
                IN ContactsPersonName VARCHAR(255),
                IN PhoneNumber VARCHAR(20),
                IN Streetname VARCHAR(255),
                IN Housenumber VARCHAR(10),
                IN ZipCode VARCHAR(10),
                IN Place VARCHAR(100),
                IN Email VARCHAR(255),
                IN Password VARCHAR(255)
        )
                begin
                declare UserID INT;
                declare ContactsID INT;

                select User_id 
                into UserID 
                from Suppliers where id = SuppliersID;

                select Contacts_id 
                into ContactsID 
                from Users where id = UserID;

                update Suppliers set 
                SuppliersName = SuppliersName, 
                ContactsPersonName = ContactsPersonName 
                where id = SuppliersID;

                update Contacts set
                PhoneNumber = PhoneNumber,
                Streetname = Streetname,
                Housenumber = Housenumber,
                ZipCode = ZipCode,
                Place = Place
                where id = ContactsID;

                update Users set
                Email = Email,
                Password = Password,
                Name = SuppliersName
                where id = UserID;

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
