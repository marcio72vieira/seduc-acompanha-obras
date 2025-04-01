<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Objeto extends Model
{
    protected $table = "objetos";

    protected $fillable = [
        'nome',
        'ativo'
    ];
}
