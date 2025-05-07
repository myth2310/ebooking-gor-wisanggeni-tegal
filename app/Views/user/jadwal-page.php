<?= $this->extend('user/layouts/base-page') ?>
<?= $this->section('content') ?>

<main class="container my-5">
  <div class="text-center mb-4">
    <h2 class="fw-bold">Jadwal Booking</h2>
    <p class="text-muted">Temukan jadwal yang sesuai dengan kebutuhan Anda.</p>
  </div>

  <h5 class="mb-3">Jadwal untuk tanggal:
    <?= strftime('%A, %d %B %Y', strtotime($tanggal)) ?>
  </h5>

  <div class="alert alert-info mt-4" role="alert">
    Jadwal dapat berubah sewaktu-waktu. Pastikan Anda melakukan booking untuk mengamankan slot favorit Anda!
  </div>

  <form method="post" class="row g-3 mb-4" action="/booking/filter">
    <div class="col-md-5">
      <label for="tanggal" class="form-label">Tanggal</label>
      <input type="date" class="form-control" id="tanggal" name="tanggal" value="<?= $tanggal ?>">
    </div>
    <div class="col-md-5">
      <label for="lapangan" class="form-label">Lapangan</label>
      <select class="form-select" id="lapangan" name="lapangan">
        <option value="">-- Semua Lapangan --</option>
        <?php foreach ($lapangan as $l) : ?>
          <option value="<?= $l['id'] ?>" <?= $lapangan_selected == $l['id'] ? 'selected' : '' ?>>
            <?= esc($l['nama_lapangan']) ?>
          </option>
        <?php endforeach ?>
      </select>
    </div>
    <div class="col-md-2 d-flex align-items-end">
      <button type="submit" class="btn btn-primary w-100"><i class="fa-solid fa-filter"></i> Filter</button>
    </div>
  </form>
  <!-- Table Display -->
  <table class="table table-bordered align-middle text-center" id="jadwalTable">
    <thead>
      <tr>
        <th>Tanggal</th>
        <th>Lapangan</th>
        <th>Jam</th>
        <th>Status Booking</th>
      </tr>
    </thead>
    <tbody>
      <?php if (!empty($jadwal)) : ?>
        <?php foreach ($jadwal as $row) : ?>
          <tr>
            <td>
              <?php
              setlocale(LC_TIME, 'id_ID.utf8');
              $tanggal = new DateTime($row['tanggal_booking']);
              echo strftime('%A, %d %B %Y', $tanggal->getTimestamp());
              ?>
            </td>
            <td><?= esc($row['nama_lapangan']) ?></td>
            <td><?= esc($row['jam_mulai']) ?> - <?= esc($row['jam_selesai']) ?></td>
            <td>
              <?php if ($row['status_booking'] === 'dibooking') : ?>
                <span class="badge bg-success">Terbooking</span>
              <?php elseif ($row['status_booking'] === 'dibatalkan') : ?>
                <span class="badge bg-danger">Dibatalkan</span>
              <?php else : ?>
                <span class="badge bg-secondary">Menunggu</span>
              <?php endif ?>
            </td>
          </tr>
        <?php endforeach ?>
      <?php else : ?>
        <tr>
          <td colspan="4">Tidak ada booking ditemukan.</td>
        </tr>
      <?php endif ?>
    </tbody>
  </table>

</main>

<?= $this->endSection() ?>