<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        // UOM Table
        Schema::create('uoms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('insert_by');
            $table->timestamp('insert_time');
            $table->string('last_update_by')->nullable();
            $table->timestamp('last_update_time')->nullable();
        });

        // Category Table
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
              $table->string('insert_by');
            $table->timestamp('insert_time');
            $table->string('last_update_by')->nullable();
            $table->timestamp('last_update_time')->nullable();
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
            $table->string('email')->unique();
            $table->decimal('ap_limit', 15, 2);
            $table->string('insert_by');
            $table->timestamp('insert_date');
            $table->string('last_update_by')->nullable();
            $table->timestamp('last_update_time')->nullable();
        });

        // Barang Inventory Table
        Schema::create('barang_inventory', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('category_id')->constrained('categories');
            $table->foreignId('uom_code')->constrained('uoms');
            $table->decimal('price', 15, 2);
            $table->integer('stock_minimum');
            $table->string('insert_by');
            $table->timestamp('insert_date');
            $table->enum('status', ['active', 'nonactive']);
            $table->string('last_update_by')->nullable();
            $table->timestamp('last_update_time')->nullable();
        });
    }

    public function down() {
        Schema::dropIfExists('barang_inventory');
        Schema::dropIfExists('suppliers');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('uoms');
    }
};
