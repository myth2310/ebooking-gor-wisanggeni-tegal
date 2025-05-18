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
        <label for="tanggal">Tanggal Booking:</label>
        <input type="date" id="tanggal" name="tanggal" min="<?= date('Y-m-d') ?>" class="form-control" required>
      </div>

      <div class="mb-3">
        <label for="lapangan">Pilih Lapangan:</label>
        <select id="lapangan" name="lapangan" class="form-control" disabled required>
          <option value="">-- Pilih Lapangan --</option>
          <?php foreach ($lapangans as $l): ?>
            <option value="<?= $l['id'] ?>" data-harga="<?= $l['harga_per_jam'] ?>">
              <?= $l['nama_lapangan'] ?> - Rp<?= number_format($l['harga_per_jam'], 0, ',', '.') ?> /jam
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="mb-3">
        <label for="jam">Pilih Jam:</label>
        <select id="jam" name="jam" class="form-control" disabled required>
          <option value="">-- Pilih Jam --</option>
          <?php for ($i = 7; $i <= 24; $i++): ?>
            <option value="<?= $i ?>"><?= sprintf('%02d.00', $i) ?></option>
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
        <input type="text" class="form-control" id="bayar_display" readonly>
        <input type="hidden" name="bayar" id="bayar">

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
  document.addEventListener('DOMContentLoaded', function() {
    const tanggalInput = document.getElementById('tanggal');
    const lapanganInput = document.getElementById('lapangan');
    const jamSelect = document.getElementById('jam');
    const durasiInput = document.getElementById('durasi');
    const pembayaranInput = document.getElementById('pembayaran');
    const biayaInput = document.getElementById('bayar');
    const infoDp = document.getElementById('infoDp');

    let totalHarga = 0;
    let hargaLapangan = 0;
    const today = new Date().toISOString().split('T')[0];
    tanggalInput.setAttribute('min', today);

    tanggalInput.addEventListener('change', function() {
      const isTanggalTerisi = tanggalInput.value !== '';
      lapanganInput.disabled = !isTanggalTerisi;
      jamSelect.disabled = !isTanggalTerisi;

      if (!isTanggalTerisi) {
        lapanganInput.value = '';
        jamSelect.value = '';
      } else {
        cekJamTerbooking(); 
      }
    });


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

              if (isBooked || isPast) {
                option.disabled = true;
                option.textContent = `${jamVal}.00 ${isBooked ? '(Terbooking)' : '(Sudah Lewat)'}`;
              } else {
                option.disabled = false;
                option.textContent = `${jamVal}.00`;
              }
            }
          });
      }
    }

    function updateTotalHarga() {
      const selectedLapangan = lapanganInput.options[lapanganInput.selectedIndex];
      hargaLapangan = selectedLapangan ? parseInt(selectedLapangan.getAttribute('data-harga')) : 0;
      const durasi = parseInt(durasiInput.value);
      totalHarga = (!isNaN(durasi) && hargaLapangan) ? hargaLapangan * durasi : 0;
    }

    function updateBiaya() {
      updateTotalHarga();
      const pembayaran = pembayaranInput.value;

      let bayarVal = 0;
      if (pembayaran === 'dp') {
        infoDp.style.display = 'block';
        bayarVal = Math.floor(totalHarga / 2);
      } else if (pembayaran === 'lunas') {
        infoDp.style.display = 'none';
        bayarVal = totalHarga;
      } else {
        infoDp.style.display = 'none';
        bayarVal = 0;
      }

      document.getElementById('bayar_display').value = bayarVal.toLocaleString('id-ID');
      document.getElementById('bayar').value = bayarVal;
    }

    tanggalInput.addEventListener('change', cekJamTerbooking);
    lapanganInput.addEventListener('change', () => {
      cekJamTerbooking();
      updateBiaya();
    });
    durasiInput.addEventListener('input', updateBiaya);
    pembayaranInput.addEventListener('change', updateBiaya);
    updateBiaya();
  });
</script>


<?= $this->endSection() ?>