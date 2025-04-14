<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tipoobra extends Model
{
    protected $table = "tipoobras";

    protected $fillable = [
        'nome',
        'ativo'
    ];

    public function obra()
    {
        return $this->hasMany(Obra::class);
    }
}
