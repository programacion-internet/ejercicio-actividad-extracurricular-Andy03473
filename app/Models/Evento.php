<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'fecha',
    ];

    protected $casts = [
        'fecha' => 'date',
    ];

    public function users()
    {
        return $this->belongsToMany(\App\Models\User::class, 'evento_user', 'evento_id', 'user_id');
    }

    // ✅ Relación con archivos
    public function archivos()
    {
        return $this->hasMany(Archivo::class); 
    }

    
}
