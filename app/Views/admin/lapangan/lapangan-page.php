<?= $this->extend('admin/layouts/base-page') ?>

<?= $this->section('content') ?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Daftar Lapangan</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Daftar Lapangan</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Daftar Lapangan
        </div>
        <div class="card-body">
            <a href="<?= base_url('admin/lapangan/create') ?>" class="btn btn-primary mb-3">
                <i class="fa-solid fa-plus"></i> Tambah Lapangan
            </a>
            <table class="table table-striped" id="lapanganTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Gambar</th>
                        <th>Nama Lapangan</th>
                        <th>Jenis</th>
                        <th>Harga Per Jam</th>
                        <th>Deskripsi</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>

                    <?php if (!empty($lapangans)): ?>
                        <?php $no = 1; ?>
                        <?php foreach ($lapangans as $lapangan): ?>
                            <tr>
                                <td><?= $no++ ?></td>

                                <td><img src="<?= base_url('uploads/lapangan/' . $lapangan['image']) ?>" alt="Image" width="100"></td>
                                <td><?= $lapangan['nama_lapangan'] ?></td>
                                <td><?= $lapangan['category_name'] ?></td>
                                <td>Rp<?= number_format($lapangan['harga_per_jam'], 0, ',', '.') ?></td>
                                <td><?= $lapangan['deskripsi'] ?></td>
                                <td>
                                    <?php if ($lapangan['status'] == 'aktif'): ?>
                                        <span class="badge bg-success">Aktif</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Nonaktif</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="<?= base_url('admin/lapangan/edit/' . $lapangan['id']) ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <button class="btn btn-danger btn-sm" onclick="deleteLapangan(<?= $lapangan['id'] ?>)">Delete</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center">Tidak ada lapangan tersedia.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function deleteLapangan(id) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data lapangan ini akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '/admin/lapangan/delete/' + id;
            }
        });
    }
</script>

<?= $this->endSection() ?>