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
        Schema::create('delivery_orders', function (Blueprint $table) {

            $table->id();

            // DO Number
            $table->string('do_number')->unique();

            // relasi customer
            $table->foreignId('customer_id')
                ->constrained()
                ->onDelete('cascade');

            // optional dari invoice
            $table->foreignId('invoice_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            // shipping address (kolom kiri di dokumen)
            $table->text('shipping_address')->nullable();

            // invoice address (kolom kanan di dokumen)
            $table->text('invoice_address')->nullable();

            // document info
            $table->date('delivery_date')->nullable(); // Date of Delivery
            $table->string('po_number')->nullable();   // PO Number
            $table->string('project')->nullable();     // Project

            // attn (penerima)
            $table->string('attn')->nullable();

            // tanda tangan
            $table->string('shipper_name')->nullable();
            $table->string('recipient_name')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_orders');
    }
};
