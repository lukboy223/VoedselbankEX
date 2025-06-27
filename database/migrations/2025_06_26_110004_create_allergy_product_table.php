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
        drop table if exists Allergies_Products;
        CREATE TABLE Allergies_Products (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Allergies_id INT UNSIGNED NOT NULL,
    Products_id INT UNSIGNED NOT NULL,
    IsActive BIT NOT NULL DEFAULT 1,
    Created_at DATETIME(6) NOT NULL DEFAULT NOW(6),
    Updated_at DATETIME(6) NOT NULL DEFAULT NOW(6),
    Note VARCHAR(255) DEFAULT NULL,
    FOREIGN KEY (Allergies_id) REFERENCES Allergies(id),
    FOREIGN KEY (Products_id) REFERENCES Products(id)
);
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Allergies_Products');
    }
};
