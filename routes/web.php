<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\DeliveryOrderController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\TemplatePDFController;
use App\Http\Controllers\Admin\TenantController;


Route::get('/', function () {
    return view('welcome');
});


Route::middleware(['auth', 'role:superadmin'])
    ->prefix('superadmin')
    ->name('admin.')
    ->group(function () {
        Route::resource('tenants', TenantController::class);
        Route::patch('tenants/{tenant}/toggle-status', [TenantController::class, 'toggleStatus'])
            ->name('tenants.toggle-status');
        Route::post('tenants/{tenant}/assign-user', [TenantController::class, 'assignUser'])
            ->name('tenants.assign-user');
    });


Route::middleware(['auth', 'tenant'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware('verified')
        ->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //  Customers 
    Route::post('/customers/import', [CustomerController::class, 'import'])->name('customers.import');
    Route::resource('customers', CustomerController::class);

    //  Items 
    Route::post('/items/import', [ItemController::class, 'import'])->name('items.import');
    Route::resource('items', ItemController::class);

    //  Quotations 
    Route::get('/quotations/{id}/duplicate', [QuotationController::class, 'duplicate'])->name('quotations.duplicate');
    Route::get('/quotations/{id}/pdf', [QuotationController::class, 'printPdf'])->name('quotations.pdf');
    Route::get('/quotations-export', [QuotationController::class, 'exportQuotation'])->name('quotations.export');
    Route::resource('quotations', QuotationController::class);

    //  Invoices 
    Route::get('/invoices/{id}/duplicate', [InvoiceController::class, 'duplicate'])->name('invoices.duplicate');
    Route::get('/invoices/{id}/pdf', [InvoiceController::class, 'pdf'])->name('invoices.pdf');
    Route::get('/invoices-export', [InvoiceController::class, 'exportInvoice'])->name('invoices.export');
    Route::resource('invoices', InvoiceController::class);

    //  Delivery Orders 
    Route::get('delivery-orders/{id}/duplicate', [DeliveryOrderController::class, 'duplicate'])->name('delivery-orders.duplicate');
    Route::get('delivery-orders/{id}/pdf', [DeliveryOrderController::class, 'pdf'])->name('delivery-orders.pdf');
    Route::get('/delivery-orders-export', [DeliveryOrderController::class, 'export'])->name('delivery-orders.export');
    Route::resource('delivery-orders', DeliveryOrderController::class);

    //  Projects 
    Route::post('projects/import', [ProjectController::class, 'import'])->name('projects.import');
    Route::resource('projects', ProjectController::class);

    //  Positions 
    Route::post('positions/import', [PositionController::class, 'import'])->name('positions.import');
    Route::resource('positions', PositionController::class);

    //  Users 
    Route::resource('users', UserController::class);

    //  Template PDF 
    Route::get('/template-pdf/edit', [TemplatePDFController::class, 'edit'])->name('template.edit');
    Route::put('/template-pdf/update', [TemplatePDFController::class, 'update'])->name('template.update');

});

require __DIR__.'/auth.php';
