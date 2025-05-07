<?= $this->extend('user/layouts/base-page') ?>

<?= $this->section('content') ?>

<div class="container mt-4">
    <div class="alert alert-success fw-bold fs-6 fs-md-5">
        Selamat Datang, <?= session('nama') ?>! di E-Booking Gor Wisanggeni TEGAL
    </div>
</div>

<!-- Main Content -->
<div class="container" style="margin-top: 40px;">
    <div class="row">

        <!-- Informasi Akun -->
        <div class="col-md-4">
            <div class="account-card text-center">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSOH2aZnIHWjMQj2lQUOWIL2f4Hljgab0ecZQ&s" alt="Foto Profil" class="profile-img">
                <h4><?= session('nama') ?></h4>
                <p><strong>Email:</strong> <?= session('email') ?></p>
                <p><strong>Telepon:</strong> 08123456789</p>
                <p><strong>Alamat:</strong> Jakarta, Indonesia</p>
            </div>
        </div>

        <!-- Riwayat Booking -->
        <div class="col-md-8">
            <div class="history-card">

                <h4>Riwayat Booking</h4>

                <?php if (!empty($bookings)): ?>
                    <?php foreach ($bookings as $booking): ?>
                        <div class="riwayat-card card shadow-sm mb-3 p-3" style="border-radius: 8px; font-size: 14px;">
                            <div class="card-body p-2">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h6 class="title-filed" style="color: #212529;"><?= esc($booking['nama_lapangan']) ?></h6>

                                    <?php if ($booking['status_bayar'] == 'menunggu'): ?>
                                        <span class="badge bg-warning">
                                            Menunggu Pembayaran
                                            <i class="fa-solid fa-spinner" style="margin-left: 10px; font-size: 15px;"></i>
                                        </span>

                                    <?php elseif ($booking['status_bayar'] == 'dibayar' && $booking['jenis_pembayaran'] == 'dp'): ?>
                                        <span class="badge bg-success">
                                            Pembayaran DP Lunas
                                            <i class="fa-solid fa-circle-check" style="margin-left: 10px; font-size: 15px;"></i>
                                        </span>

                                    <?php elseif ($booking['status_bayar'] == 'selesai' && $booking['jenis_pembayaran'] == 'lunas'): ?>
                                        <span class="badge bg-success">
                                            Pembayaran Selesai
                                            <i class="fa-solid fa-circle-check" style="margin-left: 10px; font-size: 15px;"></i>
                                        </span>
                                    <?php endif; ?>


                                </div>
                                <div class="mb-1"><strong>Tanggal :</strong> <?= date('d M Y', strtotime($booking['tanggal_booking'])) ?></div>
                                <div class="mb-1"><strong>Jam :</strong> <?= esc($booking['jam_mulai']) ?></div>
                                <div class="mb-1"><strong>Pembayaran :</strong> <?= esc($booking['jenis_pembayaran']) ?></div>
                                <div class="mb-1"><strong>Total Pembayaran :</strong> <span class="text-success">Rp <?= number_format($booking['total_bayar'], 0, ',', '.') ?></span></div>
                                <div class="mb-1"><strong>Dibayar :</strong> <span class="text-success">Rp <?= number_format($booking['bayar'], 0, ',', '.') ?></span></div>


                                <?php if ($booking['jenis_pembayaran'] == 'dp'): ?>
                                    <?php
                                    $kekurangan = $booking['total_bayar'] - $booking['bayar'];
                                    ?>
                                    <div class="mb-1 text-danger"><strong>Kekurangan:</strong> Rp<?= number_format($kekurangan, 0, ',', '.') ?></div>
                                <?php else: ?>
                                    <div class="mb-1 text-success"><strong>Kekurangan:</strong> Rp0</div>
                                <?php endif; ?>

                                <?php
                                $jenis = $booking['jenis_pembayaran'];
                                $status = $booking['status_bayar'];

                                if ($jenis == 'dp' && $status == 'dibayar') : ?>
                                    <div class="alert alert-warning p-2 mt-2" style="font-size: 13px;">
                                        Anda telah membayar <strong>DP</strong>. Sisa pembayaran dapat diselesaikan di tempat saat hari H.
                                    </div>
                                <?php elseif ($jenis == 'lunas' && $status == 'lunas') : ?>
                                    <div class="alert alert-success p-2 mt-2" style="font-size: 13px;">
                                        <strong>Pembayaran lunas</strong>. Anda tinggal datang ke lokasi sesuai jadwal dan tunjukkan tiket booking.
                                    </div>
                                <?php elseif (($jenis == 'dp' || $jenis == 'lunas') && $status == 'menunggu') : ?>
                                    <div class="alert alert-danger p-2 mt-2" style="font-size: 13px;">
                                        Segera lakukan pembayaran <strong><?= strtoupper($jenis) ?></strong> Anda untuk mengamankan booking.
                                    </div>
                                <?php else : ?>
                                    <div class="alert alert-secondary p-2 mt-2" style="font-size: 13px;">
                                        Belum ada informasi pembayaran.
                                    </div>
                                <?php endif; ?>

                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <?php if ($booking['jenis_pembayaran'] == 'dp' && $booking['status_bayar'] == 'dibayar'): ?>
                                        <a href="<?= base_url('pembayaran') ?>" class="btn btn-sm btn-outline-primary">
                                            <i class="fa-solid fa-file-invoice me-1"></i> Tiket Booking
                                        </a>
                                    <?php elseif ($booking['jenis_pembayaran'] == 'lunas' && $booking['status_bayar'] == 'selesai'): ?>
                                        <a href="<?= base_url('pembayaran') ?>" class="btn btn-sm btn-outline-primary">
                                            <i class="fa-solid fa-file-invoice me-1"></i> Tiket Booking
                                        </a>
                                    <?php else: ?>
                                        <button class="btn btn-sm btn-primary pay-button"
                                            data-order-id="<?= $booking['kode_booking'] ?>"
                                            data-total="<?= $booking['bayar'] ?>">
                                            <i class="fa-solid fa-money-bill me-1"></i> Selesaikan Pembayaran
                                        </button>

                                    <?php endif; ?>

                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Tidak ada riwayat booking.</p>
                <?php endif; ?>

                <div class="d-flex justify-content-end mt-4">
                    <nav>
                        <ul class="pagination">
                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                <li class="page-item <?= $i == $currentPage ? 'active' : '' ?>">
                                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>
                        </ul>
                    </nav>
                </div>

            </div>
        </div>

    </div>
