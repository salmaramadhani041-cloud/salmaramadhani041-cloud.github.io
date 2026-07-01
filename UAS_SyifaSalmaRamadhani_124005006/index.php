<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sistem Manajemen Gudang</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
    *, *::before, *::after { margin:0; padding:0; box-sizing:border-box; }

    body {
      font-family: 'Inter', sans-serif;
      min-height: 100vh;
      background-color: #fce4ec;
      background-image: url('pinkG.jpg');
      background-size: cover;
      background-position: center;
      background-attachment: fixed;
    }
    body::before {
      content: '';
      position: fixed;
      inset: 0;
      background: rgba(255, 220, 230, 0.82);
      z-index: 0;
      pointer-events: none;
    }
    body > div { position: relative; z-index: 1; }

    .page-wrap { max-width: 1180px; margin: 0 auto; padding: 2.5rem 1.5rem 3rem; }

    /* Top bar */
    .top-bar {
      display: flex; align-items: center; justify-content: space-between;
      flex-wrap: wrap; gap: 1rem; margin-bottom: 1.75rem;
    }
    .top-bar h1 { font-size: 1.6rem; font-weight: 700; color: #880e4f; letter-spacing: -0.02em; }
    .top-bar h1 em { font-style: normal; color: #e91e8c; }

    /* Tombol tambah */
    .btn-primary {
      display: inline-flex; align-items: center; gap: 6px;
      padding: 0.5rem 1.2rem; background: #e91e8c; color: #fff;
      font-size: 0.875rem; font-weight: 600; border-radius: 8px;
      text-decoration: none; transition: background 0.18s, transform 0.15s;
    }
    .btn-primary:hover { background: #c2185b; transform: translateY(-1px); }

    /* Statistik */
    .stats-row { display: grid; grid-template-columns: repeat(3,1fr); gap: 0.875rem; margin-bottom: 1.75rem; }
    .stat-card {
      background: rgba(255,255,255,0.65); border: 1px solid rgba(233,30,140,0.20);
      border-radius: 12px; padding: 1rem 1.25rem; backdrop-filter: blur(10px);
    }
    .stat-card .lbl {
      font-size: 0.7rem; font-weight: 700; letter-spacing: 0.07em;
      text-transform: uppercase; color: #c2185b; margin-bottom: 0.35rem;
    }
    .stat-card .val { font-size: 1.4rem; font-weight: 700; color: #d81b60; }

    /* Tabel card */
    .table-card {
      background: rgba(255,255,255,0.55); border: 1px solid rgba(233,30,140,0.20);
      border-radius: 16px; overflow: hidden;
      backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px);
    }
    table { width: 100%; border-collapse: collapse; }
    thead tr { background: rgba(233,30,140,0.10); }
    thead th {
      padding: 0.8rem 1rem; text-align: left; font-size: 0.7rem; font-weight: 700;
      color: #c2185b; text-transform: uppercase; letter-spacing: 0.07em;
      border-bottom: 1px solid rgba(233,30,140,0.15); white-space: nowrap;
    }
    tbody tr { transition: background 0.15s; }
    tbody tr + tr { border-top: 1px solid rgba(233,30,140,0.08); }
    tbody tr:hover { background: rgba(233,30,140,0.06); }
    tbody td { padding: 0.8rem 1rem; font-size: 0.845rem; color: #5d1a35; vertical-align: middle; }

    /* Badge & cell */
    .cell-id {
      font-size: 0.72rem; font-weight: 700; color: #c2185b;
      background: rgba(194,24,91,0.12); border: 1px solid rgba(194,24,91,0.25);
      border-radius: 5px; padding: 2px 8px; display: inline-block;
    }
    .cell-nama { font-weight: 600; color: #880e4f; }
    .cell-kategori {
      font-size: 0.72rem; font-weight: 600; color: #ad1457;
      background: rgba(173,20,87,0.10); border: 1px solid rgba(173,20,87,0.22);
      border-radius: 20px; padding: 3px 10px; display: inline-block;
    }
    .cell-stok { font-weight: 600; }
    .stok-ok   { color: #2e7d32; }
    .stok-warn { color: #f57f17; }
    .stok-low  { color: #c62828; }
    .cell-harga { font-weight: 600; color: #ad1457; }
    .cell-loc   { font-size: 0.8rem; color: #c2185b; }

    /* Aksi */
    .act-group { display: flex; gap: 6px; }
    .btn-edit, .btn-del {
      font-size: 0.73rem; font-weight: 600; padding: 4px 12px;
      border-radius: 6px; text-decoration: none; transition: all 0.18s; display: inline-block;
    }
    .btn-edit {
      background: rgba(233,30,140,0.10); color: #c2185b;
      border: 1px solid rgba(194,24,91,0.25);
    }
    .btn-edit:hover { background: rgba(233,30,140,0.22); color: #880e4f; }
    .btn-del {
      background: rgba(198,40,40,0.08); color: #c62828;
      border: 1px solid rgba(198,40,40,0.20);
    }
    .btn-del:hover { background: rgba(198,40,40,0.22); color: #7f0000; }

    /* Empty */
    .empty-row td { text-align: center; padding: 3.5rem 1rem; color: #c2185b; font-size: 0.875rem; }
    .empty-row td a { color: #e91e8c; text-decoration: none; }

    @media (max-width: 700px) {
      .stats-row { grid-template-columns: 1fr; }
      .top-bar h1 { font-size: 1.25rem; }
      thead th, tbody td { padding: 0.6rem 0.65rem; font-size: 0.78rem; }
    }
  </style>
</head>
<body>
<div class="page-wrap">

  <div class="top-bar">
    <h1>&#128230; Sistem <em>Manajemen Gudang</em></h1>
    <a href="tambah.php" class="btn-primary">&#43; Tambah Barang</a>
  </div>

  <?php
    $q1 = mysqli_query($conn, "SELECT COUNT(*) AS total FROM barang");
    $total_barang = mysqli_fetch_assoc($q1)['total'];

    $q2 = mysqli_query($conn, "SELECT SUM(stok) AS s FROM barang");
    $total_stok = mysqli_fetch_assoc($q2)['s'] ?? 0;

    $q3 = mysqli_query($conn, "SELECT SUM(harga * stok) AS n FROM barang");
    $total_nilai = mysqli_fetch_assoc($q3)['n'] ?? 0;
  ?>
  <div class="stats-row">
    <div class="stat-card">
      <div class="lbl">Jenis Barang</div>
      <div class="val"><?= number_format($total_barang) ?></div>
    </div>
    <div class="stat-card">
      <div class="lbl">Total Stok</div>
      <div class="val"><?= number_format($total_stok) ?></div>
    </div>
    <div class="stat-card">
      <div class="lbl">Nilai Inventaris</div>
      <div class="val">Rp <?= number_format($total_nilai) ?></div>
    </div>
  </div>

  <div class="table-card">
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Nama Barang</th>
          <th>Kategori</th>
          <th>Stok</th>
          <th>Harga</th>
          <th>Lokasi Rak</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
      <?php
        $data = mysqli_query($conn, "SELECT * FROM barang");
        if (mysqli_num_rows($data) == 0):
      ?>
        <tr class="empty-row">
          <td colspan="7">Belum ada data barang. <a href="tambah.php">Tambah sekarang &rarr;</a></td>
        </tr>
      <?php else: while ($d = mysqli_fetch_array($data)): ?>
        <tr>
          <td><span class="cell-id">#<?= $d['id_barang'] ?></span></td>
          <td><span class="cell-nama"><?= htmlspecialchars($d['nama_barang']) ?></span></td>
          <td><span class="cell-kategori"><?= htmlspecialchars($d['kategori']) ?></span></td>
          <td>
            <?php
              $s = (int)$d['stok'];
              $sc = $s <= 5 ? 'stok-low' : ($s <= 20 ? 'stok-warn' : 'stok-ok');
            ?>
            <span class="cell-stok <?= $sc ?>"><?= $s ?></span>
          </td>
          <td><span class="cell-harga">Rp <?= number_format($d['harga']) ?></span></td>
          <td><span class="cell-loc">&#128205; <?= htmlspecialchars($d['lokasi_rak']) ?></span></td>
          <td>
            <div class="act-group">
              <a href="edit.php?id_barang=<?= $d['id_barang'] ?>" class="btn-edit">&#9998; Edit</a>
              <a href="hapus.php?id_barang=<?= $d['id_barang'] ?>"
                 onclick="return confirm('Yakin ingin menghapus barang ini?')"
                 class="btn-del">&#128465; Hapus</a>
            </div>
          </td>
        </tr>
      <?php endwhile; endif; ?>
      </tbody>
    </table>
  </div>

</div>
</body>
</html>