<?php

namespace App\Notifications;

use App\Models\Pesanan;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PesananSelesaiJastiper extends Notification
{
    use Queueable;
    protected $pesanan;

    public function __construct(Pesanan $pesanan)
    {
        $this->pesanan = $pesanan;
    }

    public function via($notifiable)
    {
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
        return [
            'jenis_notifikasi' => 'Pesanan Selesai',
            'pesan' => "Selamat! Pesanan ID **#{$this->pesanan->id}** telah diselesaikan oleh Pembeli. Transaksi dinyatakan sukses.",
            'pesanan_id' => $this->pesanan->id,
        ];
    }
}