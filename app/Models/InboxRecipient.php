<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InboxRecipient extends Model
{
    use HasFactory;

    protected $table = "tb_inbox_recipient";

    public function inbox() {
        return $this->belongsTo('App\Models\Inbox', 'id_inbox');
    }
}
