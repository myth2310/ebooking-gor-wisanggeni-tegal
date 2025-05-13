<?= $this->extend('admin/layouts/base-page') ?>
<?= $this->section('content') ?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Manajemen Booking</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Data Booking</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-table me-1"></i> Data Booking GOR Wisanggni Tegal
                <p class="text-success mt-2">
                    Data untuk tanggal:
                    <strong><?= isset($tanggal) ? date('d-m-Y', strtotime($tanggal)) : date('d-m-Y') ?></strong>
                </p>
            </div>
        </div>

        <div class="card-body">
            <a href="<?= base_url('admin/booking/create') ?>" class="btn btn-primary mb-3">
                <i class="fa-solid fa-plus"></i> Tambah Booking
            </a>

            <!-- Filter tanggal -->
            <form action="<?= base_url('admin/booking/filter') ?>" method="post" class="row mb-4">
                <div class="col-md-4">
                    <label for="start_date" class="form-label">Tanggal Mulai</label>
                    <input type="date" name="start_date" id="start_date" class="form-control"
                        value="<?= esc($_GET['start_date'] ?? '') ?>" required>
                </div>
                <div class="col-md-4">
                    <label for="end_date" class="form-label">Tanggal Sampai</label>
                    <input type="date" name="end_date" id="end_date" class="form-control"
                        value="<?= esc($_GET['end_date'] ?? '') ?>" required>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                    <a href="<?= base_url('admin/booking/download_excel' . $_SERVER['QUERY_STRING']) ?>" class="btn btn-success">
                        <i class="fas fa-file-excel"></i> Download Excel
                    </a>

                </div>
            </form>

            <div class="table-responsive">
                <table class="table" id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Lapangan</th>
                            <th>Tanggal</th>
                            <th>Jenis Pembayaran</th>
                            <th>Status Pembayaran</th>
                            <th>Status Booking</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($bookings as $booking): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= esc($booking['nama_user']) ?></td>
                                <td><?= esc($booking['nama_lapangan']) ?></td>
                                <td><?= date('d-m-Y', strtotime($booking['tanggal_booking'])) ?></td>
                                <td><?= esc($booking['jenis_pembayaran']) ?></td>

                                <td>
                                    <?php
                                    if ($booking['jenis_pembayaran'] == 'dp' && $booking['status_bayar'] == 'dibayar') {
                                        echo '<span class="badge bg-info text-dark"><i class="fa-solid fa-money-bill-wave me-1"></i>DP Lunas</span>';
                                    } elseif ($booking['jenis_pembayaran'] == 'dp' && $booking['status_bayar'] == 'selesai') {
                                        echo '<span class="badge bg-success"><i class="fa-solid fa-circle-check me-1"></i>Pembayaran Lunas</span>';
                                    } elseif ($booking['jenis_pembayaran'] == 'lunas' && $booking['status_booking'] == 'selesai') {
                                        echo '<span class="badge bg-success"><i class="fa-solid fa-circle-check me-1"></i>Pembayaran Lunas</span>';
                                    } else {
                                        echo '<span class="badge bg-secondary"><i class="fa-solid fa-info-circle me-1"></i>' . ucfirst($booking['status_bayar']) . '</span>';
                                    }
                                    ?>
                                </td>

                                <td>
                                    <?php if ($booking['status_booking'] == 'menunggu'): ?>
                                        <span class="badge bg-warning text-dark"><i class="fa-solid fa-clock me-1"></i>Menunggu</span>
                                    <?php elseif ($booking['status_booking'] == 'dibooking'): ?>
                                        <span class="badge bg-primary"><i class="fa-solid fa-calendar-check me-1"></i>Terbooking</span>
                                    <?php elseif ($booking['status_booking'] == 'dibatalkan'): ?>
                                        <span class="badge bg-danger"><i class="fa-solid fa-ban me-1"></i>Dibatalkan</span>
                                    <?php elseif ($booking['status_booking'] == 'selesai'): ?>
                                        <span class="badge bg-success"><i class="fa-solid fa-check-circle me-1"></i>Selesai</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary"><i class="fa-solid fa-info-circle me-1"></i><?= ucfirst($booking['status_booking']) ?></span>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <?php
                                    $kodeBooking = $booking['kode_booking'];
                                    if (
                                        $booking['jenis_pembayaran'] == 'lunas' &&
                                        $booking['status_bayar'] == 'selesai' &&
                                        $booking['status_booking'] == 'dibooking'
                                    ) {
                                        echo '<a href="javascript:void(0);" class="btn btn-success btn-sm me-1" onclick="confirmArrival(' . $booking['id'] . ', \'' . $kodeBooking . '\')">
        <i class="fa-solid fa-check"></i> Konfirmasi Kedatangan
    </a>';
                                    } elseif (
                                        $booking['jenis_pembayaran'] == 'dp' &&
                                        $booking['status_bayar'] == 'dibayar' &&
                                        $booking['status_booking'] == 'dibooking'
                                    ) {
                                        echo '<a href="javascript:void(0);" class="btn btn-success btn-sm me-1" onclick="confirmArrival(' . $booking['id'] . ', \'' . $kodeBooking . '\')">
        <i class="fa-solid fa-check"></i> Konfirmasi Kedatangan
    </a>';
                                    } elseif (
                                        $booking['jenis_pembayaran'] == 'dp' &&
                                        $booking['status_bayar'] == 'dibayar' &&
                                        $booking['status_booking'] == 'selesai'
                                    ) {
                                        echo '<a href="javascript:void(0);" class="btn btn-primary btn-sm" onclick="confirmPayment(' . $booking['id'] . ', \'' . $kodeBooking . '\')">
        <i class="fa-solid fa-dollar-sign"></i> Konfirmasi Pelunasan
    </a>';
                                    }
                                    echo '<a href="javascript:void(0);" class="btn btn-danger btn-sm" onclick="deleteBooking(' . $booking['id'] . ', \'' . $kodeBooking . '\')">
                                    <i class="fa-solid fa-trash"></i>
                                </a>';
                                    ?>

                                </td>


                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($bookings)): ?>
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada data booking.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<script>
    function confirmArrival(id, kodeBooking) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Konfirmasi kedatangan untuk booking dengan kode " + kodeBooking + " ini!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Konfirmasi',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "<?= base_url('admin/booking/konfirmasi_kedatangan/') ?>" + id;
            }
        });
    }

    function confirmPayment(id, kodeBooking) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Konfirmasi pelunasan untuk booking dengan kode " + kodeBooking + " ini!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Konfirmasi',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "<?= base_url('admin/booking/konfirmasi_lunas/') ?>" + id;
            }
        });
    }

    function deleteBooking(id, kodeBooking) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Ingin Menghapus data booking dengan kode " + kodeBooking + " ini!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Konfirmasi',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "<?= base_url('admin/booking/delete/') ?>" + id;
            }
        });
    }
</script>



<?= $this->endSection() ?>