<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <style>
        html,
         body {
            margin: 0;
            padding: 150px 0 60px 0;
        }

        @page {
            margin: 120px 40px 50px 40px;
        }

        header {
            position: fixed;
            top: 0px;
            left: 0;
            right: 0;
            height: 150px;
            text-align: center;
        }


        footer {
            position: fixed;
            bottom: 0px;
            left: 0;
            right: 0;
            height: 55px;
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
            font-size: 40px;
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
            padding: 1px;
        }

        .item-table {
            width: 100%;
            margin-bottom: 10px;
            border-collapse: collapse;
        }

        .item-table th,
        .item-table td {
            border: 1px solid #000;
            padding: 5px;
        }

        .item-table th {
            font-weight: bold;
            text-transform: uppercase;
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
    </style>
</head>

<body>

     <header class="header-logo">
        <img src="{{ public_path('images/pdf/Header Dwisantara.png') }}">
    </header>

    <footer class="footer-logo">
        <img src="{{ public_path('images/pdf/Footer Dwisantara.png') }}">
    </footer>

    <div class="content">

        <div class="title-container">
            <h1 class="main-title">Invoice</h1>
        </div>
        <!-- DATE -->
        <div class="date-right">
            Jakarta, {{ \Carbon\Carbon::parse($invoice->print_date)->format('F j') }}<sup>{{ \Carbon\Carbon::parse($invoice->print_date)->format('S') }}</sup> {{ \Carbon\Carbon::parse($invoice->print_date)->format('Y') }}
        </div>

        <!-- INFO -->
        <table style="width:100%; margin-bottom:20px; border-collapse: collapse;">
            <tr>
                <!-- CUSTOMER NAME -->
                <td style="width:33%; vertical-align:top;">
                    <strong>Customer Name</strong><br><br>

                    {{ $invoice->customer->company_name }}<br>
                    {{ $invoice->customer->address }}<br>
                    {{ $invoice->customer->phone }}<br>
                    Attn. {{ $invoice->customer->attn }}
                </td>

                <!-- INVOICE TO -->
                <td style="width:33%; vertical-align:top;padding: 0 15px; border-left: 1px solid #ddd;">
                    <strong>Invoice To</strong><br><br>

                    {{ $invoice->customerInvoice->company_name }}<br>
                    {{ $invoice->customerInvoice->address }}<br>
                    {{ $invoice->customerInvoice->phone }}<br>
                    Attn. {{ $invoice->customerInvoice->attn }}
                </td>

                <!-- DOCUMENT INFO -->
                <td  style="width:34%; vertical-align:top; padding: 0 15px; border-left: 1px solid #ddd;">
                    <strong>Document Information</strong><br><br>

                    INV Number : {{ $invoice->invoice_number }}<br>
                    {{-- PO Number : {{ $invoice->po_number ?? '-' }}<br> --}}
                    SO Number : {{ $invoice->so_number ?? '-' }}<br>
                    Due Date : {{ $invoice->due_date }}
                </td>
            </tr>
        </table>

        <p>Please find the invoice details below:</p>

        <!-- ITEMS -->
        <table class="item-table">
            <thead>
                <tr>
                    <th style="width: 15%;">Item Code</th>
                    <th>Description</th>
                    <th style="width: 8%;">Qty</th>
                    <th style="width: 10%;">UOM</th>
                    <th style="width: 18%;">Price</th>
                    <th style="width: 18%;">Amount</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($invoice->items as $item)
                    <tr>
                        <td style="text-align: center;">
                            {{ $item->item_code }}
                        </td>
                        <td>
                            {{ $item->description }}
                        </td>
                        <td style="text-align: center;">
                            {{ $item->qty }}
                        </td>
                        <td style="text-align: center;">
                            {{ $item->uom }}
                        </td>
                        <td style="text-align: right;">
                            Rp {{ number_format($item->price, 0, ',', '.') }}
                        </td>
                        <td style="text-align: right;">
                            Rp {{ number_format($item->amount, 0, ',', '.') }}
                        </td>
                    </tr>
                @endforeach

                <tr class="bg-grey">
                    <td colspan="5" style="text-align: right;">TOTAL</td>
                    <td style="text-align: right;">
                        Rp {{ number_format($invoice->subtotal, 0, ',', '.') }}
                    </td>
                </tr>
            </tbody>
        </table>
        <!-- SUMMARY -->
        <table class="summary-table">
            <tr>
                <td class="bg-grey">TOTAL SUB PRICE</td>
                <td style="text-align: right; font-weight: bold;">
                    Rp {{ number_format($invoice->subtotal, 0, ',', '.') }}
                </td>
            </tr>
            <tr>
                <td class="bg-grey">VAT</td>
                <td style="text-align: right;">
                    Rp {{ number_format($invoice->vat_amount, 0, ',', '.') }}
                </td>
            </tr>
            <tr>
                <td class="bg-grey">GRAND TOTAL</td>
                <td style="text-align: right; font-weight: bold; background-color: #cbd5e1;">
                    Rp {{ number_format($invoice->total_amount, 0, ',', '.') }}
                </td>
            </tr>
            
        </table>
        <table style="width:100%; margin-top: 80px; font-size: 14px; border-collapse: collapse;">
            <tr >
                <td style="width:20%;text-align: left;">
                    <br>
                    Terbilang
                </td>
                <td >
                <br>
                   : {{\App\Helpers\Terbilang::terbilang_id($invoice->total_amount) }}
                </td>
            </tr>
             <tr>
                <td style="text-align: left;">
                    Says
                </td>
                <td>
                    : {{ \App\Helpers\Terbilang::terbilang_en($invoice->total_amount) }}
                </td>
            </tr>
        </table>

        <div style="clear: both;"></div>
        

        <!-- TERMS -->
        <div style="margin-top: 20px;">
            {!! $invoice->terms ?? '-' !!}
        </div>

        <!-- SIGNATURE -->

        <table >
            <tbody>
                <tr>
                    <td>
                         <div class="sig-section">
                        Best Regards,<br><br><br><br>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                          <div class="sig-section">
                            <div class="sig-name">{{Auth::user()->name}}</div>
                            PT Dwipantara Selaras Nusantara<br>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

      

    </div>

</body>

</html>
