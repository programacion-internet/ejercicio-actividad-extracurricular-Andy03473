<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Archivo extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'evento_id',
        'nombre',
        'ruta',
    ];

    // ✅ Relación inversa con Evento
    public function evento()
    {
        return $this->belongsTo(Evento::class, 'evento_id');
    }

    // ✅ Relación con User (opcional, pero útil)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
