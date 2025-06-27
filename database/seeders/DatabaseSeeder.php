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
        // Contacts gegevens
        $ContactsIds = [];
        $Contactss = [
            ['Streetname' => 'Hoofdstraat', 'Housenumber' => '12', 'Zipcode' => '5231AB', 'Place' => 'Den Bosch', 'PhoneNumber' => '0731234567'],
            ['Streetname' => 'Kerkstraat', 'Housenumber' => '45', 'Zipcode' => '5232CD', 'Place' => 'Den Bosch', 'PhoneNumber' => '0731234568'],
            ['Streetname' => 'Dorpsplein', 'Housenumber' => '8', 'Zipcode' => '5233EF', 'Place' => 'Maaskantje', 'PhoneNumber' => '0731234569'],
            ['Streetname' => 'Schoolstraat', 'Housenumber' => '23', 'Zipcode' => '5234GH', 'Place' => 'Maaskantje', 'PhoneNumber' => '0731234570'],
            ['Streetname' => 'Molenweg', 'Housenumber' => '67', 'Zipcode' => '5235IJ', 'Place' => 'Oss', 'PhoneNumber' => '0731234571'],
            ['Streetname' => 'Beukenlaan', 'Housenumber' => '34', 'Zipcode' => '5236KL', 'Place' => 'Oss', 'PhoneNumber' => '0731234572'],
            ['Streetname' => 'Industrieweg', 'Housenumber' => '156', 'Zipcode' => '5237MN', 'Place' => 'Den Bosch', 'PhoneNumber' => '0731234573'],
            ['Streetname' => 'Marktplein', 'Housenumber' => '9', 'Zipcode' => '5238OP', 'Place' => 'Maaskantje', 'PhoneNumber' => '0731234574'],
        ];

        foreach ($Contactss as $Contacts) {
            $ContactsIds[] = DB::table('Contacts')->insertGetId(array_merge($Contacts, [
                'IsActive' => 1,
                'Created_at' => now(),
                'Updated_at' => now(),
            ]));
        }

        // Users aanmaken
        $userIds = [];
        $users = [
            ['name' => 'Jan de Vries', 'email' => 'jan@voedselbank.nl', 'Contacts_id' => $ContactsIds[0]],
            ['name' => 'Maria Jansen', 'email' => 'maria@voedselbank.nl', 'Contacts_id' => $ContactsIds[1]],
            ['name' => 'Piet Bakker', 'email' => 'piet@familie.nl', 'Contacts_id' => $ContactsIds[2]],
            ['name' => 'Klaas Smit', 'email' => 'klaas@familie.nl', 'Contacts_id' => $ContactsIds[3]],
            ['name' => 'Anna van der Berg', 'email' => 'anna@familie.nl', 'Contacts_id' => $ContactsIds[4]],
            ['name' => 'Henk Visser', 'email' => 'henk@leverancier.nl', 'Contacts_id' => $ContactsIds[5]],
            ['name' => 'Sophie Mulder', 'email' => 'sophie@leverancier.nl', 'Contacts_id' => $ContactsIds[6]],
            ['name' => 'Tom van Dijk', 'email' => 'tom@leverancier.nl', 'Contacts_id' => $ContactsIds[7]],
        ];

        foreach ($users as $user) {
            $userIds[] = DB::table('users')->insertGetId(array_merge($user, [
                'password' => Hash::make('wachtwoord'),
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }

        // Klanten aanmaken
        $CustomersIds = [];
        $Customerss = [
            ['User_id' => $userIds[2], 'GezinsNaam' => 'Familie Bakker', 'AmountAdults' => 2, 'AmoundChilderen' => 2, 'Amountbabies' => 0, 'Wishes' => 'Geen noten graag'],
            ['User_id' => $userIds[3], 'GezinsNaam' => 'Familie Smit', 'AmountAdults' => 1, 'AmoundChilderen' => 1, 'Amountbabies' => 1, 'Wishes' => 'Vegetarische Productsen'],
            ['User_id' => $userIds[4], 'GezinsNaam' => 'Familie van der Berg', 'AmountAdults' => 2, 'AmoundChilderen' => 3, 'Amountbabies' => 0, 'Wishes' => 'Halal Productsen'],
            ['User_id' => $userIds[0], 'GezinsNaam' => 'Familie de Vries', 'AmountAdults' => 3, 'AmoundChilderen' => 1, 'Amountbabies' => 0, 'Wishes' => 'Glutenvrije producten'],
            ['User_id' => $userIds[1], 'GezinsNaam' => 'Familie Jansen', 'AmountAdults' => 2, 'AmoundChilderen' => 2, 'Amountbabies' => 1, 'Wishes' => 'Lactosevrije producten'],
        ];

        foreach ($Customerss as $Customers) {
            $CustomersIds[] = DB::table('Customers')->insertGetId(array_merge($Customers, [
                'IsActive' => 1,
                'Created_at' => now(),
                'Updated_at' => now(),
            ]));
        }

        // Leveranciers aanmaken
        $SuppliersIds = [];
        $Supplierss = [
            ['User_id' => $userIds[5], 'SuppliersName' => 'Albert Heijn Distributie', 'ContactsPersonName' => 'Henk Visser'],
            ['User_id' => $userIds[6], 'SuppliersName' => 'Jumbo Groothandel', 'ContactsPersonName' => 'Sophie Mulder'],
            ['User_id' => $userIds[7], 'SuppliersName' => 'Lokale Bakkerij De Korenschoof', 'ContactsPersonName' => 'Tom van Dijk'],
            ['User_id' => $userIds[0], 'SuppliersName' => 'Plus Distributie Center', 'ContactsPersonName' => 'Jan de Vries'],
            ['User_id' => $userIds[1], 'SuppliersName' => 'Biologische Boerderij Groen', 'ContactsPersonName' => 'Maria Jansen'],
        ];

        foreach ($Supplierss as $Suppliers) {
            $SuppliersIds[] = DB::table('Suppliers')->insertGetId(array_merge($Suppliers, [
                'IsActive' => 1,
                'Created_at' => now(),
                'Updated_at' => now(),
            ]));
        }

        // Allergieën aanmaken
        $AllergiesIds = [];
        $allergies = [
            ['Name' => 'Noten'],
            ['Name' => 'Lactose'],
            ['Name' => 'Gluten'],
            ['Name' => 'Eieren'],
            ['Name' => 'Vis'],
            ['Name' => 'Soja'],
            ['Name' => 'Sesam'],
        ];

        foreach ($allergies as $Allergies) {
            $AllergiesIds[] = DB::table('Allergies')->insertGetId(array_merge($Allergies, [
                'IsActive' => 1,
                'Created_at' => now(),
                'Updated_at' => now(),
            ]));
        }

        // Productsen aanmaken
        $ProductsIds = [];
        $Productss = [
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

        foreach ($Productss as $Products) {
            $ProductsIds[] = DB::table('Products')->insertGetId(array_merge($Products, [
                'IsActive' => 1,
                'Created_at' => now(),
                'Updated_at' => now(),
            ]));
        }

        // Allergie-Products koppelingen
        $AllergiesProductsLinks = [
            ['Allergies_id' => $AllergiesIds[1], 'Products_id' => $ProductsIds[1]], // Lactose - Melk
            ['Allergies_id' => $AllergiesIds[2], 'Products_id' => $ProductsIds[0]], // Gluten - Brood
            ['Allergies_id' => $AllergiesIds[1], 'Products_id' => $ProductsIds[7]], // Lactose - Kaas
            ['Allergies_id' => $AllergiesIds[2], 'Products_id' => $ProductsIds[3]], // Gluten - Spaghetti
            ['Allergies_id' => $AllergiesIds[3], 'Products_id' => $ProductsIds[0]], // Eieren - Brood
        ];

        foreach ($AllergiesProductsLinks as $link) {
            DB::table('Allergies_Products')->insert(array_merge($link, [
                'IsActive' => 1,
                'Created_at' => now(),
                'Updated_at' => now(),
            ]));
        }

        // Leveringen aanmaken
        $shipmentss = [
            ['Suppliers_id' => $SuppliersIds[0], 'Products_id' => $ProductsIds[0], 'Amount' => 50, 'DateDelivery' => '2025-06-20'],
            ['Suppliers_id' => $SuppliersIds[0], 'Products_id' => $ProductsIds[1], 'Amount' => 30, 'DateDelivery' => '2025-06-21'],
            ['Suppliers_id' => $SuppliersIds[1], 'Products_id' => $ProductsIds[2], 'Amount' => 25, 'DateDelivery' => '2025-06-22'],
            ['Suppliers_id' => $SuppliersIds[1], 'Products_id' => $ProductsIds[3], 'Amount' => 40, 'DateDelivery' => '2025-06-23'],
            ['Suppliers_id' => $SuppliersIds[2], 'Products_id' => $ProductsIds[0], 'Amount' => 20, 'DateDelivery' => '2025-06-24'],
            ['Suppliers_id' => $SuppliersIds[2], 'Products_id' => $ProductsIds[4], 'Amount' => 15, 'DateDelivery' => '2025-06-25'],
            ['Suppliers_id' => $SuppliersIds[3], 'Products_id' => $ProductsIds[5], 'Amount' => 35, 'DateDelivery' => '2025-06-26'],
            ['Suppliers_id' => $SuppliersIds[4], 'Products_id' => $ProductsIds[2], 'Amount' => 45, 'DateDelivery' => '2025-06-27'],
        ];

        foreach ($shipmentss as $shipments) {
            DB::table('shipments')->insert(array_merge($shipments, [
                'IsActive' => 1,
                'Created_at' => now(),
                'Updated_at' => now(),
            ]));
        }

        // Voorraad aanmaken
        $storage = [
            ['Products_id' => $ProductsIds[0], 'Amount' => 45], // Brood
            ['Products_id' => $ProductsIds[1], 'Amount' => 28], // Melk
            ['Products_id' => $ProductsIds[2], 'Amount' => 22], // Bananen
            ['Products_id' => $ProductsIds[3], 'Amount' => 38], // Spaghetti
            ['Products_id' => $ProductsIds[4], 'Amount' => 12], // Gehakt
            ['Products_id' => $ProductsIds[5], 'Amount' => 35], // Tomatensoep
            ['Products_id' => $ProductsIds[6], 'Amount' => 20], // Appelsap
            ['Products_id' => $ProductsIds[7], 'Amount' => 18], // Kaas
            ['Products_id' => $ProductsIds[8], 'Amount' => 30], // Aardappelen
            ['Products_id' => $ProductsIds[9], 'Amount' => 25], // Rijst
        ];

        foreach ($storage as $stock) {
            DB::table('Storage')->insert(array_merge($stock, [
                'IsActive' => 1,
                'Created_at' => now(),
                'Updated_at' => now(),
            ]));
        }

        // Voedselpakketten aanmaken
        $FoodPackagesIds = [];
        $FoodPackagess = [
            ['Customers_id' => $CustomersIds[0], 'PackageNumber' => 'VP-2025-001', 'DateOfCreation' => '2025-06-26', 'DateOfDispatch' => '2025-06-27'],
            ['Customers_id' => $CustomersIds[1], 'PackageNumber' => 'VP-2025-002', 'DateOfCreation' => '2025-06-26', 'DateOfDispatch' => '2025-06-28'],
            ['Customers_id' => $CustomersIds[2], 'PackageNumber' => 'VP-2025-003', 'DateOfCreation' => '2025-06-27', 'DateOfDispatch' => '2025-06-29'],
            ['Customers_id' => $CustomersIds[3], 'PackageNumber' => 'VP-2025-004', 'DateOfCreation' => '2025-06-28', 'DateOfDispatch' => '2025-06-30'],
            ['Customers_id' => $CustomersIds[4], 'PackageNumber' => 'VP-2025-005', 'DateOfCreation' => '2025-06-29', 'DateOfDispatch' => '2025-07-01'],
        ];

        foreach ($FoodPackagess as $package) {
            $FoodPackagesIds[] = DB::table('FoodPackages')->insertGetId(array_merge($package, [
                'IsActive' => 1,
                'Created_at' => now(),
                'Updated_at' => now(),
            ]));
        }

        // Products-Voedselpakket koppelingen
        $ProductsFoodPackagesLinks = [
            // Pakket 1 - Familie Bakker
            ['FoodPackages_id' => $FoodPackagesIds[0], 'Products_id' => $ProductsIds[0]], // Brood
            ['FoodPackages_id' => $FoodPackagesIds[0], 'Products_id' => $ProductsIds[1]], // Melk
            ['FoodPackages_id' => $FoodPackagesIds[0], 'Products_id' => $ProductsIds[2]], // Bananen
            ['FoodPackages_id' => $FoodPackagesIds[0], 'Products_id' => $ProductsIds[3]], // Spaghetti
            ['FoodPackages_id' => $FoodPackagesIds[0], 'Products_id' => $ProductsIds[8]], // Aardappelen
            
            // Pakket 2 - Familie Smit (vegetarisch)
            ['FoodPackages_id' => $FoodPackagesIds[1], 'Products_id' => $ProductsIds[0]], // Brood
            ['FoodPackages_id' => $FoodPackagesIds[1], 'Products_id' => $ProductsIds[1]], // Melk
            ['FoodPackages_id' => $FoodPackagesIds[1], 'Products_id' => $ProductsIds[2]], // Bananen
            ['FoodPackages_id' => $FoodPackagesIds[1], 'Products_id' => $ProductsIds[5]], // Tomatensoep
            ['FoodPackages_id' => $FoodPackagesIds[1], 'Products_id' => $ProductsIds[9]], // Rijst
            
            // Pakket 3 - Familie van der Berg
            ['FoodPackages_id' => $FoodPackagesIds[2], 'Products_id' => $ProductsIds[0]], // Brood
            ['FoodPackages_id' => $FoodPackagesIds[2], 'Products_id' => $ProductsIds[6]], // Appelsap
            ['FoodPackages_id' => $FoodPackagesIds[2], 'Products_id' => $ProductsIds[2]], // Bananen
            ['FoodPackages_id' => $FoodPackagesIds[2], 'Products_id' => $ProductsIds[3]], // Spaghetti
            ['FoodPackages_id' => $FoodPackagesIds[2], 'Products_id' => $ProductsIds[8]], // Aardappelen

            // Pakket 4 - Familie de Vries (glutenvrij)
            ['FoodPackages_id' => $FoodPackagesIds[3], 'Products_id' => $ProductsIds[2]], // Bananen
            ['FoodPackages_id' => $FoodPackagesIds[3], 'Products_id' => $ProductsIds[4]], // Gehakt
            ['FoodPackages_id' => $FoodPackagesIds[3], 'Products_id' => $ProductsIds[8]], // Aardappelen
            ['FoodPackages_id' => $FoodPackagesIds[3], 'Products_id' => $ProductsIds[9]], // Rijst
            ['FoodPackages_id' => $FoodPackagesIds[3], 'Products_id' => $ProductsIds[6]], // Appelsap

            // Pakket 5 - Familie Jansen (lactosevrij)
            ['FoodPackages_id' => $FoodPackagesIds[4], 'Products_id' => $ProductsIds[0]], // Brood
            ['FoodPackages_id' => $FoodPackagesIds[4], 'Products_id' => $ProductsIds[2]], // Bananen
            ['FoodPackages_id' => $FoodPackagesIds[4], 'Products_id' => $ProductsIds[3]], // Spaghetti
            ['FoodPackages_id' => $FoodPackagesIds[4], 'Products_id' => $ProductsIds[5]], // Tomatensoep
            ['FoodPackages_id' => $FoodPackagesIds[4], 'Products_id' => $ProductsIds[9]], // Rijst
        ];

        foreach ($ProductsFoodPackagesLinks as $link) {
            DB::table('Products_FoodPackages')->insert(array_merge($link, [
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
            'Contacts_id' => $ContactsIds[0],
        ]);
        User::factory()->create([
            'name' => 'Voedselbank Beheerder',
            'email' => 'test@example.com',
            'password' => Hash::make('cookie123'),
            'Contacts_id' => $ContactsIds[0],
        ]);
    }
}
