<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Obra extends Model
{
    use HasFactory;

    protected $table = "obras";

    protected $fillable = [
        'descricao',
        'regional_id',
        'municipio_id',
        'data_inicio',
        'data_fim',
        'estatus',       // 1 - Definida/Criada 2 - Iniciada 3 - Em andmento 4 - Parada  5 - Avançada  6 - Concluída 7 -  Inaugurada/Finalizada
        'ativo'          // Sim Não Obs: Uma obra pode assumir qualquer um dos estatus acima, mas pode está desativada, o que não permite o registro das atividades ou execuções da mesma
    ];
}
