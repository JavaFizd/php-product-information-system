<?php
/**
 * Presentation Layer: index.php
 * Merajut seluruh komponen menggunakan require_once dan merender data ke layout tabel HTML via foreach.
 */

require_once 'products.php';
require_once 'functions.php';

// Kalkulasi metrik ringkasan
$totalNilaiAset = hitungTotalNilaiStok($products);
$totalUnitStok  = hitungTotalKuantitasStok($products);
$totalProduk    = count($products);
$jumlahKritis   = hitungJumlahStokKritis($products);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Information System - Sistem Manajemen Produk</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --bg-body: #f8fafc;
            --bg-card: #ffffff;
            --text-primary: #0f172a;
            --text-secondary: #64748b;
            --text-muted: #94a3b8;
            --border-color: #e2e8f0;
            --primary: #2563eb;
            --primary-light: #eff6ff;
            --primary-dark: #1d4ed8;
            --success: #10b981;
            --success-light: #ecfdf5;
            --warning: #f59e0b;
            --warning-light: #fffbeb;
            --danger: #ef4444;
            --danger-light: #fef2f2;
            --danger-row: #fff1f2;
            --danger-border: #fecdd3;
            --out-row: #fdf2f8;
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.07), 0 2px 4px -2px rgb(0 0 0 / 0.07);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.08), 0 4px 6px -4px rgb(0 0 0 / 0.05);
            --radius-md: 12px;
            --radius-lg: 16px;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: var(--bg-body);
            color: var(--text-primary);
            line-height: 1.6;
            padding: 32px 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Header Section */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 28px;
            flex-wrap: wrap;
            gap: 16px;
        }

        .header-title h1 {
            font-size: 1.75rem;
            font-weight: 800;
            color: var(--text-primary);
            letter-spacing: -0.02em;
        }

        .header-title p {
            color: var(--text-secondary);
            font-size: 0.95rem;
            margin-top: 4px;
        }

        .badge-arch {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background-color: var(--primary-light);
            color: var(--primary);
            font-weight: 600;
            font-size: 0.8rem;
            padding: 6px 12px;
            border-radius: 9999px;
            border: 1px solid rgba(37, 99, 235, 0.2);
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 32px;
        }

        .stat-card {
            background: var(--bg-card);
            border-radius: var(--radius-md);
            padding: 22px;
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-sm);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
        }

        .stat-label {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .stat-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
        }

        .icon-blue { background: var(--primary-light); color: var(--primary); }
        .icon-green { background: var(--success-light); color: var(--success); }
        .icon-purple { background: #f5f3ff; color: #7c3aed; }
        .icon-red { background: var(--danger-light); color: var(--danger); }

        .stat-value {
            font-size: 1.6rem;
            font-weight: 800;
            color: var(--text-primary);
            letter-spacing: -0.02em;
        }

        .stat-desc {
            font-size: 0.8rem;
            color: var(--text-muted);
            margin-top: 4px;
        }

        /* Table Section */
        .table-card {
            background: var(--bg-card);
            border-radius: var(--radius-lg);
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-sm);
            overflow: hidden;
        }

        .table-header-box {
            padding: 20px 24px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
        }

        .table-header-box h2 {
            font-size: 1.15rem;
            font-weight: 700;
        }

        .legend-list {
            display: flex;
            gap: 14px;
            align-items: center;
            font-size: 0.8rem;
            color: var(--text-secondary);
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .legend-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
        }

        .dot-critical { background: var(--danger); }
        .dot-normal { background: var(--success); }

        .table-responsive {
            width: 100%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            font-size: 0.9rem;
        }

        thead {
            background-color: #f1f5f9;
        }

        th {
            padding: 14px 20px;
            font-weight: 700;
            color: #475569;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-bottom: 1px solid var(--border-color);
            white-space: nowrap;
        }

        td {
            padding: 16px 20px;
            border-bottom: 1px solid var(--border-color);
            vertical-align: middle;
        }

        tbody tr {
            transition: background-color 0.15s ease;
        }

        tbody tr:hover {
            background-color: #f8fafc;
        }

        /* Conditional Rows */
        tr.row-critical {
            background-color: var(--danger-row);
            border-left: 4px solid var(--danger);
        }

        tr.row-critical:hover {
            background-color: #ffe4e6;
        }

        tr.row-stock-out {
            background-color: var(--out-row);
            border-left: 4px solid #db2777;
        }

        tr.row-stock-out:hover {
            background-color: #fce7f3;
        }

        /* Badges */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        .badge-category {
            background: #f1f5f9;
            color: #475569;
            border: 1px solid var(--border-color);
        }

        .badge-normal {
            background: var(--success-light);
            color: #065f46;
        }

        .badge-critical {
            background: #fee2e2;
            color: #991b1b;
            animation: pulse-soft 2s infinite;
        }

        .badge-out {
            background: #fce7f3;
            color: #9d174d;
        }

        .prod-id {
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
            font-weight: 700;
            color: var(--primary);
            font-size: 0.85rem;
        }

        .prod-name {
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 2px;
        }

        .prod-desc {
            font-size: 0.8rem;
            color: var(--text-secondary);
            max-width: 320px;
            line-height: 1.4;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .stock-value {
            font-weight: 700;
            font-size: 0.95rem;
        }

        .stock-critical-text {
            color: var(--danger);
            font-weight: 800;
        }

        .footer-note {
            margin-top: 24px;
            text-align: center;
            font-size: 0.85rem;
            color: var(--text-muted);
        }

        @keyframes pulse-soft {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.75; }
        }

        @media (max-width: 768px) {
            body { padding: 16px 12px; }
            .header-title h1 { font-size: 1.4rem; }
            .stat-value { font-size: 1.3rem; }
            th, td { padding: 12px 14px; }
        }
    </style>
