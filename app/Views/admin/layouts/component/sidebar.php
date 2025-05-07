<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">

                <div class="sb-sidenav-menu-heading">Core</div>
                <a class="nav-link" href="<?= base_url('admin/dashboard') ?>">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>

                <div class="sb-sidenav-menu-heading">Manajemen</div>
                <a class="nav-link" href="<?= base_url('admin/users') ?>">
                    <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                    Manajemen User
                </a>
                <a class="nav-link" href="<?= base_url('admin/lapangan') ?>">
                    <div class="sb-nav-link-icon"><i class="fas fa-futbol"></i></div>
                    Manajemen Lapangan
                </a>
                <a class="nav-link" href="<?= base_url('admin/booking') ?>">
                    <div class="sb-nav-link-icon"><i class="fas fa-calendar-check"></i></div>
                    Manajemen Booking
                </a>

                <div class="sb-sidenav-menu-heading">Pengaturan</div>
                <a class="nav-link" href="<?= base_url('admin/aktivitas') ?>">
                    <div class="sb-nav-link-icon"><i class="fas fa-cogs"></i></div>
                    Log Aktivitas
                </a>

            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            Admin
        </div>
    </nav>
</div>
