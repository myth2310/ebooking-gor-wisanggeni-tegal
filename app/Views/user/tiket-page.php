<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Tiket eBooking Gor Wisanggeni Tegal - <?= $booking['kode_booking'] ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            color: #333;
        }
        .ticket-container {
            border: 2px dashed #333;
            padding: 20px;
            width: 100%;
            max-width: 600px; 
            margin: auto;
        }
        .ticket-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .ticket-header h5 {
            text-align: center;
            margin: 0;
        }
        .ticket-header h2 {
            margin: 0;
        }
        .ticket-details {
            margin-top: 10px;
            font-size: 16px;
        }
        .detail-item {
            margin-bottom: 10px;
        }
        .label {
            font-weight: bold;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }

    </style>
</head>
<body>
    <div class="ticket-container">
        <div class="ticket-header">
            <h2>TIKET BOOKING LAPANGAN</h2>
            <h5>Gor Wisanggeni Tegal</h5>
            <p>Kode Booking: <strong><?= $booking['kode_booking'] ?></strong></p>
        </div>

        <div class="ticket-details">
            <div class="detail-item"><span class="label">Nama Lapangan:</span> <?= $booking['nama_lapangan'] ?></div>
            <div class="detail-item"><span class="label">Tanggal:</span> <?= date('d M Y', strtotime($booking['tanggal_booking'])) ?></div>
            <div class="detail-item"><span class="label">Jam:</span> <?= $booking['jam_mulai'] ?> - <?= $booking['jam_selesai'] ?></div>
            <div class="detail-item"><span class="label">Total Bayar:</span> Rp <?= number_format($booking['total_bayar'], 0, ',', '.') ?></div>
        </div>

        <div class="footer">
            Tunjukkan tiket ini saat datang ke lokasi. Terima kasih telah melakukan pemesanan.
        </div>
    </div>
</body>
</html>
