<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Biopsia extends Model
{
    protected $table = 'biopsias';

    protected $fillable = [
        'organo_tejido',
        'macroscopia',
        'microscopia',
        'diagnostico',
        'user_organo_tejido',
        'user_macroscopia',
        'user_microscopia',
        'user_diagnostico'
    ];
}
