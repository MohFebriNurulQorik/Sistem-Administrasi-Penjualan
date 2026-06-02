<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quotation_items', function (Blueprint $table) {

            $table->id();

            // relasi ke quotation
            $table->foreignId('quotation_id')
                ->constrained()
                ->onDelete('cascade');

            $table->enum('type', ['Hardware', 'Software', 'Service', 'Other']);

            $table->string('part_number')->nullable();
            $table->text('description');
            $table->integer('qty');
            $table->string('uom')->nullable();
            $table->decimal('price', 15, 2);
            $table->integer('discount_percent')->default(0);
            $table->decimal('amount', 15, 2);
            $table->decimal('total', 15, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quotation_items');
    }
};