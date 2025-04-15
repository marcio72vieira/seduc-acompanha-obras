<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
class Obra extends Model
{
    use HasFactory;

    protected $table = "obras";

    protected $fillable = [
        'tipoobra_id',
        'escola_id',
        'regional_id',
        'municipio_id',
        'data_inicio',
        'data_fim',
        'estatus',       // 1 - Definida/Criada 2 - Iniciada 3 - Em andmento 4 - Parada  5 - Avançada  6 - Concluída 7 -  Inaugurada/Finalizada
        'ativo',          // Sim Não Obs: Uma obra pode assumir qualquer um dos estatus acima, mas pode está desativada, o que não permite o registro das atividades ou execuções da mesma
        'descricao',
    ];


    public function regional()
    {
        return $this->belongsTo(Regional::class);
    }

    public function municipio()
    {
        return $this->belongsTo(Municipio::class);
    }

    public function tipoobra()
    {
        return $this->belongsTo(Tipoobra::class);
    }

    public function escola()
    {
        return $this->belongsTo(Escola::class);
    }

    public function objetos(): BelongsToMany
    {
        return $this->belongsToMany(Objeto::class)->withTimestamps();
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }


}
