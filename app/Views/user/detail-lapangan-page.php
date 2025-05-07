<?= $this->extend('user/layouts/base-page') ?>

<?= $this->section('content') ?>

<div class="container" style="margin-top: 40px;">
    <div class="row">
        <!-- Informasi Lapangan -->
        <div class="col-md-6">
            <div class="card shadow-sm mb-4">
                <img
                    src="<?= base_url('uploads/lapangan/' . $lapangan['image']) ?>"
                    alt="<?= esc($lapangan['nama_lapangan']) ?>"
                    class="card-img-top" style="height: 300px; object-fit: cover;">
                <div class="card-body">
                    <h4 class="card-title text-danger"><?= esc($lapangan['nama_lapangan']) ?></h4>
                    <p><strong>Deskripsi:</strong> <?= esc($lapangan['deskripsi']) ?></p>
                    <p><strong>Harga per Jam:</strong> Rp <?= number_format($lapangan['harga_per_jam'], 0, ',', '.') ?></p>
                    <p><strong>Status:</strong>
                        <span class="badge bg-<?= ($lapangan['status'] === 'aktif') ? 'success' : 'danger' ?>"><?= ucfirst($lapangan['status']) ?></span>
                    </p>
                   
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
                                    <td colspan="4" class="text-center">Tidak ada jadwal yang tersedia.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>