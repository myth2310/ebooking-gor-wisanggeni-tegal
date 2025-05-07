<?= $this->extend('user/layouts/base-page') ?>

<?= $this->section('content') ?>

<div class="form-login d-flex justify-content-center align-items-center">
  <div class="card p-4 rounded" style="width: 100%; max-width: 400px;">
    <h2 class="text-center mb-4 fw-bold" style="color: #003b95;">Login</h2>

    <?php if (session()->getFlashdata('error')): ?>
      <div class="alert alert-danger" role="alert">
        <?= session()->getFlashdata('error') ?>
      </div>
    <?php endif; ?>
    
    <form action="<?= base_url('/login') ?>" method="post">
      <?= csrf_field() ?>  
      
      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" name="email" class="form-control" id="email" placeholder="Masukkan email" required>
      </div>

      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" name="password" class="form-control" id="password" placeholder="Masukkan password" required>
      </div>

      <div class="d-grid">
        <button type="submit" class="btn text-white" style="background-color: #003b95;">Login</button>
      </div>

      <div class="mt-3 text-center">
        <small>Belum punya akun? <a href="<?= base_url('register') ?>" style="text-decoration: none;">Daftar</a></small>
      </div>
    </form>
  </div>
</div>

<?= $this->endSection() ?>
