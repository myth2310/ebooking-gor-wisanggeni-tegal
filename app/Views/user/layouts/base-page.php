<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>E-Booking - GOR Wisanggeni Tegal</title>
    <!-- <link rel="icon" type="image/png" href="<?= base_url('images/logo.png') ?>"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link
        href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@100..900&family=Nunito:ital,wght@0,200..1000;1,200..1000&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" href="<?= base_url('images/icon.png') ?>" type="image/x-icon">

</head>

<body>

    <!-- Main Navbar -->
    <?= $this->include('user/layouts/component/navbar') ?>

    <!-- Main Content Section -->
    <main>
        <?php if (session()->getFlashdata('swal_icon')) : ?>
            <script>
                Swal.fire({
                    icon: '<?= session()->getFlashdata('swal_icon') ?>',
                    title: '<?= session()->getFlashdata('swal_title') ?>',
                    text: '<?= session()->getFlashdata('swal_text') ?>',
                });
            </script>
        <?php endif; ?>

        <div class="container pt-4">
            <?= $this->renderSection('content') ?>
        </div>
    </main>

    <!-- Footer -->
    <?= $this->include('user/layouts/component/footer') ?>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>