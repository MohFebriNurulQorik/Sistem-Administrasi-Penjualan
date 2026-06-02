<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <style>
        html,
         body {
            margin: 0;
            padding: 209px 0 123px 0;
        }

        @page {
            margin: 120px 40px 50px 40px;
        }

        header {
            position: fixed;
            top: 0px;
            left: 0;
            right: 0;
            height: 200px;
            text-align: center;
        }


        footer {
            position: fixed;
            bottom: 0px;
            left: 0;
            right: 0;
            height: 123px;
            text-align: center;
        }

        .content {
            margin: 0 40px;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #000;
            line-height: 1.4;
        }

       
        .header-logo img {
            width: 100%;
            height: auto;
        }

        .footer-logo img {
            width: 100%;
            height: auto;
        }

        .date-right {
            text-align: right;
            margin-bottom: 20px;
        }

          /* Perbaikan Gaya Judul */
        .title-container {
            text-align: center;
            margin-bottom: 25px;
            padding-bottom: 0px;
        }

        .main-title {
            font-size: 60px;
            font-weight: bold;
            color: #000;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin: 0;
        }

        .sub-title {
            font-size: 13px;
            color: #444;
            margin: 5px 0 0 0;
            font-weight: normal;
        }

        .info-container {
            width: 100%;
            margin-bottom: 15px;
        }

        .info-container td {
            vertical-align: top;
            padding: 1px 5px;
        }

      .item-table {
            width: 100%;
            margin-bottom: 0; /* Ubah ke 0 agar menyatu dengan kotak terbilang di bawahnya */
            border-collapse: collapse;
        }

        .item-table th,
        .item-table td {
            border: 1px solid #000;
            padding: 8px;
        }

        .item-table th {
            font-weight: bold;
            text-transform: uppercase;
            background-color: #EDEBE0; /* Warna abu-abu header sesuai gambar */
            text-align: center;
        }

        .summary-table {
            float: right;
            width: 45%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .summary-table td {
            border: 1px solid #000;
            padding: 4px 8px;
        }

        .bg-grey {
            background-color: #e2e8f0;
            font-weight: bold;
        }

        .sig-section {
            margin-top: 30px;
        }

        .sig-name {
            font-weight: bold;
            text-decoration: underline;
        }
        .text-black {
            color: #000;
            font-weight: bold;
        }


        .content2 {
            position: fixed; /* Ini kuncinya agar muncul di tiap halaman */
            top: 60px;       /* Sesuaikan agar pas di area header yang kosong */
            right: 45px;
            width: 700px;
            z-index: 1000;
        }

        .data-container {
            text-align: right;
            margin-top: 35px;
        }

        /* Update Warna Header Tabel & Label */
        .label-grey { 
            background-color: #EDEBE0; /* Warna baru sesuai request */
            font-weight: bold; 
            font-size: 11px; 
            border-bottom: 1px solid #000; 
            display: block; 
            margin: -5px -5px 5px -5px; 
            padding: 5px; 
            text-transform: uppercase;
        }

        .item-table th { 
            border: 1px solid #000; 
            padding: 8px; 
            background-color: #EDEBE0; /* Warna baru sesuai request */
            font-weight: bold; 
            text-align: center; 
        }

        /* Untuk background di kolom Document Info */
        .bg-header-info {
            background-color: #EDEBE0;
            font-weight: bold;
        }


    </style>
</head>

<body>

    <header class="header-logo">
        <img src="{{ public_path('images/pdf/Header Midzutech.png') }}">
    </header>

    <footer class="footer-logo">
        <img src="{{ public_path('images/pdf/Footer Midzutech.png') }}">
    </footer>
    
    <div class="content2">
            <h1 class="data-container main-title">Invoice</h1>
    </div>

    <div class="content">


        <!-- INFO -->
      <table style="width:100%; border-collapse: collapse; border: 1px solid #000; padding-top:25px">
            <thead>
                <tr style="background-color: #EDEBE0; font-weight: bold;">
                    <td style="width: 33%; border: 1px solid #000; padding: 1px 5px;">Customer</td>
                    <td style="width: 33%; border: 1px solid #000; padding: 1px 5px;" colspan="2">Ship To</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <!-- Kolom Customer -->
                    <td style="width: 33%; border: 1px solid #000; padding: 1px 5px; vertical-align: top;">
                        <strong>{{ $invoice->customer->company_name }}</strong><br>
                        {{ $invoice->customer->address }}<br>
                        Telp. {{ $invoice->customer->phone }}<br>
                        Attn. {{ $invoice->customer->attn }}
                    </td>
                    
                    <!-- Kolom Ship To -->
                    <td style="width: 33%; border: 1px solid #000; padding: 1px 5px; vertical-align: top;">
                        <strong>{{ $invoice->customerInvoice->company_name }}</strong><br>
                        {{ $invoice->customerInvoice->address }}<br>
                        Telp. {{ $invoice->customerInvoice->phone }}<br>
                        Attn. {{ $invoice->customerInvoice->attn }}
                    </td>

                    <!-- Kolom Document Info (Tanpa Padding agar tabel dalam nempel) -->
                    <td style="width: 34%; border: 1px solid #000; padding: 0; vertical-align: top;">
                        <table style="width: 100%; border-collapse: collapse; margin: -1px;">
                            <tr>
                                <td style="border-bottom: 1px solid #000; border-right: 1px solid #000; padding: 4px 6px;  width: 40%;">INV Number</td>
                                <td style="border-bottom: 1px solid #000; padding: 4px 6px;">: {{ $invoice->invoice_number }}</td>
                            </tr>
                            <tr>
                                <td style="border-bottom: 1px solid #000; border-right: 1px solid #000; padding: 4px 6px; ">PO Number</td>
                                <td style="border-bottom: 1px solid #000; padding: 4px 6px;">: {{ $invoice->po_number ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td style="border-bottom: 1px solid #000; border-right: 1px solid #000; padding: 4px 6px; ">SO Number</td>
                                <td style="border-bottom: 1px solid #000; padding: 4px 6px;">: {{ $invoice->so_number ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td style="border-bottom: 1px solid #000; border-right: 1px solid #000; padding: 4px 6px; ">Terms</td>
                                <td style="border-bottom: 1px solid #000; padding: 4px 6px;">: 30 Days</td>
                            </tr>
                            <tr>
                                <td style="border-bottom: 1px solid #000; border-right: 1px solid #000; padding: 4px 6px; ">Due Date</td>
                                <td style="border-bottom: 1px solid #000; padding: 4px 6px;">: {{ $invoice->due_date ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td style="border-right: 1px solid #000; padding: 4px 6px; ">Currency</td>
                                <td style="padding: 4px 6px;">: IDR (Rp)</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>

    <table style="width: 100%; border-collapse: collapse; border: 1px solid #000;padding-top:30px">
        <thead>
            <tr style="background-color: #A6A6A6; font-weight: bold; text-align: center;">
                <th style="width: 5%; border: 1px solid #000; padding: 1px 5px;">No.</th>
                <th style="width: 50%; border: 1px solid #000; padding: 1px 5px;">Description of Goods/Services</th>
                <th style="width: 15%; border: 1px solid #000; padding: 1px 5px;">Price (IDR)</th>
                <th style="width: 5%; border: 1px solid #000; padding: 1px 5px;">Qty</th>
                <th style="width: 25%; border: 1px solid #000; padding: 1px 5px;">Amount (IDR)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($invoice->items as $key => $item)
            <tr>
                <td style="text-align: center; border: 1px solid #000; padding: 1px 5px;">{{ $key + 1 }}</td>
                <td style="border: 1px solid #000; padding: 1px 5px;">{{ $item->description }}</td>
                <td style="border: 1px solid #000; padding: 0;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <tr>
                            <td style="border: none; padding: 1px 5px; width: 20px;">Rp</td>
                            <td style="border: none; padding: 1px 5px; text-align: right;">{{ number_format($item->price, 0, ',', '.') }}</td>
                        </tr>
                    </table>
                </td>
                <td style="text-align: center; border: 1px solid #000; padding: 1px 5px;">{{ $item->qty }}</td>
                <td style="border: 1px solid #000; padding: 0;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <tr>
                            <td style="border: none; padding: 1px 5px; width: 20px;">Rp</td>
                            <td style="border: none; padding: 1px 5px; text-align: right;">{{ number_format($item->amount, 0, ',', '.') }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
            @endforeach

            <!-- Ringkasan Total -->
            <tr>
                <td colspan="4" style="border: 1px solid #000; padding: 1px 5px; text-align: right; font-weight: bold;">SUB TOTAL</td>
                <td style="border: 1px solid #000; padding: 0;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <tr>
                            <td style="border: none; padding: 1px 5px; width: 20px;">Rp</td>
                            <td style="border: none; padding: 1px 5px; text-align: right;">{{ number_format($invoice->subtotal, 0, ',', '.') }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="4" style="border: 1px solid #000; padding: 1px 5px; text-align: right; font-weight: bold;">VAT</td>
                <td style="border: 1px solid #000; padding: 0;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <tr>
                            <td style="border: none; padding: 1px 5px; width: 20px;">Rp</td>
                            <td style="border: none; padding: 1px 5px; text-align: right;">{{ number_format($invoice->vat_amount, 0, ',', '.') }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="4" style="border: 1px solid #000; padding: 1px 5px; text-align: right; font-weight: bold;">TOTAL AMOUNT</td>
                <td style="border: 1px solid #000; padding: 0;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <tr>
                            <td style="border: none; padding: 1px 5px; width: 20px;">Rp</td>
                            <td style="border: none; padding: 1px 5px; text-align: right;">{{ number_format($invoice->total_amount, 0, ',', '.') }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="4" style="border: 1px solid #000; padding: 1px 5px; text-align: right; font-weight: bold;">TOTAL INVOICE</td>
                <td style="border: 1px solid #000; padding: 0; font-weight: bold;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <tr>
                            <td style="border: none; padding: 1px 5px; width: 20px;">Rp</td>
                            <td style="border: none; padding: 1px 5px; text-align: right;">{{ number_format($invoice->total_amount, 0, ',', '.') }}</td>
                        </tr>
                    </table>
                </td>
            </tr>

            <!-- Bagian Terbilang -->
            <tr>
                <td colspan="5" style="border: 1px solid #000; padding: 0;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <tr>
                            <td style="width: 12%; padding: 1px 5px; font-weight: normal;">Terbilang</td>
                            <td style="padding: 1px 5px;">: {{ \App\Helpers\Terbilang::terbilang_id($invoice->total_amount) }} Rupiah</td>
                        </tr>
                        <tr>
                            <td style="padding: 1px 5px; border-top: 1px solid #000;">Says</td>
                            <td style="padding: 1px 5px; border-top: 1px solid #000;">: {{ \App\Helpers\Terbilang::terbilang_en($invoice->total_amount) }} Rupiah</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>



        <div style="clear: both;"></div>

        <div style="padding-top:15px">
        Please transfer to this Bank Account :<br>
                    <strong>PT. Mizu Teknologi Indonesia</strong><br>
                    Bank BNI KCP Universitas Indonesia<br>
                    Account Number : 0647056549
        </div>

        @if($invoice->terms)
        <div style="margin-top: 20px; font-size: 10px;">
            {!! $invoice->terms !!}
        </div>
        @endif
        
        <!-- FOOTER AREA: BANK INFO & SIGNATURE -->
        <table style="width: 100%; margin-top: 10px; border-collapse: collapse; border: none;">
            <tr>
                <!-- Kolom Kiri: Informasi Bank -->
                <td style="width: 50%; vertical-align: top; border: none; line-height: 1.5;">
                    
                </td>

                <!-- Kolom Kanan: Tanggal & Tanda Tangan -->
                <td style="width: 50%; vertical-align: top; text-align: right; border: none;">
                    <div style="margin-bottom: 120px; padding-right:45px">
                        Jakarta, {{ \Carbon\Carbon::parse($invoice->print_date)->format('F j') }}<sup>{{ \Carbon\Carbon::parse($invoice->print_date)->format('S') }}</sup>, {{ \Carbon\Carbon::parse($invoice->print_date)->format('Y') }}
                    </div>
                    <div style="padding-right: 90px;">
                        <strong>{{ Auth::user()->name }}</strong>
                    </div>
                </td>
            </tr>
        </table>

        <!-- TERMS (Jika Ada) -->
        


      

    </div>

</body>

</html>
