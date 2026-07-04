<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar — Gudang Perintilan</title>
  <style>
@import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,500;0,600;0,700;1,600&family=Poppins:wght@300;400;500;600;700&display=swap');
*, *::before, *::after { margin:0; padding:0; box-sizing:border-box; }

:root {
  --blush:        #f7ece9;
  --rose-dust:    #d8b4bc;
  --mauve:        #b98490;
  --mauve-deep:   #8c5b66;
  --mauve-darker: #5e3a42;
  --gold:         #b08d57;
  --gold-light:   #e4d3ab;
  --gold-deep:    #8a6a37;
  --text:         #4a2f35;
  --text-soft:    #8c6672;
  --card-glass:   rgba(255,250,248,0.80);
}

body {
  font-family: 'Poppins', sans-serif;
  min-height: 100vh;
  color: var(--text);
  background-color: var(--blush);
  background-image: url('keranjang.jpg');
  background-size: cover;
  background-position: center;
  background-attachment: fixed;
}
body::before {
  content: '';
  position: fixed; inset: 0; z-index: 0; pointer-events: none;
  background: linear-gradient(160deg, rgba(94,58,66,0.58) 0%, rgba(216,180,188,0.42) 55%, rgba(247,236,233,0.55) 100%);
}
body > * { position: relative; z-index: 1; }

::selection { background: var(--rose-dust); color: var(--mauve-darker); }
a { color: inherit; }

/* ---------- brand ---------- */
.brand {
  font-family: 'Cormorant Garamond', serif;
  font-style: italic;
  font-weight: 600;
  letter-spacing: 0.02em;
  color: var(--mauve-darker);
}
.brand-bow::before { content: "❀"; margin-right: 8px; color: var(--gold); font-style: normal; }

/* ---------- navbar ---------- */
.navbar {
  display: flex; align-items: center; justify-content: space-between;
  flex-wrap: wrap; gap: 0.75rem;
  padding: 1rem 2rem;
  background: rgba(255,250,248,0.72);
  border-bottom: 1px solid rgba(176,141,87,0.30);
  backdrop-filter: blur(18px); -webkit-backdrop-filter: blur(18px);
}
.navbar .brand { font-size: 1.55rem; }
.navbar .nav-right { display: flex; align-items: center; gap: 1.1rem; }
.navbar .nav-user {
  font-size: 0.82rem; font-weight: 500; color: var(--text-soft);
  display: flex; align-items: center; gap: 7px; letter-spacing: 0.01em;
}
.navbar .nav-user .avatar-dot {
  width: 7px; height: 7px; border-radius: 50%; background: var(--gold);
  box-shadow: 0 0 0 3px rgba(176,141,87,0.20);
}

