<?= $this->extend('admin/layouts/base-page') ?>

<?= $this->section('content') ?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Edit Lapangan</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Form Edit Lapangan</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-edit me-1"></i>
            Form Edit Lapangan
        </div>
        <div class="card-body">
            <form action="<?= base_url('admin/lapangan/update/' . $lapangan['id']) ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>

                <div class="form-group mb-3">
                    <label for="nama_lapangan">Nama Lapangan</label>
                    <input type="text" class="form-control <?= isset($errors['nama_lapangan']) ? 'is-invalid' : '' ?>" id="nama_lapangan" name="nama_lapangan" value="<?= old('nama_lapangan', $lapangan['nama_lapangan']) ?>" required>
                    <div class="invalid-feedback">
                        <?= $errors['nama_lapangan'] ?? '' ?>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label for="image">Gambar Lapangan</label>
                    <?php if (!empty($lapangan['image'])): ?>
                        <div class="mb-2">
                            <img src="<?= base_url('uploads/lapangan/' . $lapangan['image']) ?>" alt="Gambar Lapangan" width="150">
                        </div>
                    <?php endif; ?>
                    <input type="file" accept="image/*" class="form-control <?= isset($errors['image']) ? 'is-invalid' : '' ?>" id="image" name="image">
                    <div class="invalid-feedback">
                        <?= $errors['image'] ?? '' ?>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label for="kategori">Kategori Lapangan</label>
                    <select name="id" class="form-control <?= isset($errors['id']) ? 'is-invalid' : '' ?>" id="kategori_id" required>
                        <option value="">-- Pilih Kategori Lapangan --</option>
                        <?php
                        foreach ($categorys as $category) {
                            $selected = old('id', $lapangan['id']) == $category['id'] ? 'selected' : '';
                            echo "<option value=\"{$category['id']}\" $selected>{$category['nama_kategory']}</option>";
                        }
                        ?>
                    </select>
                    <?php if (isset($errors['kategori_id'])): ?>
                        <div class="invalid-feedback"><?= $errors['kategori_id'] ?></div>
                    <?php endif; ?>
                </div>


                <div class="form-group mb-3">
                    <label for="harga_per_jam">Harga Per Jam</label>
                    <input type="number" class="form-control <?= isset($errors['harga_per_jam']) ? 'is-invalid' : '' ?>" id="harga_per_jam" name="harga_per_jam" value="<?= old('harga_per_jam', $lapangan['harga_per_jam']) ?>" required>
                    <div class="invalid-feedback">
                        <?= $errors['harga_per_jam'] ?? '' ?>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label for="deskripsi">Deskripsi (Optional)</label>
                    <textarea class="form-control <?= isset($errors['deskripsi']) ? 'is-invalid' : '' ?>" id="deskripsi" name="deskripsi"><?= old('deskripsi', $lapangan['deskripsi']) ?></textarea>
                    <div class="invalid-feedback">
                        <?= $errors['deskripsi'] ?? '' ?>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label for="status">Status</label>
                    <select class="form-control <?= isset($errors['status']) ? 'is-invalid' : '' ?>" id="status" name="status" required>
                        <option value="">-- Pilih Status --</option>
                        <option value="aktif" <?= old('status', $lapangan['status']) == 'aktif' ? 'selected' : '' ?>>Aktif</option>
                        <option value="nonaktif" <?= old('status', $lapangan['status']) == 'nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
                    </select>
                    <div class="invalid-feedback">
                        <?= $errors['status'] ?? '' ?>
                    </div>
                </div>

                <button type="submit" class="btn btn-success mt-3">Simpan Perubahan</button>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>