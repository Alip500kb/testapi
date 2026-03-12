<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenthicatable;
use Laravel\Sanctum\HasApiTokens;

class pemain extends Authenthicatable
{
    use Notifiable, HasApiTokens;
    protected $fillable = [
        'id',
        'username',
        'password',
        'last_login_at',
        'deleted_at',
        'delete_reason'
        ];

    public function getAuthPassword(): string {
        return $this->password;
    }
}
