<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Biopsia extends Model
{
    protected $table = 'biopsias';

    const BIOPSIA_RINION = "BIOPSIA DE RIÑON";
    const TIPO_BIOPSIAS = ["BIOPSIA DE RIÑON", "BIOPSIA DE PIEL", "CONJUNTIVA", "MUCOSA"];

    protected $fillable = [
        'organo_tejido',
        'macroscopia',
        'microscopia',
        'diagnostico',
        'user_organo_tejido',
        'user_macroscopia',
        'user_microscopia',
        'user_diagnostico',
        'tipo_biopsia'
    ];

    public function analisis(){
        return $this->belongsTo('App\Analisis', 'analisis_id', 'id');
    }

    public function getTitleBiopsiaAttribute()
    {
        if(!isset($this->tipo_biopsia)){
            return $this::BIOPSIA_RINION;
        }
        return $this->tipo_biopsia;
    }
}
