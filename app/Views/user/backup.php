<?= $this->extend('user/layouts/base-page') ?>

<?= $this->section('content') ?>

<!-- FullCalendar CSS -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">

<main class="container my-5">
  <div class="text-center mb-4">
    <h2 class="fw-bold">Jadwal Booking</h2>
    <p class="text-muted">Pilih waktu terbaikmu untuk berolahraga di GOR Wisanggeni.</p>
  </div>

  <div class="alert alert-info mt-4" role="alert">
    Jadwal dapat berubah sewaktu-waktu. Pastikan Anda melakukan booking untuk mengamankan slot favorit Anda!
  </div>

  <!-- Kalender -->
  <div id="calendar"></div>
</main>

<!-- FullCalendar JS -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

<!-- Inisialisasi Kalender -->
<script>
  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      locale: 'id',
      headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay'
      },
      events: [
        {
          title: 'Basket Outdoor 1 (10:00 - 12:00)',
          start: '2025-04-27',
          color: '#198754' // hijau untuk terbooking
        },
        {
          title: 'Stadion Utama (15:00 - 17:00)',
          start: '2025-04-28',
          color: '#198754'
        },
        {
          title: 'Stadion Utama (17:00 - 19:00)',
          start: '2025-04-29',
          color: '#198754'
        },
        {
          title: 'Stadion Utama (17:00 - 19:00) [Dibatalkan]',
          start: '2025-04-29',
          color: '#dc3545' // merah untuk dibatalkan
        }
      ]
    });

    calendar.render();
  });
</script>

<!-- Optional Styling -->
<style>
  #calendar {
    max-width: 100%;
    margin: 0 auto;
  }
</style>

<?= $this->endSection() ?>
