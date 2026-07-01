<?php
include 'koneksi.php';
$id   = $_GET['id_barang'];
$data = mysqli_query($conn, "SELECT * FROM barang WHERE id_barang='$id'");
$d    = mysqli_fetch_array($data);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Barang</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
    *, *::before, *::after { margin:0; padding:0; box-sizing:border-box; }

    body {
      font-family: 'Inter', sans-serif;
      min-height: 100vh;
      background-color: #fce4ec;
      background-image: url('bg.jpg');
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

    .form-wrap {
      display: flex; align-items: flex-start; justify-content: center;
      min-height: 100vh; padding: 3rem 1rem;
    }
    .form-card {
      width: 100%; max-width: 480px;
      background: rgba(255,255,255,0.70);
      border: 1px solid rgba(233,30,140,0.22);
      border-radius: 18px; padding: 2rem 2.25rem 2.25rem;
      backdrop-filter: blur(24px); -webkit-backdrop-filter: blur(24px);
    }
    .form-card h2 { font-size: 1.25rem; font-weight: 700; color: #880e4f; margin-bottom: 0.4rem; }
    .form-card .sub { font-size: 0.8rem; color: #e48aae; margin-bottom: 1.75rem; }
    .form-divider { border: none; border-top: 1px solid rgba(233,30,140,0.15); margin-bottom: 1.5rem; }

    .field { margin-bottom: 1rem; }
    .field label {
      display: block; font-size: 0.75rem; font-weight: 700; color: #c2185b;
      text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 0.4rem;
    }
    .field input[type="text"],
    .field input[type="number"] {
      width: 100%; padding: 0.62rem 0.9rem;
      background: rgba(255,255,255,0.80);
      border: 1px solid rgba(194,24,91,0.25);
      border-radius: 8px; color: #880e4f;
      font-size: 0.875rem; font-family: 'Inter', sans-serif;
      outline: none; transition: border-color 0.2s, background 0.2s;
    }
    .field input:focus { border-color: #e91e8c; background: rgba(233,30,140,0.06); }

    .btn-submit {
      width: 100%; margin-top: 0.75rem; padding: 0.72rem;
      background: #e91e8c; color: #fff; border: none; border-radius: 8px;
      font-size: 0.9rem; font-weight: 700; font-family: 'Inter', sans-serif;
      cursor: pointer; transition: background 0.18s, transform 0.15s;
    }
    .btn-submit:hover { background: #c2185b; transform: translateY(-1px); }

    .back-link {
      display: block; text-align: center; margin-top: 1.1rem;
      font-size: 0.82rem; color: #e48aae; text-decoration: none; transition: color 0.18s;
    }
    .back-link:hover { color: #c2185b; }
  </style>
</head>
<body>
<div class="form-wrap">
  <div class="form-card">
    <h2>&#9998; Edit Data Barang</h2>
    <p class="sub">Ubah data yang diperlukan lalu klik Update.</p>
    <hr class="form-divider">

    <form action="update.php" method="POST">
      <input type="hidden" name="id_barang" value="<?= $d['id_barang'] ?>">

      <div class="field">
        <label>Nama Barang</label>
        <input type="text" name="nama_barang" value="<?= htmlspecialchars($d['nama_barang']) ?>" required>
      </div>
      <div class="field">
        <label>Kategori</label>
        <input type="text" name="kategori" value="<?= htmlspecialchars($d['kategori']) ?>" required>
      </div>
      <div class="field">
        <label>Stok</label>
        <input type="number" name="stok" value="<?= $d['stok'] ?>" min="0" required>
      </div>
      <div class="field">
        <label>Harga (Rp)</label>
        <input type="number" name="harga" value="<?= $d['harga'] ?>" min="0" required>
      </div>
      <div class="field">
        <label>Lokasi Rak</label>
        <input type="text" name="lokasi_rak" value="<?= htmlspecialchars($d['lokasi_rak']) ?>" required>
      </div>

      <button type="submit" class="btn-submit">&#10227; Update Barang</button>
    </form>

    <a href="index.php" class="back-link">&#8592; Kembali ke daftar</a>
  </div>
</div>
</body>
</html>