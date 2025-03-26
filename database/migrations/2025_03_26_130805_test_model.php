<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('testdb', function (Blueprint $table) {
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
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
