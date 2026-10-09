<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Torneo extends Model
{
    protected $fillable = ['nombre', 'juego', 'fecha', 'cupo', 'descripcion', 'abierto'];

    protected function casts(): array
    {
        return [
            'fecha' => 'date',
            'abierto' => 'boolean',
        ];
    }

    public function vencido(): bool
    {
        return $this->fecha->lt(today());
    }

    public function jugadores(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'inscripciones')->withTimestamps();
    }

    public function inscritos(): int
    {
        return $this->jugadores_count ?? $this->jugadores()->count();
    }

    public function lleno(): bool
    {
        return $this->inscritos() >= $this->cupo;
    }

    public function cerrado(): bool
    {
        return ! $this->abierto || $this->vencido() || $this->lleno();
    }

    public function scopeDisponibles(Builder $query): Builder
    {
        return $query->where('abierto', true)
            ->whereDate('fecha', '>=', today())
            ->whereRaw('(select count(*) from inscripciones where inscripciones.torneo_id = torneos.id) < torneos.cupo');
    }
}
