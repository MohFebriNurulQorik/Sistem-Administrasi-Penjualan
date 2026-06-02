<?php

namespace App\Helpers;

use NumberFormatter;

class Terbilang
{
    /**
     * Fungsi utama untuk dipanggil (Hasil: Huruf Besar Di Awal Kata)
     */
    public static function terbilang_id($angka)
    {
        // strtolower memastikan teks bersih sebelum dikapitalisasi awal katanya
        return ucwords(strtolower(self::proses_terbilang($angka)));
    }

    /**
     * Logika rekursif perhitungan angka
     */
    private static function proses_terbilang($angka)
    {
        $angka = abs((int) $angka); // abs untuk menangani angka negatif
        $baca = [
            "", "satu", "dua", "tiga", "empat", "lima",
            "enam", "tujuh", "delapan", "sembilan",
            "sepuluh", "sebelas"
        ];

        if ($angka < 12) {
            return $baca[$angka];
        } elseif ($angka < 20) {
            return self::proses_terbilang($angka - 10) . " belas";
        } elseif ($angka < 100) {
            return self::proses_terbilang(intval($angka / 10)) . " puluh " . self::proses_terbilang($angka % 10);
        } elseif ($angka < 200) {
            return "seratus " . self::proses_terbilang($angka - 100);
        } elseif ($angka < 1000) {
            return self::proses_terbilang(intval($angka / 100)) . " ratus " . self::proses_terbilang($angka % 100);
        } elseif ($angka < 2000) {
            return "seribu " . self::proses_terbilang($angka - 1000);
        } elseif ($angka < 1000000) {
            return self::proses_terbilang(intval($angka / 1000)) . " ribu " . self::proses_terbilang($angka % 1000);
        } elseif ($angka < 1000000000) {
            return self::proses_terbilang(intval($angka / 1000000)) . " juta " . self::proses_terbilang($angka % 1000000);
        } elseif ($angka < 1000000000000) {
            // Support Miliar
            return self::proses_terbilang(intval($angka / 1000000000)) . " miliar " . self::proses_terbilang($angka % 1000000000);
        } elseif ($angka < 1000000000000000) {
            // Support Triliun
            return self::proses_terbilang(intval($angka / 1000000000000)) . " triliun " . self::proses_terbilang($angka % 1000000000000);
        } else {
            return "angka terlalu besar";
        }
    }

    /**
     * Terbilang Bahasa Inggris
     */
    public static function terbilang_en($angka)
    {
        if (!class_exists('NumberFormatter')) {
            return "Ekstensi PHP intl tidak aktif.";
        }
        $formatter = new NumberFormatter("en", NumberFormatter::SPELLOUT);
        return ucwords($formatter->format($angka));
    }
}
