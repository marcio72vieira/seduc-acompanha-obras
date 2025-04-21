<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estatu extends Model
{
    protected $table = "estatus";

    protected $fillable = [
        'tipo',
        'nome',
        'valormin',
        'valormax',
        'cor',
        'ativo'
    ];

    public function obras()
    {
        return $this->hasMany(Obra::class);
    }
}
