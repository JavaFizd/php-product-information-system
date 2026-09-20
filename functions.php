<?php
/**
 * Processing Layer: functions.php
 * Berkas penampung fungsi logika bisnis dan pengolahan data.
 */

/**
 * Mengalkulasi total nilai aset gudang (Total Harga x Stok untuk setiap produk).
 *
 * @param array $products Daftar produk (multidimensional array)
 * @return float Total nilai aset dalam angka
 */
function hitungTotalNilaiStok(array $products): float {
    $totalNilai = 0;
    foreach ($products as $product) {
        $totalNilai += ($product['harga'] * $product['stok']);
    }
    return $totalNilai;
}

/**
 * Menghitung total seluruh kuantitas unit stok di gudang.
 *
 * @param array $products
 * @return int
 */
function hitungTotalKuantitasStok(array $products): int {
    $totalUnit = 0;
    foreach ($products as $product) {
        $totalUnit += $product['stok'];
    }
    return $totalUnit;
}

/**
 * Menghitung jumlah produk yang memiliki stok kritis (< 3).
 *
 * @param array $products
 * @return int
 */
function hitungJumlahStokKritis(array $products): int {
    $jumlahKritis = 0;
    foreach ($products as $product) {
        if ($product['stok'] < 3) {
            $jumlahKritis++;
        }
    }
    return $jumlahKritis;
}

/**
 * Memeriksa status stok dan mengembalikan konfigurasi visual baris tabel (CSS class & label).
 * Logika kondisional: jika stok < 3 dianggap 'kritis'.
 *
 * @param int $stok Jumlah stok saat ini
 * @return array Berisi 'is_kritis' (bool), 'row_class' (string), 'badge_class' (string), 'status_label' (string)
 */
function getStatusStok(int $stok): array {
    if ($stok <= 0) {
        return [
            'is_kritis'    => true,
            'row_class'    => 'row-stock-out',
            'badge_class'  => 'badge-out',
            'status_label' => 'Habis (0)'
        ];
    } elseif ($stok < 3) {
        return [
            'is_kritis'    => true,
            'row_class'    => 'row-critical',
            'badge_class'  => 'badge-critical',
            'status_label' => 'Kritis (< 3)'
        ];
    } else {
        return [
            'is_kritis'    => false,
            'row_class'    => 'row-normal',
            'badge_class'  => 'badge-normal',
            'status_label' => 'Aman'
        ];
    }
}

/**
 * Memformat angka menjadi format Rupiah standar (contoh: Rp 75.000).
 *
 * @param float|int $angka
 * @return string
 */
function formatRupiah($angka): string {
    return 'Rp ' . number_format($angka, 0, ',', '.');
}