</head>
<body>

<div class="container">
    <!-- Header -->
    <header class="header">
        <div class="header-title">
            <span class="badge-arch">
                ⚡ Mini Project 1 &bull; 3-Tier Architecture
            </span>
            <h1 style="margin-top: 8px;">Product Information System</h1>
            <p>Sistem Manajemen Informasi Data Komoditas Produk &amp; Monitoring Nilai Aset Gudang</p>
        </div>
    </header>

    <!-- Stats Section -->
    <section class="stats-grid">
        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-label">Total Nilai Aset</span>
                <div class="stat-icon icon-green">💰</div>
            </div>
            <div class="stat-value"><?= formatRupiah($totalNilaiAset); ?></div>
            <div class="stat-desc">Kalkulasi harga &times; stok gudang</div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-label">Total Jenis Produk</span>
                <div class="stat-icon icon-blue">📦</div>
            </div>
            <div class="stat-value"><?= number_format($totalProduk); ?> <span style="font-size: 1rem; font-weight: 500; color: var(--text-secondary);">Item</span></div>
            <div class="stat-desc">Terdaftar dalam Data Layer</div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-label">Total Kuantitas Stok</span>
                <div class="stat-icon icon-purple">📊</div>
            </div>
            <div class="stat-value"><?= number_format($totalUnitStok); ?> <span style="font-size: 1rem; font-weight: 500; color: var(--text-secondary);">Unit</span></div>
            <div class="stat-desc">Total unit fisik tersedia</div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-label">Perlu Restock</span>
                <div class="stat-icon icon-red">⚠️</div>
            </div>
            <div class="stat-value" style="color: <?= $jumlahKritis > 0 ? 'var(--danger)' : 'var(--text-primary)'; ?>;">
                <?= number_format($jumlahKritis); ?> <span style="font-size: 1rem; font-weight: 500; color: var(--text-secondary);">Produk</span>
            </div>
            <div class="stat-desc">Stok kritis (&lt; 3 unit)</div>
        </div>
    </section>

    <!-- Product Table Section -->
    <main class="table-card">
        <div class="table-header-box">
            <div>
                <h2>Daftar Komoditas Produk</h2>
            </div>
            <div class="legend-list">
                <div class="legend-item">
                    <span class="legend-dot dot-normal"></span>
                    <span>Stok Aman (&ge; 3)</span>
                </div>
                <div class="legend-item">
                    <span class="legend-dot dot-critical"></span>
                    <span>Stok Kritis (&lt; 3)</span>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th style="width: 100px;">ID Produk</th>
                        <th>Informasi Komoditas</th>
                        <th>Kategori</th>
                        <th class="text-right">Harga Satuan</th>
                        <th class="text-center">Stok</th>
                        <th class="text-center">Status</th>
                        <th class="text-right">Subtotal Nilai</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                        <?php 
                            $statusInfo = getStatusStok($product['stok']);
                            $subtotal = $product['harga'] * $product['stok'];
                        ?>
                        <tr class="<?= $statusInfo['row_class']; ?>">
                            <td>
                                <span class="prod-id"><?= htmlspecialchars($product['id']); ?></span>
                            </td>
                            <td>
                                <div class="prod-name"><?= htmlspecialchars($product['nama']); ?></div>
                                <div class="prod-desc"><?= htmlspecialchars($product['deskripsi']); ?></div>
                            </td>
                            <td>
                                <span class="badge badge-category">
                                    <?= htmlspecialchars($product['kategori']); ?>
                                </span>
                            </td>
                            <td class="text-right" style="font-weight: 600;">
                                <?= formatRupiah($product['harga']); ?>
                            </td>
                            <td class="text-center">
                                <span class="stock-value <?= $statusInfo['is_kritis'] ? 'stock-critical-text' : ''; ?>">
                                    <?= number_format($product['stok']); ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <span class="badge <?= $statusInfo['badge_class']; ?>">
                                    <?= $statusInfo['status_label']; ?>
                                </span>
                            </td>
                            <td class="text-right" style="font-weight: 700; color: var(--text-primary);">
                                <?= formatRupiah($subtotal); ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr style="background: #f8fafc; font-weight: 700;">
                        <td colspan="4" style="text-align: right; padding: 18px 20px; font-size: 0.95rem;">
                            TOTAL KESELURUHAN NILAI ASET GUDANG:
                        </td>
                        <td class="text-center" style="font-size: 1rem; color: var(--primary);">
                            <?= number_format($totalUnitStok); ?> Unit
                        </td>
                        <td></td>
                        <td class="text-right" style="font-size: 1.1rem; color: #047857;">
                            <?= formatRupiah($totalNilaiAset); ?>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </main>

    <!-- Footer Note -->
    <footer class="footer-note">
        <p>Product Information System &bull; Pemrograman Web Pertemuan 2</p>
    </footer>
</div>

</body>
</html>
