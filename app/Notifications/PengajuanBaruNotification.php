<?php

namespace App\Notifications;

use App\Models\Pengajuan;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Notifications\Notification;

class PengajuanBaruNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Pengajuan $pengajuan
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'title' => 'Pengajuan Baru Masuk',
            'body' => "Pengajuan dari {$this->pengajuan->name} telah masuk dan menunggu untuk diproses.",
            'actions' => [
                [
                    'label' => 'Lihat Detail',
                    'url' => "/admin/pengajuans/{$this->pengajuan->id}",
                ],
                [
                    'label' => 'WhatsApp',
                    'url' => $this->pengajuan->whatsapp_url,
                    'openInNewTab' => true,
                ]
            ],
            'icon' => 'heroicon-o-document-text',
            'iconColor' => 'success',
            'data' => [
                'pengajuan_id' => $this->pengajuan->id,
                'pengajuan_name' => $this->pengajuan->name,
                'pengajuan_phone' => $this->pengajuan->no_tlp,
            ]
        ];
    }
}
