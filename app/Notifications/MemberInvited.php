<?php

namespace App\Notifications;

use App\Models\DetailCompany;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class MemberInvited extends Notification
{
    use Queueable;

    public function __construct(
        protected DetailCompany $company
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'type'      => 'member_invited',
            'title'     => 'Jemputan untuk Menyertai Komuniti',
            'message'   => "Anda telah dijemput untuk menyertai {$this->company->full_company_name}",
            'community' => [
                'id'   => $this->company->id_detail_company,
                'name' => $this->company->full_company_name,
            ],
        ];
    }
}
