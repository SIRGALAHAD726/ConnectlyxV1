<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolicitudAmigo extends Model
{
    protected $table = 'solicitudes_amigos';
    use HasFactory;

    protected $fillable = ['sender_id', 'receiver_id', 'status'];

    // RELACIONES
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
    public function scopePendientesPara($query, $userId)
    {
        return $query->where('receiver_id', $userId)->where('status', 'pending')->with('sender');
    }
}
