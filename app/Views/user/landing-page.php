<?= $this->extend('user/layouts/base-page') ?>

<?= $this->section('content') ?>

<!-- Hero Section -->
<section id="hero" style="position: relative;">
  <div class="hero-image" style="position: relative;">
    <img src="https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEjMDHfiql7mfTZK5h_DvtJds1HHFvl6iutgFJDgbtpIAGNuW-4W2YDqTRtCi_SLTuUjD2j71uvb8TDUu4QNp58A_2rv7SNGnqj2AslMc0eA-ImZg6hjZEq_TIrnlnfYAKMkQknae5zhMpuv/s800/GOR-Gelanggang-Olahraga.jpg"
      alt="GOR Wisanggeni" style="width: 100%; height: 500px; object-fit: cover;">
    <div class="heighlight">
      <h3
        style="color: #003b95; font-size: 32px; font-family: Arial, sans-serif; margin-bottom: 10px; font-weight: 700;">
        WELCOME e<span style="color: #f48420;" >BOOKING</span> GOR WISANGGENI TEGAL
      </h3>
      <p style="color: #555; font-size: 18px; font-family: Arial, sans-serif; font-weight: 500;">
        Need a pitch to train with your team? Fast order everywhere,
        anytime check here! smart way to exercise.
      </p>
    </div>
  </div>
</section>
</div>


<!-- Kategori Section (Dummy) -->
<section id="kategori" class="py-5">
  <div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h4 class="fw-bold">Category</h4>
      <div>
        <button class="btn btn-link text-primary p-0 me-2" onclick="scrollKategori(-1)"><i class="fa-solid fa-arrow-left"></i></button>
        <button class="btn btn-link text-primary p-0" onclick="scrollKategori(1)"><i class="fa-solid fa-arrow-right"></i></button>
      </div>
    </div>

    <div class="d-flex overflow-auto gap-3" id="kategori-scroll"
      style="scroll-behavior: smooth; -ms-overflow-style: none; scrollbar-width: none;">
      <?php foreach ($categorys as $kategori): ?>
        <a href="<?= base_url('sport/' . $kategori['id']) ?>" class="text-decoration-none text-white">
          <div class="position-relative rounded" style="min-width: 240px; height: 140px; background-image: url('<?= $kategori['image'] ?>'); background-size: cover; background-position: center;">
            <div class="position-absolute bottom-0 start-0 end-0 px-3 py-2 text-white"
              style="background: linear-gradient(to top, rgba(0,0,0,0.7), transparent); border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;">
              <h6 class="mb-0 fw-bold"><?= $kategori['nama_kategori'] ?></h6>
              <small><?= $kategori['total_lapangan'] ?> Venue</small>
            </div>
          </div>
        </a>
      <?php endforeach; ?>

    </div>
  </div>
</section>

<section id="venue">
  <div class="container my-5">
    <div class="text-center mb-5">
      <h2 class="fw-bold">Our Best Venue in Gor Wisanggeni Tegal</h2>
      <p class="text-muted">So much of difference between a triumph and a flop is determined by choice of venue.</p>
    </div>

    <div class="row g-4">
      <?php if (!empty($lapangans)): ?>
        <?php foreach ($lapangans as $row): ?>
          <div class="col-md-3 col-sm-6">
            <div class="card shadow-sm h-100 border-0">
              <img
                src="<?= base_url('uploads/lapangan/' . $row['image']) ?>"
                alt="<?= esc($row['nama_lapangan']) ?>"
                class="card-img-top" style="height: 200px; object-fit: cover;">
              <div class="card-body">
                <h6 class="card-title fw-bold" style="color: #003b95;"><?= esc($row['nama_lapangan']) ?></h6>
                <p class="card-text"><?= character_limiter(strip_tags($row['deskripsi']), 100) ?></p>
              </div>
              <div class="card-footer d-flex justify-content-between align-items-center bg-light">
                <!-- <div class="text-warning">
                            <?= str_repeat('★', $row['rating'] ?? 0) . str_repeat('☆', 5 - ($row['rating'] ?? 0)) ?>
                        </div> -->
                <a href="<?= base_url('lapangan/detail/' . $row['id']) ?>" class="btn btn-outline-primary btn-sm">
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
</section>


<script>
  function scrollKategori(direction) {
    const container = document.getElementById('kategori-scroll');
    const scrollAmount = 260; // adjust based on item width
    container.scrollLeft += direction * scrollAmount;
  }
</script>


<?= $this->endSection() ?>