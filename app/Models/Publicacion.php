<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publicacion extends Model
{
    use HasFactory;

    protected $table = 'publicaciones';
    protected $fillable = [
        'contenido', 
        'user_id'
    ];

    
    // RELACIONES
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
