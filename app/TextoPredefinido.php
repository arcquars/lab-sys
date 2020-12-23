<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TextoPredefinido extends Model
{
    protected $table = 'textos_predefinidos';

    protected $fillable = [
        'texto',
    ];

    /**
     * Returns the action column html for datatables.
     *
     * @param \App\Institucion
     * @return string
     */
    public static function laratablesCustomAction($textopre)
    {
        return view('textopredefinido.includes.action')->with(array('id' => $textopre->id))->render();
    }
}
