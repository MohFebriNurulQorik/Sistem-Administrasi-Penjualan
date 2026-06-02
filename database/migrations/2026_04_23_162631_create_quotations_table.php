<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quotations', function (Blueprint $table) {

            $table->id();
            $table->string('quotation_number')->unique();
            $table->foreignId('customer_id')
                ->constrained()
                ->onDelete('cascade');
            $table->date('valid_until')->nullable();
            $table->string('project')->nullable();
            $table->string('attn')->nullable();

            // total
            $table->decimal('subtotal', 15, 2)->default(0);
            $table->decimal('vat', 15, 2)->default(0);
            $table->decimal('grand_total', 15, 2)->default(0);

            // remark seperti di PDF kamu
            $table->text('remark')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quotations');
    }
};