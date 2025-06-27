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
        drop table if exists Contacts;
        CREATE TABLE Contacts (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Streetname VARCHAR(150) NOT NULL,
    Housenumber VARCHAR(5) NOT NULL,
    Zipcode VARCHAR(6) NOT NULL,
    Place VARCHAR(150) NOT NULL,
    Addition VARCHAR(10) DEFAULT NULL,
    PhoneNumber VARCHAR(10) NOT NULL UNIQUE,
    IsActive BIT NOT NULL DEFAULT 1,
    Created_at DATETIME(6) NOT NULL DEFAULT NOW(6),
    Updated_at DATETIME(6) NOT NULL DEFAULT NOW(6),
    Note VARCHAR(255) DEFAULT NULL
);
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Contacts');
    }
};
