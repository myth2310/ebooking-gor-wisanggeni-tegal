<?= $this->extend('admin/layouts/base-page') ?>

<?= $this->section('content') ?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Tambah Lapangan</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Form Tambah Lapangan</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-plus-circle me-1"></i>
            Form Tambah Lapangan
        </div>
        <div class="card-body">
            <form action="<?= base_url('admin/lapangan/store') ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>

                <div class="form-group mb-3">
                    <label for="nama_lapangan">Nama Lapangan</label>
                    <input type="text" class="form-control <?= isset($errors['nama_lapangan']) ? 'is-invalid' : '' ?>" id="nama_lapangan" name="nama_lapangan" value="<?= old('nama_lapangan') ?>" required>
                    <div class="invalid-feedback">
                        <?= isset($errors['nama_lapangan']) ? $errors['nama_lapangan'] : '' ?>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label for="image">Gambar Lapangan</label>
                    <input type="file" accept="image/*" class="form-control <?= isset($errors['image']) ? 'is-invalid' : '' ?>" id="image" name="image" required>
                    <div class="invalid-feedback">
                        <?= isset($errors['image']) ? $errors['image'] : '' ?>
                    </div>
                </div>

                <div class="form-group mb-3">
                <label for="jenis_lapangan">Jenis Lapangan</label>
                <select name="jenis" class="form-control <?= isset($errors['jenis']) ? 'is-invalid' : '' ?>" id="jenis" required>
                    <option value="">-- Pilih Jenis Lapangan --</option>
                    <option value="Sepak Bola" <?= old('jenis') == 'Sepak Bola' ? 'selected' : '' ?>>Sepak Bola</option>
                    <option value="Futsal" <?= old('jenis') == 'Futsal' ? 'selected' : '' ?>>Futsal</option>
                    <option value="Basket" <?= old('jenis') == 'Basket' ? 'selected' : '' ?>>Basket</option>
                    <option value="Badminton" <?= old('jenis') == 'Badminton' ? 'selected' : '' ?>>Badminton</option>
                    <option value="Tenis" <?= old('jenis') == 'Tenis' ? 'selected' : '' ?>>Tenis</option>
                    <option value="Voli" <?= old('jenis') == 'Voli' ? 'selected' : '' ?>>Voli</option>
                    <option value="Atletik" <?= old('jenis') == 'Atletik' ? 'selected' : '' ?>>Atletik</option>
                </select>
                </div>


                <div class="form-group mb-3">
                    <label for="harga_per_jam">Harga Per Jam</label>
                    <input type="number" class="form-control <?= isset($errors['harga_per_jam']) ? 'is-invalid' : '' ?>" id="harga_per_jam" name="harga_per_jam" value="<?= old('harga_per_jam') ?>" required>
                    <div class="invalid-feedback">
                        <?= isset($errors['harga_per_jam']) ? $errors['harga_per_jam'] : '' ?>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label for="deskripsi">Deskripsi (Optional)</label>
                    <textarea class="form-control <?= isset($errors['deskripsi']) ? 'is-invalid' : '' ?>" id="deskripsi" name="deskripsi"><?= old('deskripsi') ?></textarea>
                    <div class="invalid-feedback">
                        <?= isset($errors['deskripsi']) ? $errors['deskripsi'] : '' ?>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label for="status">Status</label>
                    <select class="form-control <?= isset($errors['status']) ? 'is-invalid' : '' ?>" id="status" name="status" required>
                        <option selected disabled value="">-- Pilih Status --</option>
                        <option value="aktif" <?= old('status') == 'aktif' ? 'selected' : '' ?>>Aktif</option>
                        <option value="nonaktif" <?= old('status') == 'nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
                    </select>
                    <div class="invalid-feedback">
                        <?= isset($errors['status']) ? $errors['status'] : '' ?>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary mt-3">Tambah Lapangan</button>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>