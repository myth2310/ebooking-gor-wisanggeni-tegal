<?= $this->extend('admin/layouts/base-page') ?>

<?= $this->section('content') ?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Log Aktivitas</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Data Log Aktivitas</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-history me-1"></i> Riwayat Aktivitas User
            </div>
            <div>
                <form method="get" action="">
                    <input type="date" name="tanggal" value="<?= date('Y-m-d') ?>" class="form-control" onchange="this.form.submit()" />
                </form>
            </div>
        </div>
        <div class="card-body">
            <p class="text-success">Data untuk tanggal: <strong><?= date('d-m-Y', strtotime($tanggal ?? date('Y-m-d'))) ?></strong></p>

            <div class="table-responsive">
                <table class="table" id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Aktivitas</th>
                            <th>Device</th>
                            <th>IP Address</th>
                            <th>Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($logs as $log): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $log['user'] . ' ' . $log['aktivitas'] ?></td>
                                <td><?= $log['device'] ?></td>
                                <td><?= $log['ip_address'] ?></td>
                                <td><?= date('d-m-Y H:i:s', strtotime($log['created_at'])) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
