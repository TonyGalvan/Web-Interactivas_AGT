<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Receta extends Model
{
    protected $fillable = [
        'titulo',
        'categoria',
        'tiempo_minutos',
        'dificultad',
        'ingredientes',
        'pasos',
        'nota',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
