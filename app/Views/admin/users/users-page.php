<?= $this->extend('admin/layouts/base-page') ?>

<?= $this->section('content') ?>

<!-- Tambahkan CSS DataTables -->
<link href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css" rel="stylesheet">

<div class="container-fluid px-4">
    <h1 class="mt-4">Manajemen User</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Data User</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Data Users
        </div>
        <div class="card-body">
            <a href="<?= base_url('admin/users/create') ?>" class="btn btn-primary mb-3">
                <i class="fa-solid fa-plus"></i> Tambah Users
            </a>
            <div class="table-responsive">
                <table class="table" id="dataUsers">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>No HP</th>
                            <th>Role</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= esc($user['nama']) ?></td>
                                <td><?= esc($user['email']) ?></td>
                                <td><?= esc($user['no_hp']) ?></td>
                                <td><?= esc(ucfirst($user['role'])) ?></td>
                                <td>
                                    <a href="<?= base_url('admin/users/edit/' . $user['id']) ?>" class="btn btn-warning btn-sm">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <button class="btn btn-danger btn-sm delete-btn" data-id="<?= $user['id'] ?>" data-name="<?= esc($user['nama']) ?>">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Tambahkan JS DataTables -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        // Menginisialisasi DataTables
        $('#dataUsers').DataTable({
            "paging": true,  // Menampilkan pagination
            
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Fungsi untuk menangani klik pada tombol hapus
        document.querySelectorAll('.delete-btn').forEach(function(button) {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                const userId = this.getAttribute('data-id');
                const userName = this.getAttribute('data-name');

                if (userId && userName) {
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: `Anda akan menghapus user bernama ${userName}`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Hapus',
                        cancelButtonText: 'Batal',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "<?= base_url('admin/users/delete/') ?>" + userId;
                        }
                    });
                } else {
                    console.error('User ID or User Name is missing!');
                }
            });
        });
    });
</script>

<?= $this->endSection() ?>