/* ---------- buttons ---------- */
.btn {
  display: inline-flex; align-items: center; justify-content: center; gap: 7px;
  padding: 0.6rem 1.35rem; border-radius: 4px; border: none; cursor: pointer;
  font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 0.8rem;
  letter-spacing: 0.05em; text-transform: uppercase;
  text-decoration: none; transition: background 0.2s, transform 0.15s, box-shadow 0.2s;
}
.btn-primary {
  background: linear-gradient(135deg, var(--mauve) 0%, var(--mauve-deep) 100%);
  color: #fff8f6; box-shadow: 0 6px 16px rgba(94,58,66,0.30);
}
.btn-primary:hover { transform: translateY(-1px); box-shadow: 0 8px 20px rgba(94,58,66,0.38); background: linear-gradient(135deg, var(--mauve-deep) 0%, var(--mauve-darker) 100%); }
.btn-primary:disabled { opacity: 0.6; cursor: not-allowed; transform: none; }
.btn-ghost {
  background: rgba(255,250,248,0.55); color: var(--mauve-darker);
  border: 1px solid rgba(176,141,87,0.45);
}
.btn-ghost:hover { background: rgba(216,180,188,0.30); }
.btn-block { width: 100%; }
.btn-sm { padding: 5px 14px; font-size: 0.68rem; border-radius: 3px; }
.btn-edit { background: rgba(185,132,144,0.14); color: var(--mauve-darker); border: 1px solid rgba(176,141,87,0.35); }
.btn-edit:hover { background: rgba(185,132,144,0.26); }
.btn-del { background: rgba(140,58,66,0.08); color: #7a2e34; border: 1px solid rgba(140,58,66,0.24); }
.btn-del:hover { background: rgba(140,58,66,0.18); }

/* ---------- layout ---------- */
.page-wrap { max-width: 1180px; margin: 0 auto; padding: 2.2rem 1.5rem 3rem; }
.form-wrap { display: flex; align-items: center; justify-content: center; min-height: 100vh; padding: 3rem 1rem; }

/* ---------- glass cards ---------- */
.form-card, .table-card, .stat-card, .auth-card {
  background: var(--card-glass);
  border: 1px solid rgba(176,141,87,0.32);
  backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px);
  box-shadow: 0 12px 40px rgba(94,58,66,0.14);
}
.form-card, .auth-card { border-radius: 6px; padding: 2.3rem 2.4rem 2.6rem; }
.auth-card { width: 100%; max-width: 420px; position: relative; overflow: hidden; }
.auth-card::before {
  content: ""; position: absolute; top: 0; left: 0; right: 0; height: 3px;
  background: linear-gradient(90deg, var(--gold-light), var(--gold), var(--gold-light));
}
.auth-card::after {
  content: "❀"; position: absolute; top: 14px; right: 20px; font-size: 1.6rem;
  color: var(--gold); opacity: 0.55;
}
.form-card h2, .auth-card h2 {
  font-family: 'Cormorant Garamond', serif; font-style: italic;
  font-size: 2.1rem; font-weight: 600;
  color: var(--mauve-darker); margin-bottom: 0.2rem;
}
.form-card .sub, .auth-card .sub { font-size: 0.82rem; color: var(--text-soft); margin-bottom: 1.6rem; font-weight: 300; }
.form-divider { border: none; border-top: 1px solid rgba(176,141,87,0.35); margin-bottom: 1.5rem; }

