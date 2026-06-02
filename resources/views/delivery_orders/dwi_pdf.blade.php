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
            margin: 0 45px;
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

        /* Perbaikan Gaya Judul */
        .title-container {
            text-align: center;
            margin-bottom: 25px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }

        .main-title {
            font-size: 22px;
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
            margin-bottom: 20px;
            border-collapse: collapse;
        }

        .info-container td {
            vertical-align: top;
            padding: 5px;
        }

        .label-bold {
            font-weight: bold;
            color: #000;
            text-transform: uppercase;
            display: block;
            margin-bottom: 2px;
        }

        .item-table {
            width: 100%;
            border-collapse: collapse;
            border-collapse: collapse;
        }

        .item-table th, .item-table td {
            border: 1px solid #000;
            padding: 5px;
        }

        .item-table th {
            font-weight: bold;
            text-transform: uppercase;
            background-color: #e2e8f0;
        }
        .item-table td {
            background-color: #fefeff;
        }

        .text-black {
            color: #000;
            font-weight: bold;
        }

        .sig-section {
            margin-top: 40px;
            page-break-inside: avoid;
        }

        .sig-box {
            text-align: center;
            padding-top: 10px;
        }

        .sig-space {
            height: 70px;
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

    {{-- JUDUL DISESUAIKAN --}}
    <div class="title-container">
        <h1 class="main-title">DELIVERY ORDER</h1>
        <div class="sub-title">No: <span class="text-black">{{ $do->do_number }}</span></div>
    </div>

    {{-- INFO --}}
   <style>
    .info-container {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
        font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
        color: #444;
        line-height: 1.5;
    }
    .info-container td {
        vertical-align: top;
        padding: 10px;
    }
    
    .order-details-table td {
        padding: 2px 0 !important;
    }
</style>

<table class="info-container">
    <tr>
        @if($do->invoice)
            <!-- Shipping Address -->
            <td style="width: 30%;vertical-align:top">
                <strong class="label-bold">Shipping Address</strong><br>
                <div style="font-size: 12px;">
                    <strong >{{ $do->customer->company_name }}</strong><br>
                    <span style="color: #555;">
                        {{ $do->customer->address ?? '-' }}<br>
                        <small>Telp:</small> {{ $do->customer->phone ?? '-' }}<br>
                        <small>Attn:</small> <span >{{ $do->attn }}</span>
                    </span>
                </div>
            </td>

            <!-- Invoice Address -->
            <td style="width: 30%; vertical-align:top;">
                <strong class="label-bold">Invoice Address</strong><br>
                <div style="font-size: 12px;">
                    <strong >{{ $do->invoice->customer->company_name ?? '-' }}</strong><br>
                    <span style="color: #555;">
                        {{ $do->invoice->customer->address ?? '-' }}<br>
                        <small>Telp:</small> {{ $do->invoice->customer->phone ?? '-' }}<br>
                        <small>Attn:</small> <span >{{ $do->invoice->customer->attn ?? '-' }}</span>
                    </span>
                </div>
            </td>
            
            <!-- Order Details -->
            <td style="width: 40%; vertical-align:top; border-left: 1px solid #eee; background-color: #fafafa;">
                <strong class="label-bold">Order Details</strong><br>
                <table class="order-details-table" style="width: 100%; font-size: 11px;">
                    <tr>
                        <td style="width: 35%;">Delivery Date</td>
                        <td>: <span >{{ \Carbon\Carbon::parse($do->delivery_date)->format('d M Y') }}</span></td>
                    </tr>
                    <tr>
                        <td>Project</td>
                        <td>: <span >{{ $do->project }}</span></td>
                    </tr>
                </table>
            </td>

        @else
            <!-- Mode Tanpa Invoice: Dibagi 2 Kolom Saja -->
            <td style="width: 50%;">
                <strong class="label-bold">Shipping Address</strong><br>
                <div style="font-size: 12px;">
                    <strong >{{ $do->customer->company_name }}</strong><br>
                    <span style="color: #555;">
                        {{ $do->customer->address ?? '-' }}<br>
                        <small>Telp:</small> {{ $do->customer->phone ?? '-' }}<br>
                        <small>Attn:</small> <span >{{ $do->attn }}</span>
                    </span>
                </div>
            </td>

            <td style="width: 50%; border-left: 1px solid #eee; background-color: #fafafa;">
                <strong class="label-bold">Order Details</strong><br>
                <table class="order-details-table" style="width: 100%; font-size: 11px;">
                    <tr>
                        <td style="width: 30%;">Delivery Date</td>
                        <td>: <span >{{ \Carbon\Carbon::parse($do->delivery_date)->format('d M Y') }}</span></td>
                    </tr>
                    <tr>
                        <td>Project</td>
                        <td>: <span >{{ $do->project }}</span></td>
                    </tr>
                </table>
            </td>
        @endif
    </tr>
</table>


    <p style="margin-bottom: 8px;">Please find the delivery details below:</p>

    {{-- ITEMS --}}
    <table class="item-table">
        <thead>
            <tr>
                <th style="width: 15%;">Part #</th>
                <th>Description</th>
                <th style="width: 8%;">Qty</th>
                <th style="width: 25%;">Serial Number</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($do->items as $item)
                <tr>
                    <td style="text-align:center;" class="text-black">{{ $item->part_number }}</td>
                    <td>{{ $item->description }}</td>
                    <td style="text-align:center;">{{ $item->qty }}</td>
                    <td style="font-family: 'Courier', monospace; font-size: 10px;">{{ $item->serial_number ?? '-' }}</td>
                </tr>
            @endforeach

            // ini ada jika item kurang dari 10, agar tabel tetap rapi dan tidak terlalu pendek
            @if(count($do->items) < 10)
                @for ($i = 0; $i < 3; $i++)
                    <tr>
                        <td>&nbsp;</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                @endfor
            @endif
        </tbody>
    </table>

    {{-- SIGNATURE --}}
    <div class="sig-section">
        <table style="width:100%;">
            <tr>
                <td class="sig-box" style="width:50%;">
                    <div class="text-black">Shipper,</div>
                    <div class="sig-space"></div>
                    <div style="border-top: 1px solid #000; width: 80%; margin: 0 auto;"></div>
                    {{-- <span class="text-black">{{ $do->shipper_name ?? 'Courier' }}</span> --}}
                </td>
                <td class="sig-box" style="width:50%;">
                    <div class="text-black">Recipient,</div>
                    <div class="sig-space"></div>
                    <div style="border-top: 1px solid #000; width: 80%; margin: 0 auto;"></div>
                    {{-- <span class="text-black">{{ $do->recipient_name ?? 'Customer' }}</span> --}}
                </td>
            </tr>
        </table>
    </div>

</div>

</body>
</html>
