<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Contact gegevens
        $contactIds = [];
        $contacts = [
            ['Streetname' => 'Hoofdstraat', 'Housenumber' => '12', 'Zipcode' => '5231AB', 'Place' => 'Den Bosch', 'PhoneNumber' => '0731234567'],
            ['Streetname' => 'Kerkstraat', 'Housenumber' => '45', 'Zipcode' => '5232CD', 'Place' => 'Den Bosch', 'PhoneNumber' => '0731234568'],
            ['Streetname' => 'Dorpsplein', 'Housenumber' => '8', 'Zipcode' => '5233EF', 'Place' => 'Maaskantje', 'PhoneNumber' => '0731234569'],
            ['Streetname' => 'Schoolstraat', 'Housenumber' => '23', 'Zipcode' => '5234GH', 'Place' => 'Maaskantje', 'PhoneNumber' => '0731234570'],
            ['Streetname' => 'Molenweg', 'Housenumber' => '67', 'Zipcode' => '5235IJ', 'Place' => 'Oss', 'PhoneNumber' => '0731234571'],
            ['Streetname' => 'Beukenlaan', 'Housenumber' => '34', 'Zipcode' => '5236KL', 'Place' => 'Oss', 'PhoneNumber' => '0731234572'],
            ['Streetname' => 'Industrieweg', 'Housenumber' => '156', 'Zipcode' => '5237MN', 'Place' => 'Den Bosch', 'PhoneNumber' => '0731234573'],
            ['Streetname' => 'Marktplein', 'Housenumber' => '9', 'Zipcode' => '5238OP', 'Place' => 'Maaskantje', 'PhoneNumber' => '0731234574'],
        ];

        foreach ($contacts as $contact) {
            $contactIds[] = DB::table('Contact')->insertGetId(array_merge($contact, [
                'IsActive' => 1,
                'Created_at' => now(),
                'Updated_at' => now(),
            ]));
        }

        // Users aanmaken
        $userIds = [];
        $users = [
            ['name' => 'Jan de Vries', 'email' => 'jan@voedselbank.nl', 'contact_id' => $contactIds[0]],
            ['name' => 'Maria Jansen', 'email' => 'maria@voedselbank.nl', 'contact_id' => $contactIds[1]],
            ['name' => 'Piet Bakker', 'email' => 'piet@familie.nl', 'contact_id' => $contactIds[2]],
            ['name' => 'Klaas Smit', 'email' => 'klaas@familie.nl', 'contact_id' => $contactIds[3]],
            ['name' => 'Anna van der Berg', 'email' => 'anna@familie.nl', 'contact_id' => $contactIds[4]],
            ['name' => 'Henk Visser', 'email' => 'henk@leverancier.nl', 'contact_id' => $contactIds[5]],
            ['name' => 'Sophie Mulder', 'email' => 'sophie@leverancier.nl', 'contact_id' => $contactIds[6]],
            ['name' => 'Tom van Dijk', 'email' => 'tom@leverancier.nl', 'contact_id' => $contactIds[7]],
        ];

        foreach ($users as $user) {
            $userIds[] = DB::table('users')->insertGetId(array_merge($user, [
                'password' => Hash::make('wachtwoord'),
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }

        // Klanten aanmaken
        $customerIds = [];
        $customers = [
            ['User_id' => $userIds[2], 'GezinsNaam' => 'Familie Bakker', 'AmountAdults' => 2, 'AmoundChilderen' => 2, 'Amountbabies' => 0, 'Wishes' => 'Geen noten graag'],
            ['User_id' => $userIds[3], 'GezinsNaam' => 'Familie Smit', 'AmountAdults' => 1, 'AmoundChilderen' => 1, 'Amountbabies' => 1, 'Wishes' => 'Vegetarische producten'],
            ['User_id' => $userIds[4], 'GezinsNaam' => 'Familie van der Berg', 'AmountAdults' => 2, 'AmoundChilderen' => 3, 'Amountbabies' => 0, 'Wishes' => 'Halal producten'],
        ];

        foreach ($customers as $customer) {
            $customerIds[] = DB::table('Customer')->insertGetId(array_merge($customer, [
                'IsActive' => 1,
                'Created_at' => now(),
                'Updated_at' => now(),
            ]));
        }

        // Leveranciers aanmaken
        $supplierIds = [];
        $suppliers = [
            ['User_id' => $userIds[5], 'SupplierName' => 'Albert Heijn Distributie', 'ContactPersonName' => 'Henk Visser'],
            ['User_id' => $userIds[6], 'SupplierName' => 'Jumbo Groothandel', 'ContactPersonName' => 'Sophie Mulder'],
            ['User_id' => $userIds[7], 'SupplierName' => 'Lokale Bakkerij De Korenschoof', 'ContactPersonName' => 'Tom van Dijk'],
        ];

        foreach ($suppliers as $supplier) {
            $supplierIds[] = DB::table('Supplier')->insertGetId(array_merge($supplier, [
                'IsActive' => 1,
                'Created_at' => now(),
                'Updated_at' => now(),
            ]));
        }

        // Allergieën aanmaken
        $allergyIds = [];
        $allergies = [
            ['Name' => 'Noten'],
            ['Name' => 'Lactose'],
            ['Name' => 'Gluten'],
            ['Name' => 'Eieren'],
            ['Name' => 'Vis'],
            ['Name' => 'Soja'],
            ['Name' => 'Sesam'],
        ];

        foreach ($allergies as $allergy) {
            $allergyIds[] = DB::table('Allergy')->insertGetId(array_merge($allergy, [
                'IsActive' => 1,
                'Created_at' => now(),
                'Updated_at' => now(),
            ]));
        }

        // Producten aanmaken
        $productIds = [];
        $products = [
            ['Name' => 'Volkoren Brood', 'Barcode' => '8712345678901', 'Category' => 'Brood & Banket'],
            ['Name' => 'Volle Melk 1L', 'Barcode' => '8712345678902', 'Category' => 'Zuivel'],
            ['Name' => 'Bananen 1kg', 'Barcode' => '8712345678903', 'Category' => 'Fruit & Groente'],
            ['Name' => 'Spaghetti 500g', 'Barcode' => '8712345678904', 'Category' => 'Houdbaar'],
            ['Name' => 'Gehakt 500g', 'Barcode' => '8712345678905', 'Category' => 'Vlees & Vis'],
            ['Name' => 'Tomatensoep blik', 'Barcode' => '8712345678906', 'Category' => 'Conserven'],
            ['Name' => 'Appelsap 1L', 'Barcode' => '8712345678907', 'Category' => 'Dranken'],
            ['Name' => 'Kaas Belegen', 'Barcode' => '8712345678908', 'Category' => 'Zuivel'],
            ['Name' => 'Aardappelen 2kg', 'Barcode' => '8712345678909', 'Category' => 'Fruit & Groente'],
            ['Name' => 'Rijst 1kg', 'Barcode' => '8712345678910', 'Category' => 'Houdbaar'],
        ];

        foreach ($products as $product) {
            $productIds[] = DB::table('Product')->insertGetId(array_merge($product, [
                'IsActive' => 1,
                'Created_at' => now(),
                'Updated_at' => now(),
            ]));
        }

        // Allergie-Product koppelingen
        $allergyProductLinks = [
            ['Allergy_id' => $allergyIds[1], 'Product_id' => $productIds[1]], // Lactose - Melk
            ['Allergy_id' => $allergyIds[2], 'Product_id' => $productIds[0]], // Gluten - Brood
            ['Allergy_id' => $allergyIds[1], 'Product_id' => $productIds[7]], // Lactose - Kaas
            ['Allergy_id' => $allergyIds[2], 'Product_id' => $productIds[3]], // Gluten - Spaghetti
        ];

        foreach ($allergyProductLinks as $link) {
            DB::table('Allergy_Product')->insert(array_merge($link, [
                'IsActive' => 1,
                'Created_at' => now(),
                'Updated_at' => now(),
            ]));
        }

        // Leveringen aanmaken
        $shipments = [
            ['Supplier_id' => $supplierIds[0], 'Product_id' => $productIds[0], 'Amount' => 50, 'DateDelivery' => '2025-06-20'],
            ['Supplier_id' => $supplierIds[0], 'Product_id' => $productIds[1], 'Amount' => 30, 'DateDelivery' => '2025-06-21'],
            ['Supplier_id' => $supplierIds[1], 'Product_id' => $productIds[2], 'Amount' => 25, 'DateDelivery' => '2025-06-22'],
            ['Supplier_id' => $supplierIds[1], 'Product_id' => $productIds[3], 'Amount' => 40, 'DateDelivery' => '2025-06-23'],
            ['Supplier_id' => $supplierIds[2], 'Product_id' => $productIds[0], 'Amount' => 20, 'DateDelivery' => '2025-06-24'],
            ['Supplier_id' => $supplierIds[0], 'Product_id' => $productIds[4], 'Amount' => 15, 'DateDelivery' => '2025-06-25'],
        ];

        foreach ($shipments as $shipment) {
            DB::table('Shipment')->insert(array_merge($shipment, [
                'IsActive' => 1,
                'Created_at' => now(),
                'Updated_at' => now(),
            ]));
        }

        // Voorraad aanmaken
        $storage = [
            ['Product_id' => $productIds[0], 'Amount' => 45], // Brood
            ['Product_id' => $productIds[1], 'Amount' => 28], // Melk
            ['Product_id' => $productIds[2], 'Amount' => 22], // Bananen
            ['Product_id' => $productIds[3], 'Amount' => 38], // Spaghetti
            ['Product_id' => $productIds[4], 'Amount' => 12], // Gehakt
            ['Product_id' => $productIds[5], 'Amount' => 35], // Tomatensoep
            ['Product_id' => $productIds[6], 'Amount' => 20], // Appelsap
            ['Product_id' => $productIds[7], 'Amount' => 18], // Kaas
            ['Product_id' => $productIds[8], 'Amount' => 30], // Aardappelen
            ['Product_id' => $productIds[9], 'Amount' => 25], // Rijst
        ];

        foreach ($storage as $stock) {
            DB::table('Storage')->insert(array_merge($stock, [
                'IsActive' => 1,
                'Created_at' => now(),
                'Updated_at' => now(),
            ]));
        }

        // Voedselpakketten aanmaken
        $foodPackageIds = [];
        $foodPackages = [
            ['Customer_id' => $customerIds[0], 'PackageNumber' => 'VP-2025-001', 'DateOfCreation' => '2025-06-26', 'DateOfDispatch' => '2025-06-27'],
            ['Customer_id' => $customerIds[1], 'PackageNumber' => 'VP-2025-002', 'DateOfCreation' => '2025-06-26', 'DateOfDispatch' => '2025-06-28'],
            ['Customer_id' => $customerIds[2], 'PackageNumber' => 'VP-2025-003', 'DateOfCreation' => '2025-06-27', 'DateOfDispatch' => '2025-06-29'],
        ];

        foreach ($foodPackages as $package) {
            $foodPackageIds[] = DB::table('FoodPackage')->insertGetId(array_merge($package, [
                'IsActive' => 1,
                'Created_at' => now(),
                'Updated_at' => now(),
            ]));
        }

        // Product-Voedselpakket koppelingen
        $productFoodPackageLinks = [
            // Pakket 1 - Familie Bakker
            ['FoodPackage_id' => $foodPackageIds[0], 'Product_id' => $productIds[0]], // Brood
            ['FoodPackage_id' => $foodPackageIds[0], 'Product_id' => $productIds[1]], // Melk
            ['FoodPackage_id' => $foodPackageIds[0], 'Product_id' => $productIds[2]], // Bananen
            ['FoodPackage_id' => $foodPackageIds[0], 'Product_id' => $productIds[3]], // Spaghetti
            ['FoodPackage_id' => $foodPackageIds[0], 'Product_id' => $productIds[8]], // Aardappelen
            
            // Pakket 2 - Familie Smit (vegetarisch)
            ['FoodPackage_id' => $foodPackageIds[1], 'Product_id' => $productIds[0]], // Brood
            ['FoodPackage_id' => $foodPackageIds[1], 'Product_id' => $productIds[1]], // Melk
            ['FoodPackage_id' => $foodPackageIds[1], 'Product_id' => $productIds[2]], // Bananen
            ['FoodPackage_id' => $foodPackageIds[1], 'Product_id' => $productIds[5]], // Tomatensoep
            ['FoodPackage_id' => $foodPackageIds[1], 'Product_id' => $productIds[9]], // Rijst
            
            // Pakket 3 - Familie van der Berg
            ['FoodPackage_id' => $foodPackageIds[2], 'Product_id' => $productIds[0]], // Brood
            ['FoodPackage_id' => $foodPackageIds[2], 'Product_id' => $productIds[6]], // Appelsap
            ['FoodPackage_id' => $foodPackageIds[2], 'Product_id' => $productIds[2]], // Bananen
            ['FoodPackage_id' => $foodPackageIds[2], 'Product_id' => $productIds[3]], // Spaghetti
            ['FoodPackage_id' => $foodPackageIds[2], 'Product_id' => $productIds[8]], // Aardappelen
        ];

        foreach ($productFoodPackageLinks as $link) {
            DB::table('Product_FoodPackage')->insert(array_merge($link, [
                'IsActive' => 1,
                'Created_at' => now(),
                'Updated_at' => now(),
            ]));
        }

        // Admin gebruiker aanmaken
        User::factory()->create([
            'name' => 'Voedselbank Beheerder',
            'email' => 'admin@voedselbank-maaskantje.nl',
            'password' => Hash::make('wachtwoord'),
            'contact_id' => $contactIds[0],
        ]);
        User::factory()->create([
            'name' => 'Voedselbank Beheerder',
            'email' => 'test@example.com',
            'password' => Hash::make('cookie123'),
            'contact_id' => $contactIds[0],
        ]);
    }
}
