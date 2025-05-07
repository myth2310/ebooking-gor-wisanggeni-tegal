<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BookingModel;
use CodeIgniter\HTTP\ResponseInterface;
use Midtrans\Snap;
use Midtrans\Config;


class MidtransController extends BaseController
{
    public function get_snap_token()
    {
        $request = service('request');
        $json = $request->getJSON(true);

        $orderId = $json['order_id'];
        $total = (int) $json['total_amount'];

        $bookingModel = new BookingModel();
        $booking = $bookingModel
            ->join('lapangan', 'lapangan.id = booking.id_lapangan')
            ->where('booking.kode_booking', $orderId)
            ->first();

        if (!$booking) {
            return $this->response->setJSON(['error' => 'Booking tidak ditemukan.'])->setStatusCode(404);
        }

        Config::$serverKey = getenv('MIDTRANS_SERVER_KEY');
        Config::$isProduction = getenv('MIDTRANS_IS_PRODUCTION') === 'true';
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $total,
            ],
            'customer_details' => [
                'first_name' => session('nama') ?? 'User',
                'email' => session('email') ?? 'user@example.com',
                'phone' => session('no_hp') ?? '08123456789',
            ],
            'item_details' => [
                [
                    'id' => $booking['id'],
                    'price' => $total,
                    'quantity' => 1,
                    'name' => $booking['nama_lapangan'],
                ]
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            return $this->response->setJSON(['snapToken' => $snapToken]);
        } catch (\Exception $e) {
            log_message('error', 'Midtrans Error: ' . $e->getMessage());
            return $this->response->setJSON(['error' => 'Gagal mendapatkan token'])->setStatusCode(500);
        }
    }

    public function callback()
    {
        $request = file_get_contents("php://input");
        $response = json_decode($request);

        if (!$response) {
            log_message('error', 'Callback gagal: tidak ada data JSON.');
            http_response_code(400);
            return;
        }

        $order_id = $response->order_id ?? null;
        $transaction_status = $response->transaction_status ?? null;
        $payment_type = $response->payment_type ?? null;

        if (!$order_id || !$transaction_status) {
            log_message('error', 'Callback gagal: order_id atau transaction_status kosong.');
            http_response_code(400);
            return;
        }
        try {
            $bookingModel = new \App\Models\BookingModel();
            $updated = $bookingModel->where('kode_booking', $order_id)
                ->set(['status_bayar' => $transaction_status])
                ->update();

            if ($updated) {
                log_message('info', 'Callback sukses untuk order ID: ' . $order_id . ' dengan status: ' . $transaction_status);
            } else {
                log_message('error', 'Callback gagal: gagal update status untuk order ID: ' . $order_id);
            }
        } catch (\Exception $e) {
            log_message('error', 'Callback error exception: ' . $e->getMessage());
            http_response_code(500);
            return;
            
        }
        http_response_code(200);
    }
}
