<?php

namespace App\Notifications;

use App\Models\Pesanan;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PembayaranUserBaru extends Notification
{
    use Queueable;

    protected $pesanan;

    public function __construct(Pesanan $pesanan)
    {
        $this->pesanan = $pesanan;
    }

    public function via($notifiable)
    {
        return ['database', \App\Channels\FcmChannel::class]; // Dikirim ke tabel notifications
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
        $totalHarga = number_format($this->pesanan->total_harga, 0, ',', '.');
        
        return [
            'jenis_notifikasi' => 'Pembayaran Baru',
            'pesan' => "Pembayaran baru (Rp $totalHarga) telah diunggah untuk Pesanan ID #{$this->pesanan->id}. Mohon konfirmasi segera.",
            'pesanan_id' => $this->pesanan->id,
            'user_pembeli_id' => $this->pesanan->user_id,
        ];
    }
}