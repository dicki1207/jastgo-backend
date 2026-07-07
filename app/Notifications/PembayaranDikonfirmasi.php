<?php

namespace App\Notifications;

use App\Models\Pesanan;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class PembayaranDikonfirmasi extends Notification
{
    use Queueable;

    protected $pesanan;

    public function __construct(Pesanan $pesanan)
    {
        $this->pesanan = $pesanan;
    }

    public function via($notifiable)
    {
        // Notifikasi akan disimpan ke database
        return ['database', \App\Channels\FcmChannel::class]; 
    }

        public function toFcm($notifiable)
    {
        $data = $this->toDatabase($notifiable);
        return [
            'title' => $data['jenis_notifikasi'] ?? 'Notifikasi JastGo',
            'body' => strip_tags($data['pesan'] ?? 'Anda memiliki pemberitahuan baru.'),
            'data' => [
                'type' => 'system_notification'
            ]
        ];
    }
    public function toDatabase($notifiable)
    {
        // Data yang akan disimpan ke kolom 'data' di tabel notifikasi
        return [
            'jenis_notifikasi' => 'Pembayaran Masuk',
            'pesan' => 'Pembayaran untuk pesanan ID #' . $this->pesanan->id . ' telah dikonfirmasi Admin. Pesanan siap kamu proses!',
            'pesanan_id' => $this->pesanan->id,
        ];
    }
}