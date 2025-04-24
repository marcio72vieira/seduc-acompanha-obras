<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Atividade extends Model
{
    use HasFactory;

    protected $table = "atividades";

    protected $fillable = [
        'user_id',
        'obra_id',
        'data_registro',
        'registro',
        'progresso',
        'obraconcluida',
        'observacao',
    ];

    public function obra()
    {
        return $this->belongsTo(Obra::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
