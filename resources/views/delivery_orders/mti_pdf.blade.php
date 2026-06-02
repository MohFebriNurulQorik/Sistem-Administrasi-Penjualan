<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <style>
        html, body {
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
        /* Bingkai luar tabel */
        border: 1px solid #000;
    }

    .item-table thead tr {
        background-color: #EDEBE0;
    }

    .item-table th {
        /* Garis horizontal atas dan bawah untuk header */
        border-top: 1px solid #000;
        border-bottom: 1px solid #000;
        /* Garis vertikal pemisah kolom */
        border-right: 1px solid #000;
        padding: 8px;
        font-weight: bold;
        text-align: center;
        font-size: 11px;
    }

    .item-table th:last-child {
        border-right: none;
    }

    .item-table td {
        /* HANYA garis vertikal (kanan) */
        border-right: 1px solid #000;
        padding: 10px 8px;
        vertical-align: top;
        font-size: 11px;
        /* Tanpa border-bottom agar tidak kotak-kotak */
    }

    .item-table td:last-child {
        border-right: none;
    }

    /* Membuat baris terakhir memiliki ruang kosong yang panjang sesuai gambar */
        .spacer-row td {
            height: 100px; 
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
            height: 100px;
        }

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

         .title-box {
            margin-top: 20px;
            margin-right: 45px;
        }

        .title-box h1 {
            font-family: "Times New Roman", Times, serif;
            font-size: 32px;
            margin: 0;
            text-decoration: underline;
            font-weight: bold;
        }

        .title-box p {
            font-family: Arial, sans-serif;
            font-size: 16px;
            margin: 5px 0 0 0;
        }
        .title-wrapper {
            text-align: right; /* Mengikuti posisi di gambar (kanan) */
            margin-right: 45px;
            margin-top: 20px;
            font-weight: bold;
        }

.delivery-order-title {
    font-family: "Times New Roman", Times, serif; /* Font Serif sesuai gambar */
    font-size: 32px;
    font-weight: bold;
    display: inline-block;
    margin: 0;
    line-height: 1;
    /* Membuat garis bawah ganda (Double Underline) */
    border-bottom: 1px solid #000; /* Garis tipis atas */
    padding-bottom: 2px;
    position: relative;
}

/* Membuat garis tebal di bawah garis tipis */
.delivery-order-title::after {
    content: "";
    position: absolute;
    left: 0;
    bottom: -4px; /* Jarak antara garis tipis dan tebal */
    width: 100%;
    height: 3px; /* Ketebalan garis bawah utama */
    background-color: #000;
}

.do-number-text {
    font-family: "Times New Roman", Times, serif;
    font-size: 18px;
    margin-top: 8px; /* Jarak antara garis dan nomor */
    display: block;
}
.title-table {
    float: right; /* Agar posisi judul di sebelah kanan sesuai gambar */
    border-collapse: collapse;
    margin-right: 45px;
}

.title-text {
    font-family: "Times New Roman", Times, serif;
    font-size: 32px;
    font-weight: bold;
    padding: 0;
    line-height: 1;
    /* Garis bawah pertama (tipis) */
}

.thick-line {
    /* Garis bawah kedua (tebal) */
    border-bottom: 3px solid #000; 
    height: 3px;
    padding: 0;
}

