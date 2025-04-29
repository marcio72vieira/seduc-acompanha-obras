<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;

class Obra extends Model
{
    use HasFactory;

    protected $table = "obras";

    protected $fillable = [
        'tipoobra_id',
        'escola_id',
        #'regional_id',
        #'municipio_id',
        'estatu_id',       // 0 - Definida/Criada 2 - Iniciada 3 - Em andmento 4 - Parada  5 - Avançada  6 - Concluída 7 -  Inaugurada/Finalizada/ // 0 Criada / 1 Fase inicial / 2 Fase Intermediária /  3 Fase Avançada / 4 Concluída /
        'data_inicio',
        'data_fim',
        'ativo',          // Sim Não Obs: Uma obra pode assumir qualquer um dos estatus acima, mas pode está desativada, o que não permite o registro das atividades ou execuções da mesma. A obra pode assumir o status de "parada" quando seu ativo estiver setado como 0
        'descricao',
    ];


    #_public function regional()
    #_{
    #_    return $this->belongsTo(Regional::class);
    #_}
    #_
    #_public function municipio()
    #_{
    #_    return $this->belongsTo(Municipio::class);
    #_}

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

    public function estatu()
    {
        return $this->belongsTo(Estatu::class);
    }

    public function atividades()
    {
        return $this->hasMany(Atividade::class);
    }

    // Retorna o último registro do model Atividade, cujo valor do campo obra_id, seja o $idobra fornecido como parâmetro.
    public function ultimoprogresso($idobra)
    {
        $ultimaatividade = Atividade::latest()->where('obra_id', '=', $idobra )->first();
        // dd($ultimaatividade->registro);  dd($ultimaatividade->progresso); dd($ultimaatividade->observacao);

        // Retorna o camo progresso da última atividade cadastrada
        return $ultimaatividade->progresso;
    }

    public function progressomaximo($idobra)
    {
        $valorprogressomaximo = DB::table('atividades')->where('obra_id', '=', $idobra)->max('progresso');

        if($valorprogressomaximo != null){
            return $valorprogressomaximo;
        }else{
            return 0;
        }
    }


}
