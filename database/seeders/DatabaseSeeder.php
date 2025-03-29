<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seeder untuk tabel UOM
        DB::table('uoms')->insert([
            ['name' => 'Kilogram', 'insert_by' => 'Admin', 'insert_time' => now()],
            ['name' => 'Liter', 'insert_by' => 'Admin', 'insert_time' => now()],
            ['name' => 'Meter', 'insert_by' => 'Admin', 'insert_time' => now()],
            ['name' => 'Pcs', 'insert_by' => 'Admin', 'insert_time' => now()],
        ]);

        // Seeder untuk tabel Categories
        DB::table('categories')->insert([
            ['name' => 'Elektronik', 'insert_by' => 'Admin', 'insert_time' => now()],
            ['name' => 'Makanan', 'insert_by' => 'Admin', 'insert_time' => now()],
            ['name' => 'Pakaian', 'insert_by' => 'Admin', 'insert_time' => now()],
        ]);

        // Seeder untuk tabel Suppliers
        DB::table('suppliers')->insert([
            ['name' => 'PT Sumber Makmur', 'pic' => 'Budi Santoso', 'phone' => '08123456789', 'street' => 'Jl. Sudirman No. 1', 'city' => 'Jakarta', 'country' => 'Indonesia', 'email' => 'supplier1@example.com', 'ap_limit' => 50000000, 'insert_by' => 'Admin', 'insert_date' => now()],
            ['name' => 'CV Maju Jaya', 'pic' => 'Tono Wijaya', 'phone' => '08129876543', 'street' => 'Jl. Merdeka No. 10', 'city' => 'Bandung', 'country' => 'Indonesia', 'email' => 'supplier2@example.com', 'ap_limit' => 30000000, 'insert_by' => 'Admin', 'insert_date' => now()],
        ]);

        // Seeder untuk tabel Barang Inventory
        DB::table('barang_inventory')->insert([
            ['name' => 'Laptop Asus ROG', 'category_id' => 1, 'uom_code' => 4, 'price' => 15000000, 'stock_minimum' => 5, 'insert_by' => 'Admin', 'insert_date' => now(), 'status' => 'active'],
            ['name' => 'Beras Premium', 'category_id' => 2, 'uom_code' => 1, 'price' => 12000, 'stock_minimum' => 100, 'insert_by' => 'Admin', 'insert_date' => now(), 'status' => 'active'],
            ['name' => 'Kaos Polos', 'category_id' => 3, 'uom_code' => 4, 'price' => 50000, 'stock_minimum' => 20, 'insert_by' => 'Admin', 'insert_date' => now(), 'status' => 'active'],
        ]);

        DB::table('users')->insert([
            'name' => 'Less Paul',
            'username' => 'administrator',
            'password' => bcrypt('administrator'),
            'group' => 'laguna group',

        ]);
    }
}
