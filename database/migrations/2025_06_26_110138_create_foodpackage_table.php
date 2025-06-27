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
        drop table if exists FoodPackages;
        CREATE TABLE FoodPackages (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Customers_id INT UNSIGNED NOT NULL,
    PackageNumber VARCHAR(50) NOT NULL UNIQUE,
    DateOfCreation DATE NOT NULL,
    DateOfDispatch DATE NOT NULL,
    IsActive BIT NOT NULL DEFAULT 1,
    Created_at DATETIME(6) NOT NULL DEFAULT NOW(6),
    Updated_at DATETIME(6) NOT NULL DEFAULT NOW(6),
    Note VARCHAR(255) DEFAULT NULL,
    FOREIGN KEY (Customers_id) REFERENCES Customers(id)
);
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('FoodPackages');
    }
};