</div>



<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="<?= getenv('MIDTRANS_CLIENT_KEY') ?>"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.pay-button').forEach(function(button) {
        button.addEventListener('click', function() {
            const orderId = this.getAttribute('data-order-id');
            const totalAmount = this.getAttribute('data-total');

            fetch('<?= base_url('pembayaran/get_snap_token') ?>', {
                    method: 'POST',
                    body: JSON.stringify({
                        order_id: orderId,
                        total_amount: totalAmount
                    }),
                    headers: {
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    snap.pay(data.snapToken, {
                        onSuccess: function(result) {
                            Swal.fire({
                                title: 'Pembayaran Berhasil!',
                                text: 'Terima kasih atas transaksi Anda. Tiket booking sudah tersedia.',
                                icon: 'success',
                                confirmButtonText: 'OK',
                                confirmButtonColor: '#28a745',
                            }).then(() => {
                                window.location.href = "<?= base_url('user/profil') ?>";
                            });
                        },
                        onPending: function() {
                            Swal.fire({
                                title: 'Pembayaran Sedang Diproses',
                                text: 'Pembayaran Anda sedang diproses, harap tunggu sebentar.',
                                icon: 'info',
                                confirmButtonText: 'OK',
                                confirmButtonColor: '#ffc107',
                            }).then(() => {
                                window.location.href = "<?= base_url('user/profil') ?>"; 
                            });
                        },
                        onError: function() {
                            Swal.fire({
                                title: 'Pembayaran Gagal!',
                                text: 'Pembayaran Anda gagal diproses. Silakan coba lagi.',
                                icon: 'error',
                                confirmButtonText: 'OK',
                                confirmButtonColor: '#dc3545',
                            });
                        }
                    });
                })
                .catch((error) => {
                    console.error('Error:', error);
                });
        });
    });
});


</script>

<?= $this->endSection() ?>