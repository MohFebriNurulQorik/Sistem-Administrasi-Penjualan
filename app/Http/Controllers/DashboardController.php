<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Quotation;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // =========================
        // BASIC KPI
        // =========================
        $totalInvoice = Invoice::count();
        $totalCustomer = Customer::count();

        $totalRevenue = Invoice::sum('total_amount');

        // Monthly revenue (bulan ini)
        $monthlyRevenue = Invoice::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total_amount');

        // Last month revenue (untuk growth)
        $lastMonthRevenue = Invoice::whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->sum('total_amount');

        // Growth %
        $revenueGrowth = $lastMonthRevenue > 0
            ? (($monthlyRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100
            : 0;

        // Yearly revenue
        $yearlyRevenue = Invoice::whereYear('created_at', now()->year)
            ->sum('total_amount');

        // =========================
        // TOP 5 CUSTOMER BY QUOTATION
        // =========================
        $topQuotationCustomers = Quotation::select(
                'customer_id',
                DB::raw('COUNT(*) as total_quotation')
            )
            ->with('customer')
            ->groupBy('customer_id')
            ->orderByDesc('total_quotation')
            ->limit(5)
            ->get();

        // =========================
        // TOP 5 CUSTOMER BY INVOICE COUNT
        // =========================
        $topInvoiceCustomers = Invoice::select(
                'customer_id',
                DB::raw('COUNT(*) as total_invoice')
            )
            ->with('customer')
            ->groupBy('customer_id')
            ->orderByDesc('total_invoice')
            ->limit(5)
            ->get();

        // =========================
        // TOP 5 CUSTOMER BY REVENUE
        // =========================
        $topRevenueCustomers = Invoice::select(
                'customer_id',
                DB::raw('SUM(total_amount) as total_revenue')
            )
            ->with('customer')
            ->groupBy('customer_id')
            ->orderByDesc('total_revenue')
            ->limit(5)
            ->get();

        // =========================
        // ACTIVE KPI
        // =========================
        $activeInvoice = Invoice::whereMonth('created_at', now()->month)->count();

        return view('dashboard', compact(
            'totalInvoice',
            'totalCustomer',
            'totalRevenue',
            'monthlyRevenue',
            'lastMonthRevenue',
            'revenueGrowth',
            'yearlyRevenue',
            'activeInvoice',
            'topQuotationCustomers',
            'topInvoiceCustomers',
            'topRevenueCustomers'
        ));
    }
}