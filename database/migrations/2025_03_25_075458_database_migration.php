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
            $table->json('permissions')->nullable();
            $table->timestamps();
        });

        // Receiving Table
        Schema::create('receiving', function (Blueprint $table) {
            $table->id();
            $table->string('receiving_id', 50)->unique();
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
            $table->foreignId('receiving_id')->references('id')->on('receiving')->onDelete('cascade');
            $table->string('receiving_code', 50)->unique();
            $table->foreignId('inventory_id')->constrained('barang_inventory');
            $table->integer('qty');
            $table->integer('price');
            $table->integer('price_qty');
            $table->string('insert_by');
            $table->timestamp('insert_date');
            $table->string('last_update_by')->nullable();
            $table->timestamp('last_update_time')->nullable();
            $table->timestamps();
        });

        // Recipe  Table
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->longText('recipes');
            $table->timestamp('insert_time');
            $table->string('insert_by');
            $table->string('update_by')->nullable();
            $table->timestamp('last_update_time')->nullable();
            $table->timestamps();
        });

        // Recipe  Table
        Schema::create('receiving_purchase', function (Blueprint $table) {
            $table->id();
            $table->foreignId('receiving_id')->references('id')->on('receiving')->on('receiving')->onDelete('cascade');;
            $table->string('receiving_code');
            $table->string('name');
            $table->string('payment_name')->nullable();
            $table->integer('total');
            $table->enum('purchase', ['kredit', 'debit']);
            $table->enum('status', ['lunas', 'belum lunas']);
            $table->timestamp('insert_time');
            $table->string('insert_by');
            $table->timestamps();
        });

        // payment Table
        Schema::create('payment', function (Blueprint $table) {
            $table->id();
            $table->string('payment_name');
            $table->timestamp('insert_time');
            $table->string('insert_by');
            $table->timestamps();
        });

        // products
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->integer('price');
            $table->string('insert_by')->nullable();
            $table->timestamp('insert_date')->nullable();
            $table->string('last_update_by')->nullable();
            $table->timestamp('last_update_time')->nullable();
            $table->timestamps();
        });

        // sales table
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('suppliers_id');
            $table->text('remark')->nullable();
            $table->date('date');
            $table->enum('void_status', ['N', 'Y'])->default('N');
            $table->string('insert_by')->nullable();
            $table->timestamp('insert_date')->nullable();
            $table->string('last_update_by')->nullable();
            $table->timestamp('last_update_time')->nullable();

            $table->foreign('suppliers_id')->references('id')->on('suppliers')->onDelete('cascade');
            $table->timestamps();
        });

        // sales detail
        Schema::create('sales_detail', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sales_id');
            $table->unsignedBigInteger('sales_product_id');
            $table->integer('qty');
            $table->decimal('price', 15, 2);
            $table->timestamp('insert_date')->nullable();
            $table->string('insert_by')->nullable();
            $table->foreign('sales_id')->references('id')->on('sales')->onDelete('cascade');
            $table->foreign('sales_product_id')->references('id')->on('products')->onDelete('cascade');
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
        Schema::dropIfExists('receiving');
        Schema::dropIfExists('receciving_detail');
        Schema::dropIfExists('receiving_purchase');
        Schema::dropIfExists('recipes');
        Schema::dropIfExists('payment');
        Schema::dropIfExists('products');
        Schema::dropIfExists('sales');
        Schema::dropIfExists('sales_detail');
    }
};
