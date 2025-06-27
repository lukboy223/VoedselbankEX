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
        drop table if exists shipment;
        CREATE TABLE Shipment (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Supplier_id INT UNSIGNED NOT NULL,
    Product_id INT UNSIGNED NOT NULL,
    Amount MEDIUMINT UNSIGNED NOT NULL,
    DateDelivery DATE NOT NULL,
    IsActive BIT NOT NULL DEFAULT 1,
    Created_at DATETIME(6) NOT NULL DEFAULT NOW(6),
    Updated_at DATETIME(6) NOT NULL DEFAULT NOW(6),
    Note VARCHAR(255) DEFAULT NULL,
    FOREIGN KEY (Supplier_id) REFERENCES Supplier(id),
    FOREIGN KEY (Product_id) REFERENCES Product(id)
);
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipment');
    }
};
