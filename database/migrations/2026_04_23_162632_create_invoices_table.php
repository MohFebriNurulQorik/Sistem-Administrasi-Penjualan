<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {

            $table->id();
            $table->string('invoice_number')->unique();
            $table->foreignId('customer_id')
                ->constrained()
                ->onDelete('cascade');
            $table->foreignId('quotation_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();
            $table->string('po_number')->nullable();
            $table->string('so_number')->nullable();
            $table->string('terms')->nullable();
            $table->date('due_date')->nullable();
            $table->string('currency')->default('IDR');
            $table->decimal('subtotal', 15, 2)->default(0);
            $table->decimal('vat', 15, 2)->default(0);
            $table->decimal('total_amount', 15, 2)->default(0);
            $table->text('amount_in_words')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('bank_account_name')->nullable();
            $table->string('bank_account_number')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};