/* ---------- form fields ---------- */
.field { margin-bottom: 1.05rem; }
.field label {
  display: block; font-size: 0.68rem; font-weight: 600; color: var(--gold-deep);
  text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 0.45rem;
}
.field input[type="text"], .field input[type="number"],
.field input[type="password"], .field input[type="email"] {
  width: 100%; padding: 0.65rem 0.95rem;
  background: rgba(255,255,255,0.75);
  border: 1px solid rgba(176,141,87,0.35);
  border-radius: 3px; color: var(--text);
  font-size: 0.875rem; font-family: 'Poppins', sans-serif; font-weight: 400;
  outline: none; transition: border-color 0.2s, background 0.2s;
}
.field input:focus { border-color: var(--gold); background: rgba(255,255,255,0.92); }
.field input::placeholder { color: #c6a5ac; }
.field-hint { font-size: 0.7rem; color: var(--text-soft); margin-top: 0.35rem; }

/* password strength meter */
.pw-meter { display: flex; gap: 4px; margin-top: 0.5rem; }
.pw-meter span { height: 3px; flex: 1; border-radius: 2px; background: rgba(176,141,87,0.20); transition: background 0.2s; }
.pw-meter.s1 span:nth-child(1) { background: #b56b6b; }
.pw-meter.s2 span:nth-child(-n+2) { background: var(--gold); }
.pw-meter.s3 span:nth-child(-n+3) { background: var(--mauve); }
.pw-meter.s4 span { background: var(--mauve-deep); }

/* ---------- alert / status box ---------- */
.alert-box {
  display: none; padding: 0.75rem 1.05rem; border-radius: 4px;
  font-size: 0.82rem; font-weight: 500; margin-bottom: 1.1rem;
}
.alert-box.show { display: block; }
.alert-box.success { background: rgba(140,163,120,0.14); color: #4c6b3a; border: 1px solid rgba(140,163,120,0.35); }
.alert-box.error   { background: rgba(140,58,66,0.08); color: #7a2e34; border: 1px solid rgba(140,58,66,0.26); }

/* spinner */
.spinner {
  width: 13px; height: 13px; border-radius: 50%;
  border: 2px solid rgba(255,255,255,0.45); border-top-color: #fff;
  animation: spin 0.7s linear infinite; display: none;
}
@keyframes spin { to { transform: rotate(360deg); } }

/* ---------- switch link ---------- */
.switch-link { display: block; text-align: center; margin-top: 1.3rem; font-size: 0.82rem; color: var(--text-soft); font-weight: 300; }
.switch-link a { color: var(--mauve-darker); font-weight: 600; text-decoration: none; }
.switch-link a:hover { text-decoration: underline; }
.back-link { display: block; text-align: center; margin-top: 1.2rem; font-size: 0.82rem; color: var(--text-soft); text-decoration: none; font-weight: 300; }
.back-link:hover { color: var(--mauve-darker); }

/* ---------- dashboard stats ---------- */
.stats-row { display: grid; grid-template-columns: repeat(3,1fr); gap: 0.9rem; margin: 1.75rem 0; }
.stat-card { border-radius: 6px; padding: 1.1rem 1.3rem; }
.stat-card .lbl { font-size: 0.66rem; font-weight: 600; letter-spacing: 0.1em; text-transform: uppercase; color: var(--gold-deep); margin-bottom: 0.4rem; }
.stat-card .val { font-family: 'Cormorant Garamond', serif; font-size: 1.7rem; font-weight: 600; color: var(--mauve-darker); }

/* ---------- table ---------- */
.top-bar { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem; margin-bottom: 0.25rem; }
.top-bar h1 { font-family: 'Cormorant Garamond', serif; font-style: italic; font-size: 2.2rem; font-weight: 600; color: var(--mauve-darker); }
.table-card { border-radius: 6px; overflow: hidden; }
table { width: 100%; border-collapse: collapse; }
thead tr { background: rgba(176,141,87,0.12); }
thead th {
  padding: 0.85rem 1.05rem; text-align: left; font-size: 0.66rem; font-weight: 600;
  color: var(--gold-deep); text-transform: uppercase; letter-spacing: 0.1em;
  border-bottom: 1px solid rgba(176,141,87,0.28); white-space: nowrap;
}
tbody tr + tr { border-top: 1px solid rgba(176,141,87,0.16); }
tbody tr:hover { background: rgba(185,132,144,0.06); }
tbody td { padding: 0.85rem 1.05rem; font-size: 0.845rem; color: var(--text); vertical-align: middle; }

.cell-id {
  font-size: 0.7rem; font-weight: 600; color: var(--mauve-darker);
  background: rgba(185,132,144,0.12); border: 1px solid rgba(176,141,87,0.30);
  border-radius: 3px; padding: 2px 9px; display: inline-block;
}
.cell-nama { font-weight: 600; color: var(--mauve-darker); }
.cell-kategori {
  font-size: 0.7rem; font-weight: 500; color: var(--gold-deep);
  background: rgba(176,141,87,0.12); border: 1px solid rgba(176,141,87,0.32);
  border-radius: 20px; padding: 3px 11px; display: inline-block;
}
.cell-stok { font-weight: 600; }
.stok-ok { color: #4c6b3a; } .stok-warn { color: #a3792e; } .stok-low { color: #8c3a3a; }
.cell-harga { font-weight: 600; color: var(--mauve-darker); }
.cell-loc { font-size: 0.8rem; color: var(--text-soft); }
.act-group { display: flex; gap: 6px; }
.empty-row td { text-align: center; padding: 3.5rem 1rem; color: var(--text-soft); font-size: 0.875rem; }
.empty-row td a { color: var(--mauve-darker); text-decoration: none; font-weight: 600; }

@media (max-width: 700px) {
  .stats-row { grid-template-columns: 1fr; }
  .top-bar h1 { font-size: 1.7rem; }
  thead th, tbody td { padding: 0.6rem 0.65rem; font-size: 0.78rem; }
  .navbar { padding: 0.85rem 1.15rem; }
}

</style>
</head>
<body>
<div class="form-wrap">
  <div class="auth-card">
    <h2>Buat Akun Baru</h2>
    <p class="sub">Daftar dulu supaya bisa kelola gudang perintilanmu dengan anggun</p>
    <hr class="form-divider">

    <div id="statusAlert" class="alert-box"></div>

    <form id="formRegister" novalidate>
      <div class="field">
        <label>Username</label>
        <input type="text" name="username" placeholder="Contoh: cutewarehouse" required minlength="3" autocomplete="username">
      </div>
      <div class="field">
        <label>Alamat Email</label>
        <input type="email" name="email" placeholder="contoh: nama@domain.com" required autocomplete="email">
      </div>
      <div class="field">
        <label>Password</label>
        <input type="password" id="password" name="password" placeholder="Min. 8 karakter" required minlength="8" autocomplete="new-password">
        <div class="pw-meter" id="pwMeter"><span></span><span></span><span></span><span></span></div>
        <p class="field-hint" id="pwHint">Gunakan huruf besar, angka, dan karakter spesial.</p>
      </div>
      <div class="field">
        <label>Konfirmasi Password</label>
        <input type="password" id="confirmPassword" name="confirm_password" placeholder="Ulangi password" required autocomplete="new-password">
      </div>

      <button type="submit" class="btn btn-primary btn-block" id="submitBtn">
        <span id="btnText">✦ Daftar Akun</span>
        <span id="btnSpinner" class="spinner"></span>
      </button>
    </form>

    <p class="switch-link">Sudah punya akun? <a href="login.php">Masuk di sini</a></p>
  </div>
</div>

<script>
const pwInput = document.getElementById('password');
const pwMeter = document.getElementById('pwMeter');
const pwHint  = document.getElementById('pwHint');

function evaluatePassword(val) {
  let score = 0;
  if (val.length >= 8) score++;
  if (/[A-Z]/.test(val)) score++;
  if (/[0-9]/.test(val)) score++;
  if (/[^A-Za-z0-9]/.test(val)) score++;
  return score;
}

pwInput.addEventListener('input', () => {
  const score = evaluatePassword(pwInput.value);
  pwMeter.className = 'pw-meter s' + score;
  const labels = ['Terlalu lemah', 'Lemah', 'Cukup', 'Kuat', 'Sangat kuat'];
  pwHint.textContent = pwInput.value.length ? labels[score] + ' — gunakan huruf besar, angka, dan karakter spesial.' : 'Gunakan huruf besar, angka, dan karakter spesial.';
});

document.getElementById('formRegister').addEventListener('submit', async function (e) {
  e.preventDefault();
  const form = e.target;
  const alertBox = document.getElementById('statusAlert');
  const submitBtn = document.getElementById('submitBtn');
  const btnText = document.getElementById('btnText');
  const btnSpinner = document.getElementById('btnSpinner');

  alertBox.classList.remove('show', 'success', 'error');

  const password = document.getElementById('password').value;
  const confirmPassword = document.getElementById('confirmPassword').value;

  // Validasi kekuatan password di sisi klien
  const strongEnough = password.length >= 8 &&
    /[A-Z]/.test(password) &&
    /[0-9]/.test(password) &&
    /[^A-Za-z0-9]/.test(password);

  if (!strongEnough) {
    alertBox.classList.add('show', 'error');
    alertBox.textContent = 'Password harus minimal 8 karakter dan mengandung huruf kapital, angka, serta karakter spesial.';
    return;
  }
  if (password !== confirmPassword) {
    alertBox.classList.add('show', 'error');
    alertBox.textContent = 'Konfirmasi password tidak cocok.';
    return;
  }

  const formData = new FormData(form);

  submitBtn.disabled = true;
  btnText.textContent = "Sedang memproses...";
  btnSpinner.style.display = "inline-block";

  try {
    const response = await fetch('register_process.php', {
      method: 'POST',
      body: formData
    });
    const data = await response.json();

    alertBox.classList.add('show');
    if (response.ok) {
      alertBox.classList.remove('error');
      alertBox.classList.add('success');
      alertBox.textContent = data.message + ' Mengarahkan ke halaman masuk...';
      form.reset();
      pwMeter.className = 'pw-meter';
      setTimeout(() => { window.location.href = 'login.php'; }, 1200);
    } else {
      alertBox.classList.remove('success');
      alertBox.classList.add('error');
      alertBox.textContent = data.message || 'Gagal melakukan registrasi.';
      submitBtn.disabled = false;
      btnText.textContent = "✦ Daftar Akun";
      btnSpinner.style.display = "none";
    }
  } catch (err) {
    alertBox.classList.add('show', 'error');
    alertBox.textContent = "Gagal menghubungi server. Periksa koneksi lokal Anda.";
    submitBtn.disabled = false;
    btnText.textContent = "✦ Daftar Akun";
    btnSpinner.style.display = "none";
    console.error(err);
  }
});
</script>
</body>
</html>