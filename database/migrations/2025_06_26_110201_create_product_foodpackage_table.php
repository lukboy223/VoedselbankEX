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
        drop table if exists Product_FoodPackage;
        CREATE TABLE Product_FoodPackage (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    FoodPackage_id INT UNSIGNED NOT NULL,
    Product_id INT UNSIGNED NOT NULL,
    IsActive BIT NOT NULL DEFAULT 1,
    Created_at DATETIME(6) NOT NULL DEFAULT NOW(6),
    Updated_at DATETIME(6) NOT NULL DEFAULT NOW(6),
    Note VARCHAR(255) DEFAULT NULL,
    FOREIGN KEY (FoodPackage_id) REFERENCES FoodPackage(id),
    FOREIGN KEY (Product_id) REFERENCES Product(id)
);
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_foodpackage');
    }
};
