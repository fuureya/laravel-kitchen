<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        // UOM Table
        Schema::create('uoms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('insert_by');
            $table->timestamp('insert_time');
            $table->string('last_update_by')->nullable();
            $table->timestamp('last_update_time')->nullable();
            $table->timestamps();
        });

        // Category Table
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('insert_by');
            $table->timestamp('insert_time');
            $table->string('last_update_by')->nullable();
            $table->timestamp('last_update_time')->nullable();
            $table->timestamps();
        });

        // Supplier Table
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('pic');
            $table->string('phone');
            $table->string('street');
            $table->string('city');
            $table->string('country');
            $table->string('email');
            $table->decimal('ap_limit', 15, 2);
            $table->string('insert_by');
            $table->timestamp('insert_date');
            $table->string('last_update_by')->nullable();
            $table->timestamp('last_update_time')->nullable();
            $table->timestamps();
        });

        // Barang Inventory Table
        Schema::create('barang_inventory', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('category_id')->references('id')->on('categories');
            $table->foreignId('uom_code')->references('id')->on('uoms');
            $table->decimal('price', 15, 2);
            $table->integer('stock_minimum');
            $table->string('insert_by');
            $table->timestamp('insert_date');
            $table->enum('status', ['active', 'nonactive']);
            $table->string('last_update_by')->nullable();
            $table->timestamp('last_update_time')->nullable();
            $table->timestamps();
        });


        Schema::create('hak_akses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('group_akses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->json('permissions');
            $table->timestamps();
        });

        // Receiving Table
        Schema::create('receiving', function (Blueprint $table) {
            $table->id();
            $table->string('receiving_id', 50)->unique()->index();
            $table->date('date');
            $table->text('remark')->nullable();
            $table->foreignId('supplier_id')->constrained('suppliers');
            $table->string('insert_by');
            $table->timestamp('insert_date');
            $table->string('last_update_by')->nullable();
            $table->timestamp('last_update_time')->nullable();
            $table->timestamps();
        });

        // Receiving Detail Table
        Schema::create('receiving_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('receiving_id', 50)->references('id')->on('receiving');
            $table->string('receiving_code', 50)->unique();
            $table->foreignId('inventory_id')->constrained('barang_inventory');
            $table->integer('qty');
            $table->decimal('price', 15, 2);
            $table->decimal('price_qty', 15, 2);
            $table->string('insert_by');
            $table->timestamp('insert_date');
            $table->string('last_update_by')->nullable();
            $table->timestamp('last_update_time')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('barang_inventory');
        Schema::dropIfExists('suppliers');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('uoms');
        Schema::dropIfExists('hak_akses');
        Schema::dropIfExists('group_akses');
    }
};
