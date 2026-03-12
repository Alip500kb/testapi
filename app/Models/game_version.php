<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class game_version extends Model
{
    use Notifiable, HasFactory;
    protected $fillable = [
        'id',
        'game_id',
        'version',
        'storage_path',
        'deleted_at'
    ];
}
