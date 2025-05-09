<?= $this->extend('user/layouts/base-page') ?>

<?= $this->section('content') ?>

<div class="position-relative p-3">
    <img src="<?= $kategori['image'] ?>"
         class="img-fluid w-100"
         style="height: 300px; object-fit: cover;"
         alt="<?= esc($kategori['nama_kategori']) ?>">

    <div class="position-absolute top-50 start-50 translate-middle text-white ">
        <h2 class="fw-bold shadow-sm" style="text-shadow: 2px 2px 6px rgba(0,0,0,0.6);">
            <?= esc($kategori['nama_kategori']) ?>
        </h2>
    </div>
</div>



<!-- Lapangan List -->
<div class="container mt-4 mb-4">
    <div class="row g-4">
        <?php if (!empty($venues)): ?>
            <?php foreach ($venues as $venue): ?>
                <div class="col-md-3 col-sm-6">
                    <div class="card shadow-sm h-100 border-0">
                        <img src="<?= base_url('uploads/lapangan/' . $venue['image']) ?>"
                             alt="<?= esc($venue['nama_lapangan']) ?>"
                             class="card-img-top"
                             style="height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <h6 class="card-title fw-bold text-primary"><?= esc($venue['nama_lapangan']) ?></h6>
                            <p class="card-text"><?= character_limiter(strip_tags($venue['deskripsi']), 100) ?></p>
                        </div>
                        <div class="card-footer d-flex justify-content-between align-items-center bg-light">
                            <a href="<?= base_url('lapangan/detail/' . $venue['id']) ?>"
                               class="btn btn-outline-primary btn-sm">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-warning text-center">
                    <strong>Tidak ada lapangan yang tersedia saat ini.</strong>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>
