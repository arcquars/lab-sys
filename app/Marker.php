<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Marker extends Model
{
    protected $table = 'markers';

    protected $fillable = [
        'name',
        'description'
    ];

    /**
     * Returns the action column html for datatables.
     *
     * @param \App\Marker
     * @return string
     */
    public static function laratablesCustomAction($marker)
    {
        return view('marcador.includes.action')->with(array('id' => $marker->id))->render();
    }
}
