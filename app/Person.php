<?php
namespace App;

use Carbon\Carbon;
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
        'f_nacimiento',
        'apellido_materno',
        'edad'
    ];

//    protected $dates = [
//        'f_nacimiento',
//    ];

    public function getYearNowAttribute(){
        if($this->edad > 0){
            return $this->edad;
        }
        return Carbon::parse($this->attributes['f_nacimiento'])->age;
    }

    public function getMonthNowAttribute(){
        if($this->edad > 0){
            return $this->edad;
        }
        return Carbon::parse($this->attributes['f_nacimiento'])->month;
    }

    public function getAgeByDate($date){
        if($this->edad > 0){
            return $this->edad;
        }
        $fNacimiento = Carbon::create($this->attributes['f_nacimiento']);
        $age = $fNacimiento->diff($date)->format('%y años, %m meses %d dias');
        return $age;
    }

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

    public function isSisNombreApellido(){
        $isPersonaSinNombre = false;
        if(strcmp($this->nombres, 'Sin nombre') == 0 &&
            strcmp($this->apellidos, 'Sin apellido') == 0){
            $isPersonaSinNombre = true;
        }
        return $isPersonaSinNombre;
    }

    public function getFullnameAttribute(){
        return $this->nombres . " " . $this->apellidos . " " . $this->apellido_materno;
//        return "xxx";
    }


}
