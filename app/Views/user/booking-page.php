<?= $this->extend('user/layouts/base-page') ?>

<?= $this->section('content') ?>

<div class="form-booking">
  <div class="booking-card">
    <h2 class="text-center mb-4 fw-bold" style="color: #003b95;">Form Booking Lapangan</h2>
    <form id="bookingForm" method="post" action="<?= site_url('user/booking/store') ?>">
      <div class="mb-3">
        <label for="namaPenyewa" class="form-label">Nama Penyewa</label>
        <input type="text" class="form-control" id="namaPenyewa" name="namaPenyewa" value="<?= session('nama') ?>" readonly>
      </div>
      <div class="mb-3">
        <label for="lapangan" class="form-label">Pilih Lapangan</label>
        <select class="form-select" id="lapangan" name="lapangan" required>
          <option value="">-- Pilih Lapangan --</option>
          <?php foreach ($lapangans as $lapangan): ?>
            <option value="<?= esc($lapangan['id']) ?>" data-harga="<?= esc($lapangan['harga_per_jam']) ?>">
              <?= esc($lapangan['nama_lapangan']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="mb-3">
        <label for="tanggal" class="form-label">Tanggal Booking</label>
        <input type="date" class="form-control" id="tanggal" name="tanggal" required>
      </div>
      <div class="mb-3">
        <label for="jam" class="form-label">Jam Mulai Booking</label>
        <select class="form-select" id="jam" name="jam" required>
          <option value="">-- Pilih Jam --</option>
          <?php for ($i = 8; $i <= 24; $i++): ?>
            <option value="<?= sprintf('%02d.00', $i) ?>"><?= sprintf('%02d.00', $i) ?></option>
          <?php endfor; ?>
        </select>
      </div>
      <div class="mb-3">
        <label for="durasi" class="form-label">Durasi Sewa (jam)</label>
        <input type="number" class="form-control" id="durasi" name="durasi" min="1" max="9" placeholder="Misal: 2 jam" required>
      </div>

      <div class="mb-3">
        <label for="pembayaran" class="form-label">Jenis Pembayaran</label>
        <select class="form-select" id="pembayaran" name="pembayaran" required onchange="handlePembayaranChange()">
          <option value="">-- Pilih Jenis Pembayaran --</option>
          <option value="lunas">Lunas</option>
          <option value="dp">DP (50% di muka)</option>
        </select>
      </div>
      <div class="mb-3">
        <label for="bayar" class="form-label">Bayar</label>
        <input type="text" class="form-control" id="bayar" name="bayar" readonly>
      </div>
      <div class="mb-3" id="infoDp" style="display: none;">
        <div class="alert alert-info">
          Anda memilih pembayaran DP. Silakan bayar <strong>50%</strong> dari total harga sewa saat ini.<br>
          Sisa pembayaran dapat dibayarkan di tempat saat penggunaan lapangan.
        </div>
      </div>
      <div class="form-check mb-3">
        <input class="form-check-input" type="checkbox" id="persetujuan" name="persetujuan" required>
        <label class="form-check-label" for="persetujuan">
          Saya setuju bahwa akun saya akan disuspend jika tidak hadir tanpa pembatalan sebelumnya.
        </label>
      </div>
      <div class="d-grid">
        <button type="submit" class="btn btn-primary">Booking Sekarang</button>
      </div>
    </form>
  </div>
</div>

<script>
  let totalHarga = 0;
  let hargaLapangan = 0;

  document.getElementById('lapangan').addEventListener('change', updateBiaya);
  document.getElementById('durasi').addEventListener('input', updateBiaya);
  document.getElementById('pembayaran').addEventListener('change', handlePembayaranChange);

  function updateBiaya() {
    const lapanganSelect = document.getElementById('lapangan');
    const durasiInput = document.getElementById('durasi');
    const biayaInput = document.getElementById('bayar');
    const selectedLapangan = lapanganSelect.options[lapanganSelect.selectedIndex];
    hargaLapangan = selectedLapangan ? parseInt(selectedLapangan.getAttribute('data-harga')) : 0;
    const durasi = durasiInput.value;

    if (durasi && hargaLapangan) {
      totalHarga = hargaLapangan * durasi;
      biayaInput.value = totalHarga.toLocaleString();
    }
  }

  function handlePembayaranChange() {
    const pembayaran = document.getElementById('pembayaran').value;
    const infoDp = document.getElementById('infoDp');
    const biayaInput = document.getElementById('bayar');

    if (pembayaran === 'dp') {
      infoDp.style.display = 'block';
      biayaInput.value = (totalHarga / 2).toLocaleString();
    } else {
      infoDp.style.display = 'none';
      biayaInput.value = totalHarga.toLocaleString();
    }
  }
  updateBiaya();
</script>


<?= $this->endSection() ?>