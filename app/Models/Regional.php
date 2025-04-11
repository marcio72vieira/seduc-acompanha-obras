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


    public function escolas ()
    {
        return $this->hasMany(Escola::class);
    }

    public function obras ()
    {
        return $this->hasMany(Obra::class);
    }

    public function users ()
    {
        return $this->hasMany(User::class);
    }


    // Retorna especificamente (através do método count()) a quantidade de escolas de uma regional através do município.
    public function qtdescolasdaregional()
    {
        return $this->hasManyThrough(Escola::class, Municipio::class)->count();
    }

    // Retorna as escolas da regional através do município.
    public function escolasdaregional()
    {
        return $this->hasManyThrough(Escola::class, Municipio::class);
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
