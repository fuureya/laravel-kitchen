<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $hakAkses = [
            'view-dashboard',
            'view-uoms',
            'tambah-uoms',
            'update-uoms',
            'hapus-uoms',
            'view-category',
            'tambah-category',
            'update-category',
            'hapus-category',

            'view-inventory',
            'tambah-inventory',
            'update-inventory',
            'hapus-inventory',

            'view-suppliers',
            'tambah-suppliers',
            'update-suppliers',
            'hapus-suppliers',

            'view-receiving',
            'tambah-receiving',
            'update-receiving',
            'hapus-receiving',

            'view-recipe',
            'tambah-recipe',
            'update-recipe',
            'hapus-recipe',

            'view-hak-akses',
            'tambah-hak-akses',
            'update-hak-akses',
            'hapus-hak-akses',

            'view-atur-grup',
            'tambah-atur-grup',
            'update-atur-grup',
            'hapus-atur-grup',

            'view-atur-user',
            'tambah-atur-user',
            'update-atur-user',
            'hapus-atur-user',
        ];
        $now = Carbon::now();

        foreach ($hakAkses as $akses) {
            DB::table('hak_akses')->insert([
                'name' => $akses,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        // payment

        $payment = ['BCA', 'BRI', 'MANDIRI', 'BNI', 'CASH', 'GOPAY', 'OVO', 'DANA'];

        foreach ($payment as $pay) {
            DB::table('payment')->insert([
                'payment_name' => $pay,
                'insert_by' =>  'Admin',
                'insert_time' => Carbon::now(),
            ]);
        }

        DB::table('group_akses')->insert([
            'name' => 'Administrator',
            'permissions' => json_encode($hakAkses)
        ]);

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
            'name' => 'Marsha Lanathea Lapian',
            'username' => 'administrator',
            'password' => bcrypt('administrator'),
            'group' => 'Administrator',
            'permissions' => json_encode($hakAkses)

        ]);
        DB::table('products')->insert([
            [
                'product_name' => 'Beras Pandan Wangi 5kg',
                'price' => 75000,
                'insert_by' => 'admin',
                'insert_date' => $now,
                'last_update_by' => 'admin',
                'last_update_time' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'product_name' => 'Minyak Goreng Bimoli 2L',
                'price' => 38000,
                'insert_by' => 'admin',
                'insert_date' => $now,
                'last_update_by' => 'admin',
                'last_update_time' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'product_name' => 'Gula Pasir Gulaku 1kg',
                'price' => 14500,
                'insert_by' => 'admin',
                'insert_date' => $now,
                'last_update_by' => 'admin',
                'last_update_time' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'product_name' => 'Kopi Kapal Api Special 165g',
                'price' => 17000,
                'insert_by' => 'admin',
                'insert_date' => $now,
                'last_update_by' => 'admin',
                'last_update_time' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'product_name' => 'Indomie Goreng 1 Dus',
                'price' => 105000,
                'insert_by' => 'admin',
                'insert_date' => $now,
                'last_update_by' => 'admin',
                'last_update_time' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'product_name' => 'Teh Pucuk Harum 350ml',
                'price' => 4000,
                'insert_by' => 'admin',
                'insert_date' => $now,
                'last_update_by' => 'admin',
                'last_update_time' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'product_name' => 'Mie Sedap Soto 1 Dus',
                'price' => 98000,
                'insert_by' => 'admin',
                'insert_date' => $now,
                'last_update_by' => 'admin',
                'last_update_time' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'product_name' => 'Sabun Lifebuoy Merah 85g',
                'price' => 3500,
                'insert_by' => 'admin',
                'insert_date' => $now,
                'last_update_by' => 'admin',
                'last_update_time' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'product_name' => 'Susu Indomilk Coklat 190ml',
                'price' => 5500,
                'insert_by' => 'admin',
                'insert_date' => $now,
                'last_update_by' => 'admin',
                'last_update_time' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'product_name' => 'Air Mineral Aqua 600ml',
                'price' => 3500,
                'insert_by' => 'admin',
                'insert_date' => $now,
                'last_update_by' => 'admin',
                'last_update_time' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
