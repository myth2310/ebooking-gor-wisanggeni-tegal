<?= $this->extend('user/layouts/base-page') ?>

<?= $this->section('content') ?>

<div class="container mt-5">
    <div class="row">
        <!-- Informasi Lapangan -->
        <div class="col-md-6">
            <div class="card shadow-sm mb-4">
                <img src="<?= base_url('uploads/lapangan/' . $lapangan['image']) ?>"
                    alt="<?= esc($lapangan['nama_lapangan']) ?>"
                    class="card-img-top"
                    style="height: 300px; object-fit: cover;">
                <div class="card-body">
                    <h4 class="card-title text-danger"><?= esc($lapangan['nama_lapangan']) ?></h4>
                    <p><?= esc($lapangan['deskripsi']) ?></p>
                    <p><strong>Harga per Jam:</strong> Rp <?= number_format($lapangan['harga_per_jam'], 0, ',', '.') ?></p>

                    <?php if (session('isLoggedIn')): ?>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            <i class="fa-solid fa-calendar-days me-2"></i>Booking Sekarang
                        </button>
                    <?php else: ?>
                        <a href="<?= site_url('login') ?>" class="btn btn-warning">
                            <i class="fa-solid fa-sign-in-alt me-2"></i>Login untuk Booking
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Jadwal Booking -->
        <div class="col-md-6">
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h4 class="card-title mb-4">Jadwal Booking - <?= date('d M Y', strtotime($tanggal)) ?></h4>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Jam</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($jadwal)): ?>
                                <?php foreach ($jadwal as $item): ?>
                                    <tr>
                                        <td><?= date('d M Y', strtotime($item['tanggal_booking'])) ?></td>
                                        <td><?= esc($item['jam_mulai']) ?> - <?= esc($item['jam_selesai']) ?></td>
                                        <td>
                                            <?php if ($item['status_booking'] === 'dibooking') : ?>
                                                <span class="badge bg-success">Terbooking</span>
                                            <?php elseif ($item['status_booking'] === 'dibatalkan') : ?>
                                                <span class="badge bg-danger">Dibatalkan</span>
                                            <?php else : ?>
                                                <span class="badge bg-secondary">Menunggu</span>
                                            <?php endif ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="3" class="text-center">Tidak ada jadwal yang tersedia.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if (session('isLoggedIn')): ?>
    <!-- Modal Booking -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="bookingForm" method="post" action="<?= site_url('user/booking/store') ?>">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Form Booking - <?= esc($lapangan['nama_lapangan']) ?></h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="lapangan" name="lapangan" value="<?= esc($lapangan['id']) ?>" data-harga="<?= esc($lapangan['harga_per_jam']) ?>">

                        <div class="mb-3">
                            <label class="form-label">Nama Penyewa</label>
                            <input type="text" class="form-control" name="namaPenyewa" value="<?= session('nama') ?>" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="tanggal">Tanggal Booking:</label>
                            <input type="date" id="tanggal" name="tanggal" min="<?= date('Y-m-d') ?>" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="jam">Pilih Jam:</label>
                            <select id="jam" name="jam" class="form-control">
                                <option value="">-- Pilih Jam --</option>
                                <?php for ($i = 7; $i <= 24; $i++): ?>
                                    <option value="<?= $i ?>"><?= sprintf('%02d.00', $i) ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Durasi Sewa (jam)</label>
                            <input type="number" class="form-control" name="durasi" id="durasi" min="1" max="9" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Jenis Pembayaran</label>
                            <select class="form-select" name="pembayaran" id="pembayaran" required>
                                <option value="">-- Pilih Jenis Pembayaran --</option>
                                <option value="lunas">Lunas</option>
                                <option value="dp">DP (50% di muka)</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Bayar</label>
                            <input type="text" class="form-control" id="bayar" name="bayar" readonly>
                        </div>

                        <div class="mb-3" id="infoDp" style="display: none;">
                            <div class="alert alert-info">
                                Anda memilih pembayaran DP. Silakan bayar <strong>50%</strong> dari total harga sewa.
                            </div>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="persetujuan" name="persetujuan" required>
                            <label class="form-check-label" for="persetujuan">
                                Saya setuju bahwa akun saya akan disuspend jika tidak hadir tanpa pembatalan sebelumnya.
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary w-100">Booking Sekarang</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endif; ?>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const tanggalInput = document.getElementById('tanggal');
    const lapanganInput = document.getElementById('lapangan');
    const jamSelect = document.getElementById('jam');
    const durasiInput = document.getElementById('durasi');
    const pembayaranInput = document.getElementById('pembayaran');
    const biayaInput = document.getElementById('bayar');
    const infoDp = document.getElementById('infoDp');

    let hargaLapangan = parseInt(lapanganInput.getAttribute('data-harga')) || 0;

    function cekJamTerbooking() {
      const tanggal = tanggalInput.value;
      const lapangan = lapanganInput.value;

      if (tanggal && lapangan) {
        fetch('<?= base_url("user/booking/cekJamTerbooking") ?>', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest',
          },
          body: `tanggal=${tanggal}&lapangan=${lapangan}`,
        })
        .then(response => response.json())
        .then(data => {
          const now = new Date();
          const selectedDate = new Date(tanggal);
          const options = jamSelect.options;

          for (let i = 0; i < options.length; i++) {
            const option = options[i];
            const jamVal = parseInt(option.value);
            if (isNaN(jamVal)) continue;

            let isBooked = data.includes(jamVal);
            let isPast = false;

            if (selectedDate.toDateString() === now.toDateString()) {
              isPast = jamVal <= now.getHours();
            }

            option.disabled = isBooked || isPast;
            option.textContent = `${jamVal}.00 ${isBooked ? '(Terbooking)' : isPast ? '(Sudah Lewat)' : ''}`;
          }
        });
      }
    }

    function updateTotalHarga() {
      const durasi = parseInt(durasiInput.value);
      return (!isNaN(durasi) && hargaLapangan) ? hargaLapangan * durasi : 0;
    }

    function updateBiaya() {
      const totalHarga = updateTotalHarga();
      const pembayaran = pembayaranInput.value;

      if (pembayaran === 'dp') {
        infoDp.style.display = 'block';
        biayaInput.value = (totalHarga / 2).toLocaleString('id-ID');
      } else if (pembayaran === 'lunas') {
        infoDp.style.display = 'none';
        biayaInput.value = totalHarga.toLocaleString('id-ID');
      } else {
        biayaInput.value = '';
        infoDp.style.display = 'none';
      }
    }

    tanggalInput.addEventListener('change', cekJamTerbooking);
    durasiInput.addEventListener('input', updateBiaya);
    pembayaranInput.addEventListener('change', updateBiaya);
  });
</script>

<?= $this->endSection() ?>
