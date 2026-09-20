<?php
/**
 * Data Layer: products.php
 * Berkas penampung multidimensional array yang menyimpan data komoditas produk.
 * Struktur: ID, Nama, Kategori, Harga, Stok, Deskripsi.
 */

$products = [
    [
        'id'        => 'PRD-001',
        'nama'      => 'Beras Pandan Wangi Premium 5kg',
        'kategori'  => 'Sembako',
        'harga'     => 78000,
        'stok'      => 15,
        'deskripsi' => 'Beras kualitas premium beraroma wangi alami dan pulen.'
    ],
    [
        'id'        => 'PRD-002',
        'nama'      => 'Minyak Goreng Sawit 2L',
        'kategori'  => 'Minyak & Mentega',
        'harga'     => 34500,
        'stok'      => 2, // Stok Kritis (< 3)
        'deskripsi' => 'Minyak goreng kelapa sawit murni 2x penyaringan higienis.'
    ],
    [
        'id'        => 'PRD-003',
        'nama'      => 'Gula Pasir Kristal Putih 1kg',
        'kategori'  => 'Sembako',
        'harga'     => 17500,
        'stok'      => 25,
        'deskripsi' => 'Gula tebu pilihan tanpa bahan pemutih tambahan.'
    ],
    [
        'id'        => 'PRD-004',
        'nama'      => 'Kopi Arabika Gayo Specialty 250g',
        'kategori'  => 'Minuman',
        'harga'     => 65000,
        'stok'      => 1, // Stok Kritis (< 3)
        'deskripsi' => 'Biji kopi sangrai kualitas ekspor dengan aroma floral dan fruity.'
    ],
    [
        'id'        => 'PRD-005',
        'nama'      => 'Susu UHT Full Cream 1L',
        'kategori'  => 'Minuman',
        'harga'     => 21000,
        'stok'      => 8,
        'deskripsi' => 'Susu sapi segar kaya kalsium dan vitamin D untuk nutrisi harian.'
    ],
    [
        'id'        => 'PRD-006',
        'nama'      => 'Teh Celup Melati Kotak (isi 25)',
        'kategori'  => 'Minuman',
        'harga'     => 8500,
        'stok'      => 0, // Stok Kritis (< 3 / Habis)
        'deskripsi' => 'Perpaduan daun teh hitam pilihan dengan bunga melati alami.'
    ],
    [
        'id'        => 'PRD-007',
        'nama'      => 'Tepung Terigu Serbaguna 1kg',
        'kategori'  => 'Bahan Kue',
        'harga'     => 13000,
        'stok'      => 12,
        'deskripsi' => 'Tepung protein sedang cocok untuk segala jenis masakan dan kue.'
    ],
    [
        'id'        => 'PRD-008',
        'nama'      => 'Garam Beryodium Halus 500g',
        'kategori'  => 'Bumbu Dapur',
        'harga'     => 6000,
        'stok'      => 20,
        'deskripsi' => 'Garam dapur beryodium berkualitas untuk melengkapi kelezatan masakan.'
    ]
];
