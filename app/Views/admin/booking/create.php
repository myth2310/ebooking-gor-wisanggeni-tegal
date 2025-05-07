<?= $this->extend('admin/layouts/base-page') ?>

<?= $this->section('content') ?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Tambah Booking</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item">Data Booking</li>
        <li class="breadcrumb-item active">Tambah Booking</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-calendar-plus me-1"></i>
            Form Tambah Booking
        </div>
        <div class="card-body">
            <form action="<?= base_url('admin/booking/store') ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label for="id_user" class="form-label">User</label>
                    <select name="id_user" id="id_user" class="form-control" required>
                        <option value="">-- Pilih User --</option>
                            <option value="">Achmad Miftahudin</option>
                            <option value="">Achmad Miftahudin</option>
                            <option value="">Achmad Miftahudin</option>
                            <option value="">Achmad Miftahudin</option>
                      
                    </select>
                </div>

                <div class="mb-3">
                    <label for="id_lapangan" class="form-label">Lapangan</label>
                    <select name="id_lapangan" id="id_lapangan" class="form-control" required>
                        <option value="">-- Pilih Lapangan --</option>
                            <option value="">Lapangan 1</option>
                            <option value="">Lapangan 1</option>
                            <option value="">Lapangan 1</option>
                            <option value="">Lapangan 1</option>      
                    </select>
                </div>

                <div class="mb-3">
                    <label for="tanggal_booking" class="form-label">Tanggal Booking</label>
                    <input type="date" name="tanggal_booking" id="tanggal_booking" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="jam_mulai" class="form-label">Jam Mulai</label>
                    <input type="time" name="jam_mulai" id="jam_mulai" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="jam_selesai" class="form-label">Jam Selesai</label>
                    <input type="time" name="jam_selesai" id="jam_selesai" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="bukti_pembayaran" class="form-label">Bukti Pembayaran (opsional)</label>
                    <input type="file" name="bukti_pembayaran" id="bukti_pembayaran" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="catatan" class="form-label">Catatan (opsional)</label>
                    <textarea name="catatan" id="catatan" rows="3" class="form-control"></textarea>
                </div>

                <div class="text-end">
                    <a href="<?= base_url('admin/booking') ?>" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-primary">Simpan Booking</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
