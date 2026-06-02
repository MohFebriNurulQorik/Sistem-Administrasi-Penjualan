<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoice_items', function (Blueprint $table) {

            $table->id();

            // relasi invoice
            $table->foreignId('invoice_id')
                ->constrained()
                ->onDelete('cascade');

            // item info
            $table->string('item_code')->nullable();
            $table->text('description');

            // harga transaksi
            $table->decimal('price', 15, 2);
            $table->integer('qty');

            // total per baris
            $table->decimal('amount', 15, 2);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoice_items');
    }
};