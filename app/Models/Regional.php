<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Regional extends Model
{
    use HasFactory;

    protected $table = "regionais";

    protected $fillable = [
        'nome',
        'ativo'
    ];

    public function municipios ()
    {
        return $this->hasMany(Municipio::class);
    }


   /*  public function unidadesatendimentos ()
    {
        return $this->hasMany(Unidadeatendimento::class);
    } */

    public function users ()
    {
        return $this->hasMany(User::class);
    }

    public function countmunicipios ()
    {
        return $this->hasMany(Municipio::class)->count();
    }

    //Obtendo a quantidade de municípios de uma regional, de um outro jeito
    public function qtdmunicipiosvinc($id)
    {
        $qtd = DB::table('municipios')->where('regional_id', '=', $id)->count();

        return $qtd;
    }

}
