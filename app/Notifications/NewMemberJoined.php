<?php

namespace App\Notifications;

use App\Models\DetailCompany;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewMemberJoined extends Notification
{
    use Queueable;

    public function __construct(
        protected User $member,
        protected ?DetailCompany $company = null
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        $communityName = optional($this->company)->full_company_name ?? 'Komuniti';

        return [
            'type'      => 'new_member_joined',
            'title'     => 'Ahli Baharu Telah Menyertai',
            'message'   => "{$this->member->fullname} telah menyertai {$communityName}",
            'member'    => [
                'id'    => $this->member->id,
                'name'  => $this->member->fullname,
                'email' => $this->member->email,
                'phone' => $this->member->phone_number,
            ],
            'community' => $this->company ? [
                'id'   => $this->company->id_detail_company,
                'name' => $this->company->full_company_name,
            ] : null,
        ];
    }
}
