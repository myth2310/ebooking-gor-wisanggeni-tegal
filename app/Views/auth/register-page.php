<?= $this->extend('user/layouts/base-page') ?>

<?= $this->section('content') ?>

<div class="form-register d-flex justify-content-center align-items-center min-vh-100">
  <div class="card p-4 rounded shadow" style="width: 100%; max-width: 400px;">
    <h2 class="text-center mb-4 fw-bold" style="color: #003b95;">Register</h2>
    <form action="<?= base_url('register/process') ?>" method="post" enctype="multipart/form-data">
      <div class="mb-3">
        <label for="nama" class="form-label">Nama Lengkap</label>
        <input type="text" name="nama" class="form-control" id="nama" placeholder="Masukkan nama lengkap" required>
      </div>
      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" name="email" class="form-control" id="email" placeholder="Masukkan email" required>
      </div>
      <div class="mb-3">
        <label for="no_hp" class="form-label">No HP/WA</label>
        <input type="text" name="no_hp" class="form-control" id="no_hp" placeholder="Masukkan No HP" required>
      </div>
      <div class="mb-3">
        <label for="alamat" class="form-label">Alamat</label>
        <textarea name="alamat" class="form-control" id="alamat" placeholder="Masukkan alamat" required></textarea>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" name="password" class="form-control" id="password" placeholder="Masukkan password" required>
      </div>
      <div class="mb-3">
        <label for="confirm_password" class="form-label">Konfirmasi Password</label>
        <input type="password" name="confirm_password" class="form-control" id="confirm_password" placeholder="Konfirmasi password" required>
      </div>
      <div class="d-grid">
        <button type="submit" class="btn text-white" style="background-color: #003b95;">Register</button>
      </div>
      <div class="mt-3 text-center">
        <small>Sudah punya akun? <a href="<?= base_url('login') ?>" style="text-decoration: none;">Login</a></small>
      </div>
    </form>
  </div>
</div>

<?= $this->endSection() ?>
