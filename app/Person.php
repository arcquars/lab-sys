<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'persons';

    protected $fillable = [
        'ci',
        'nombres',
        'apellidos',
        'edad'
    ];


    /**
     * Returns the action column html for datatables.
     *
     * @param \App\User
     * @return string
     */
    public static function laratablesCustomAction($person)
    {
        return view('clients.includes.action')->with(array('id' => $person->id))->render();
    }
    /**
     * Returns the name column value for datatables.
     *
     * @param \App\Models\Person
     * @return string
     */
    public static function laratablesCustomName($person)
    {
        return $person->first_name . ' ' . $person->last_name;
    }
    /**
     * Additional columns to be loaded for datatables.
     *
     * @return array
     */
    public static function laratablesAdditionalColumns()
    {
        return ['nombres', 'apellidos'];
    }
    /**
     * first_name column should be used for sorting when name column is selected in Datatables.
     *
     * @return string
     */
    public static function laratablesOrderName()
    {
        return 'apellidos';
    }
    /**
     * Adds the condition for searching the name of the user in the query.
     *
     * @param \Illuminate\Database\Eloquent\Builder
     * @param string search term
     * @param \Illuminate\Database\Eloquent\Builder
     */
    public static function laratablesSearchName($query, $searchValue)
    {
        return $query->orWhere('nombres', 'like', '%'. $searchValue. '%')
            ->orWhere('apellidos', 'like', '%'. $searchValue. '%')
            ;
    }
    /**
     * Returns string status from boolean status for the datatables.
     *
     * @return string
     */
    public function laratablesActive()
    {
        return $this->active ? 'Active' : 'Inactive';
    }



}
