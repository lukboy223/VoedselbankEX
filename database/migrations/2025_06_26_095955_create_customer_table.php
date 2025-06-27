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
       drop table if exists Customers;
    CREATE TABLE Customers (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    User_id INT UNSIGNED NOT NULL,
    GezinsNaam VARCHAR(150) NOT NULL UNIQUE,
    AmountAdults TINYINT UNSIGNED NOT NULL,
    AmoundChilderen TINYINT UNSIGNED NOT NULL,
    Amountbabies TINYINT UNSIGNED NOT NULL,
    Wishes TEXT DEFAULT NULL,
    IsActive BIT NOT NULL DEFAULT 1,
    Created_at DATETIME(6) NOT NULL DEFAULT NOW(6),
    Updated_at DATETIME(6) NOT NULL DEFAULT NOW(6),
    Note VARCHAR(255) DEFAULT NULL,
    FOREIGN KEY (User_id) REFERENCES User(id)
);');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Customers');
    }
};