.number-text {
    font-family: "Times New Roman", Times, serif;
    font-size: 18px;
    padding-top: 5px;
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


    <div class="content2 data-container">
                 {{-- JUDUL DISESUAIKAN --}}
        <table class="title-table">
                <tr>
                    <td class="title-text">Delivery Order</td>
                </tr>
                <tr>
                    <!-- Row ini berfungsi khusus sebagai garis tebal -->
                    <td class="thick-line"></td>
                </tr>
                <tr>
                    <td class="number-text">No. {{ $do->do_number }}</td>
                </tr>
            </table>

         <!-- Penting agar konten di bawahnya tidak berantakan -->

    </div>
    <div style="clear: both;"></div>
    <div class="content">

    


    <table style="width:100%; border-collapse: collapse; border: 1px solid #000; margin-top:25px;">
        <thead>
            <tr style="background-color: #EDEBE0; font-weight: bold;">
                <td style="width: 33%; border: 1px solid #000; padding: 5px;">Shipping Address</td>
                @if($do->invoice)
                    <td colspan="2" style="width: 33%; border: 1px solid #000; padding: 5px;">Invoice Address</td>
                @else
                    <td style="width: 67%; border: 1px solid #000; padding: 5px;" colspan="2">Delivery Detail</td>
                @endif
            </tr>
        </thead>
        <tbody>
            <tr>
                <!-- Kolom 1: Shipping Address -->
                <td style="width: 30%; border: 1px solid #000; padding: 8px; vertical-align: top;">
                    <strong>{{ $do->customer->company_name }}</strong><br>
                    {{ $do->customer->address ?? '-' }}<br>
                    Telp: {{ $do->customer->phone ?? '-' }}<br>
                    Attn: {{ $do->attn }}
                </td>

                @if($do->invoice)
                    <!-- Kolom 2: Invoice Address -->
                    <td style="width: 30%; border: 1px solid #000; padding: 8px; vertical-align: top;">
                        <strong>{{ $do->invoice->customer->company_name ?? '-' }}</strong><br>
                        {{ $do->invoice->customer->address ?? '-' }}<br>
                        Telp: {{ $do->invoice->customer->phone ?? '-' }}<br>
                        Attn: {{ $do->invoice->customer->attn ?? '-' }}
                    </td>

                    <!-- Kolom 3: Order Details (Nested Table) -->
                    <td style="width: 40%; border: 1px solid #000; padding: 0; vertical-align: top;">
                        <table style="width: 100%; border-collapse: collapse; margin: -1px;">
                            <tr>
                                <td style="border-bottom: 1px solid #000; border-right: 1px solid #000; padding: 4px 6px; width: 45%;">Date of Delivery</td>
                                <td style="border-bottom: 1px solid #000; padding: 4px 6px;">: {{ \Carbon\Carbon::parse($do->delivery_date)->format('d F Y') }}</td>
                            </tr>
                            <tr>
                                <td style="border-right: 1px solid #000; padding: 4px 6px;">Project</td>
                                <td style="padding: 4px 6px;">: {{ $do->project }}</td>
                            </tr>
                            <tr>
                                <td style="border-right: 1px solid #000; padding: 4px 6px;">&nbsp;</td>
                                <td style="padding: 4px 6px;">&nbsp;</td>
                            </tr>
                        </table>
                    </td>
                @else
                    <!-- Mode Tanpa Invoice (2 Kolom Besar) -->
                    <td style="width: 67%; border: 1px solid #000; padding: 0; vertical-align: top;" colspan="2">
                        <table style="width: 100%; border-collapse: collapse; margin: -1px;">
                            <tr>
                                <td style="border-bottom: 1px solid #000; border-right: 1px solid #000; padding: 8px; width: 30%;">Date of Delivery</td>
                                <td style="border-bottom: 1px solid #000; padding: 8px;">: {{ \Carbon\Carbon::parse($do->delivery_date)->format('d F Y') }}</td>
                            </tr>
                            <tr>
                                <td style="border-right: 1px solid #000; padding: 8px;">Project</td>
                                <td style="padding: 8px;">: {{ $do->project }}</td>
                            </tr>
                            <tr>
                                <td style="border-right: 1px solid #000; padding: 8px;">&nbsp;</td>
                                <td style="padding: 8px;">&nbsp;</td>
                            </tr>
                        </table>
                    </td>
                @endif
            </tr>
        </tbody>
    </table>

    <table class="item-table" style="padding-top: 30px;">
        <thead>
            <tr>
                <th style="width: 15%;">Part #</th>
                <th style="width: 53%;">Description of Goods/Services</th>
                <th style="width: 7%;">Qty</th>
                <th style="width: 25%;">Serial #</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($do->items as $item)
                <tr>
                    <td style="text-align: center;">{{ $item->part_number }}</td>
                    <td>{{ $item->description }}</td>
                    <td style="text-align: center;">{{ $item->qty }}</td>
                    <td>{{ $item->serial_number }}</td>
                </tr>
            @endforeach

             {{-- @if(count($do->items) < 10)
                @for ($i = 0; $i < 3; $i++)
                        <tr>
                            <td>&nbsp;</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                @endfor
            @endif --}}

            <!-- Baris kosong di bawah untuk memberikan ruang sesuai gambar -->
            <tr class="spacer-row">
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
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
