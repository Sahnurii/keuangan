<?php
class Webhook extends Controller
{
    public function callback()
    {
        // Ambil data dari Midtrans
        $rawData = file_get_contents("php://input");
        $notification = json_decode($rawData, true);

        if (!$notification) {
            http_response_code(400);
            echo "Invalid callback";
            return;
        }

        // Validasi signature (keamanan)
        $serverKey = $_ENV['MIDTRANS_SERVER_KEY'];
        $expectedSignature = hash(
            'sha512',
            $notification['order_id'] .
                $notification['status_code'] .
                $notification['gross_amount'] .
                $serverKey
        );

        if (!isset($notification['signature_key']) || $notification['signature_key'] !== $expectedSignature) {
            http_response_code(403);
            echo "Invalid signature";
            return;
        }

        $transaction_status = $notification['transaction_status'];
        $order_id = $notification['order_id'];

        // Update ke database kamu berdasarkan $order_id
        if ($transaction_status == 'settlement') {
            // Pembayaran sukses
            $this->model('Gaji_model')->updatePaymentStatus($order_id, 'paid');
        } elseif ($transaction_status == 'expire' || $transaction_status == 'cancel') {
            $this->model('Gaji_model')->updatePaymentStatus($order_id, 'failed');
        }

        http_response_code(200);
    }
}
