<?= $this->extend('admin/layouts/base-page') ?>

<?= $this->section('content') ?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>

    <div class="row">

        <!-- Card Omset Harian -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card bg-info text-white h-100">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="card-title">Omset Hari Ini</h5>
                        <h2>Rp <?= number_format($omsetHarian, 0, ',', '.') ?></h2>
                    </div>
                    <i class="fas fa-coins fa-3x"></i>
                </div>
            </div>
        </div>

        <!-- Card Omset Bulan Ini -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card bg-secondary text-white h-100">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="card-title">Omset Bulan Ini</h5>
                        <h2>Rp <?= number_format($omsetBulanan, 0, ',', '.') ?></h2>
                    </div>
                    <i class="fas fa-calendar-alt fa-3x"></i>
                </div>
            </div>
        </div>

        <!-- Card Omset Tahun Ini -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card bg-dark text-white h-100">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="card-title">Omset Tahun Ini</h5>
                        <h2>Rp <?= number_format($omsetTahunan, 0, ',', '.') ?></h2>
                    </div>
                    <i class="fas fa-calendar fa-3x"></i>
                </div>
            </div>
        </div>


        <!-- Card Total Users -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card bg-primary text-white h-100">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="card-title">Total Users</h5>
                        <h2><?= esc($totalUsers) ?></h2>
                    </div>
                    <i class="fas fa-users fa-3x"></i>
                </div>
            </div>
        </div>

        <!-- Card Total Bookings -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card bg-success text-white h-100">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="card-title">Total Bookings</h5>
                        <h2><?= esc($totalBookings) ?></h2>
                    </div>
                    <i class="fas fa-calendar-check fa-3x"></i>
                </div>
            </div>
        </div>

        <!-- Card Total Lapangan -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card bg-warning text-white h-100">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="card-title">Total Lapangan</h5>
                        <h2><?= esc($totalFields) ?></h2>
                    </div>
                    <i class="fas fa-futbol fa-3x"></i>
                </div>
            </div>
        </div>

        <!-- Card Pending Bookings -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card bg-danger text-white h-100">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="card-title">Pending Bookings</h5>
                        <h2><?= esc($pendingBookings) ?></h2>
                    </div>
                    <i class="fas fa-clock fa-3x"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
    <!-- Chart per Bulan -->
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-chart-line me-1"></i>
                Grafik Kenaikan Jumlah Sewa per Bulan
            </div>
            <div class="card-body">
                <canvas id="sewaChart" width="100%" height="30"></canvas>
            </div>
        </div>
    </div>

    <!-- Chart per Tahun -->
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-chart-bar me-1"></i>
                Grafik Jumlah Sewa per Tahun
            </div>
            <div class="card-body">
                <canvas id="sewaChartTahun" width="100%" height="30"></canvas>
            </div>
        </div>
    </div>
</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Script Chart.js -->
<script>
    // Chart Per Bulan (sudah ada)
    const ctx = document.getElementById('sewaChart').getContext('2d');

    const sewaChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?= json_encode($bulan) ?>, 
            datasets: [{
                label: 'Jumlah Sewa',
                data: <?= json_encode($jumlahSewa) ?>, 
                backgroundColor: 'rgba(54, 162, 235, 0.2)', 
                borderColor: 'rgba(54, 162, 235, 1)', 
                borderWidth: 2,
                tension: 0.4, 
                fill: true,
                pointBackgroundColor: 'rgba(54, 162, 235, 1)'
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Chart Per Tahun
    const ctxTahun = document.getElementById('sewaChartTahun').getContext('2d');
    const sewaChartTahun = new Chart(ctxTahun, {
        type: 'bar',
        data: {
            labels: <?= json_encode($tahun) ?>,
            datasets: [{
                label: 'Jumlah Sewa per Tahun',
                data: <?= json_encode($sewaTahunan) ?>,
                backgroundColor: 'rgba(255, 99, 132, 0.5)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>


<?= $this->endSection() ?>