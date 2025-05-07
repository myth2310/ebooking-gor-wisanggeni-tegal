<div class="text-white py-2 fixed-top" style="z-index: 1020; background-color: #003b95;">
    <div class="container d-flex justify-content-between align-items-center">
        <small><i class="bi bi-calendar-check"></i> Cek Jadwal & Booking Sekarang!</small>
    </div>
</div>

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top" style="top: 35px;">
    <div class="container">
        <a class="navbar-brand" style="color: #003b95;" href="/" style="font-weight: 900;">GWT</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarBooking">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarBooking">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" style="color: #003b95;" href="/">Home</a></li>
                <li class="nav-item"><a class="nav-link" style="color: #003b95;" href="/#venue">Venue</a></li>
                <li class="nav-item"><a class="nav-link active" style="color: #003b95;" href="/jadwal">Jadwal</a></li>
            </ul>

            <div class="d-flex align-items-center">
                <a href="/booking" class="btn me-2 text-white" style="background-color: #003b95;"><i class="fa-solid fa-calendar-days" style="margin-right: 10px;"></i>Pesan Cepat</a>

                <?php if (session()->get('isLoggedIn')): ?>
                    <div class="vr mx-2"></div>

                    <a href="/user/profil" style="text-decoration: none; color: #003b95;">
                        <div class="me-3 d-flex align-items-center">
                            <i class="bi bi-person-circle fs-4 me-1"></i>
                            <span style="margin-left: 5px;" class="fw-bold"><?= session()->get('nama') ?></span>
                        </div>
                    </a>

                    <form action="/logout" method="POST">
                        <button class="btn" style="color: #003b95;"><i class="fa-solid fa-right-from-bracket"></i> Logout</button>
                    </form>
                <?php else: ?>
                    <div class="vr mx-2"></div>
                    <a href="/login" class="btn text-white me-2" style="background-color: #003b95;">Masuk</a>
                    <a href="/register" class="btn text-white" style="background-color: #003b95;">Daftar</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>