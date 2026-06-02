<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <style>
        html,
        body {
            margin: 0;
            padding: 180px 0 123px 0;
        }

        @page {
            margin: 120px 40px 50px 40px;
        }

        header {
            position: fixed;
            top: 0px;
            left: 0;
            right: 0;
            height: 180px;
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
            margin: 0 45px;
        }

        /* ------------------------------------------ */

        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #000;
            line-height: 1.4;
        }

        .header-logo img {
            width: 100%;
            height: 160px;
        }

         .footer-logo img {
            width: 100%;
            height: auto;
        }

        .date-right {
            text-align: right;
            margin-bottom: 20px;
        }
        .content2 {
            position: fixed; /* Ini kuncinya agar muncul di tiap halaman */
            top: 60px;       /* Sesuaikan agar pas di area header yang kosong */
            right: 30px;
            width: 700px;
            z-index: 1000;
        }

        .data-container {
            text-align: right;
        }

        .date-right2 {
            text-align: right;
            margin-bottom: 15px;
        }

          /* Perbaikan Gaya Judul */
        .title-container {
            text-align: center;
            margin-bottom: 25px;
            padding-bottom: 10px;
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
            color: #6e6e6e;
            margin: 5px 0 0 0;
            font-weight: normal;
        }

        /* INFO LAYOUT */
        .info-container {
            width: 100%;
            margin-bottom: 15px;
        }

        .info-container td {
            vertical-align: top;
            border: none;
            padding: 1px;
        }

        /* HIGHLIGHTS SEPERTI DI GAMBAR */
        .hl-yellow {
            background-color: #ffff00;
            padding: 0 2px;
        }

        .hl-cyan {
            background-color: #00ffff;
            padding: 0 2px;
        }

        /* TABEL ITEM */
        .item-table {
            width: 100%;
            
            margin-bottom: 10px;
        }

        .item-table th {
            border: 1px solid #000;
            padding: 1px 5px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .item-table td {
            border: 1px solid #000;
            padding: 1px 5px;
        }

        .type-header {
            font-weight: bold;
            padding: 4px 10px;
            border: 1px solid #000;
            border-bottom: none;
            display: inline-block;
        }

        /* SUMMARY / TOTAL */
        .summary-table {
            float: right;
            width: 45%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .summary-table td {
            border: 1px solid #000;
            padding: 1px 5px;
        }

        .bg-grey {
            background-color: #e2e8f0;
            font-weight: bold;
        }

        /* SIGNATURE */
        .sig-section {
            margin-top: 30px;
            page-break-inside: avoid;
        }

        .sig-name {
            font-weight: bold;
            text-decoration: underline;
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
        <div class="data-container">
           <div class="date-right2">
                    Jakarta, {{ \Carbon\Carbon::parse($quotation->print_date)->format('F j') }}<sup>{{ \Carbon\Carbon::parse($quotation->print_date)->format('S') }}</sup> {{ \Carbon\Carbon::parse($quotation->print_date)->format('Y') }}
            </div>
            <table class="info-container">
                
                <tr>
                    <td style="width: 62%;">
                        
                    </td>
                    <td style="width: 18%;">         
                           
                        Quotation #<br>
                        Valid Until<br>
                        Project
                    </td>
                    <td style="width: 35%;">
                        : {{ $quotation->quotation_number }}<br>
                        : <span>{{ $quotation->valid_until ?? '-' }}</span><br>
                        : <span>{{ $quotation->project }}</span>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div class="content">
         <div class="title-container">
            <h1 class="main-title">QUOTATION</h1>
            {{-- <div class="sub-title">No: <span class="text-black">{{ $quotation->quotation_number }}</span></div> --}}
        </div>

        <table class="info-container">
            <tr>
                <td style="width: 62%;">
                    To.<br>
                    <strong>{{ $quotation->customer->company_name }}</strong><br>
                    {{ $quotation->customer->address }}<br>
                    Attn. {{ $quotation->customer->attn }}
                </td>
                <td style="width: 38%;">
                </td>
            </tr>
        </table>

        <p>Please find the prices below for project <span>{{ $quotation->project }}</span></p>

        @foreach ($quotation->items->groupBy('type') as $type => $items)
            <table class="item-table" style="border-collapse: collapse;">
                <thead>
                    <tr>
                        <th colspan="2" style="text-align:center; font-weight:bold; background:#ffff00; border: 1px solid #000;">
                            {{ $type }}
                        </th>
                        <th colspan="5" style="text-align:center; font-weight:bold; border:none" >
                            

                        </th>
                    </tr>
                    <tr>
                        <th style="width: 12%;">Part #</th>
                        <th>Description</th>
                        <th style="width: 5%;">Qty</th>
                        <th style="width: 7%;">UoM</th>
                        <th style="width: 15%;">Price</th>
                        <th style="width: 7%;">Disc %</th>
                        <th style="width: 17%;">Sub Price</th>
                    </tr>
                </thead>
                <tbody>
                    @php $typeTotal = 0; @endphp
                    @foreach ($items as $item)
                        @php $typeTotal += $item->amount; @endphp
                        <tr>
                            <td style="text-align: center;">{{ $item->part_number }}</td>
                            <td>{{ $item->description }}</td>
                            <td style="text-align: center;">{{ $item->qty }}</td>
                            <td style="text-align: center;">{{ $item->uom }}</td>
                            <td style="text-align: right;">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                            <td style="text-align: center;">{{ $item->discount_percent }}</td>
                            <td style="text-align: right;">Rp {{ number_format($item->amount, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                    <tr class="bg-grey">
                        <td colspan="6" style="text-align: right;">TOTAL PRICE</td>
                        <td style="text-align: right;">Rp {{ number_format($typeTotal, 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>
        @endforeach

        <table class="summary-table">
            <tr>
                <td class="bg-grey">TOTAL SUB PRICE</td>
                <td style="text-align: right; font-weight: bold;">Rp
                    {{ number_format($quotation->subtotal, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="bg-grey">VAT</td>
                <td style="text-align: right;">Rp {{ number_format($quotation->vat_amount, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="bg-grey">GRAND TOTAL</td>
                <td style="text-align: right; font-weight: bold; background-color: #cbd5e1;">Rp
                    {{ number_format($quotation->grand_total, 0, ',', '.') }}</td>
            </tr>
        </table>

        <div style="clear: both;"></div>

        <div style="margin-top: 20px;">
            {{-- Remark:<br> --}}
            {!! $quotation->remark ?? 'Thanks for your kind attention and please don\'t hesitate to contact me if you have something to discuss.' !!}
        </div>

        <div class="sig-section">
            Best Regards,<br><br>
            <br>
            <br>
            <div class="sig-name">{{Auth::user()->name}}</div>
            PT. Mizu Teknologi Indonesia
        </div>
    </div>

</body>

</html>

