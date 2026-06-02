<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Buat tabel tenants
        Schema::create('tenants', function (Blueprint $table) {
            $table->id();
            $table->string('name');                          // Nama perusahaan tenant
            $table->string('slug')->unique();                // subdomain/identifier unik
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->string('logo')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->date('subscription_start')->nullable();
            $table->date('subscription_end')->nullable();
            $table->timestamps();
        });

        // 2. Tambah tenant_id ke tabel users
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('tenant_id')->nullable()->after('id')
                  ->constrained('tenants')->onDelete('cascade');
        });

        // 3. Tambah tenant_id ke tabel customers
        Schema::table('customers', function (Blueprint $table) {
            $table->foreignId('tenant_id')->nullable()->after('id')
                  ->constrained('tenants')->onDelete('cascade');
        });

        // 4. Tambah tenant_id ke tabel invoices
        Schema::table('invoices', function (Blueprint $table) {
            $table->foreignId('tenant_id')->nullable()->after('id')
                  ->constrained('tenants')->onDelete('cascade');
        });

        // 5. Tambah tenant_id ke tabel quotations
        Schema::table('quotations', function (Blueprint $table) {
            $table->foreignId('tenant_id')->nullable()->after('id')
                  ->constrained('tenants')->onDelete('cascade');
        });

        // 6. Tambah tenant_id ke tabel delivery_orders
        Schema::table('delivery_orders', function (Blueprint $table) {
            $table->foreignId('tenant_id')->nullable()->after('id')
                  ->constrained('tenants')->onDelete('cascade');
        });

        // 7. Tambah tenant_id ke tabel items
        Schema::table('items', function (Blueprint $table) {
            $table->foreignId('tenant_id')->nullable()->after('id')
                  ->constrained('tenants')->onDelete('cascade');
        });

        // 8. Tambah tenant_id ke tabel projects
        Schema::table('projects', function (Blueprint $table) {
            $table->foreignId('tenant_id')->nullable()->after('id')
                  ->constrained('tenants')->onDelete('cascade');
        });

        // 9. Tambah tenant_id ke tabel template_pdfs
        Schema::table('template_pdfs', function (Blueprint $table) {
            $table->foreignId('tenant_id')->nullable()->after('id')
                  ->constrained('tenants')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        // Hapus foreign key & kolom secara terbalik
        foreach (['users', 'customers', 'invoices', 'quotations', 'delivery_orders', 'items', 'projects', 'template_pdfs'] as $tbl) {
            Schema::table($tbl, function (Blueprint $table) use ($tbl) {
                $table->dropForeign(["{$tbl}_tenant_id_foreign"]);
                $table->dropColumn('tenant_id');
            });
        }
        Schema::dropIfExists('tenants');
    }
};