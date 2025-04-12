<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Objeto extends Model
{
    use HasFactory;

    protected $table = "objetos";

    protected $fillable = [
        'nome',
        'ativo'
    ];

    public function obras(): BelongsToMany
    {
        return $this->belongsToMany(Obra::class)->withTimestamps();
    }
}
