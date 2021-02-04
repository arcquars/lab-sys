<?php

namespace App\Http\Controllers;

use App\Analisis;
use App\DataTables\PersonsDataTable;
use App\Http\Requests\StorePersonPost;
use App\Institucion;
use App\Person;
use Freshbitsweb\Laratables\Laratables;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Config;
use Validator;

class ClientController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $procedencias = Institucion::all();
        $tipoAnalisis = Config::get('clinica.tipo_analisis');
        return view('clients.home', compact('procedencias', 'tipoAnalisis'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        dd("xxxx");
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }





    /**
     * return data of the simple datatables.
     *
     * @return Json
     */
    public function getSimpleDatatablesData(Request $request)
    {
        $columns = $request->get('columns');
        $searchNombres = isset($columns[1]['search']['value'])? $columns[1]['search']['value'] : '';
        $searchApePa = isset($columns[2]['search']['value'])? $columns[2]['search']['value'] : '';
        $searchApeMa = isset($columns[3]['search']['value'])? $columns[3]['search']['value'] : '';
        return Laratables::recordsOf(Person::class, function($query) use ($searchNombres, $searchApePa, $searchApeMa){
            return $query->where('nombres', 'like', '%'.$searchNombres.'%')
                ->where('apellidos', 'like', '%'.$searchApePa.'%')
                ->where(function($q) use ($searchApePa){
                    $q->whereNull('apellidos')
                        ->orWhere('apellidos', 'like', '%'.$searchApePa.'%');
                })
                ->where(function($q) use ($searchApeMa){
                    $q->whereNull('apellido_materno')
                        ->orWhere('apellido_materno', 'like', '%'.$searchApeMa.'%');
                });
        });
    }

    /**
     * return data of the Custom columns datatables.
     *
     * @return Json
     */
    public function getCustomColumnDatatablesData()
    {

        return Laratables::recordsOf(Person::class);
    }
    /**
     * return data of the relation columns datatables.
     *
     * @return Json
     */
    public function getRelationshipColumnDatatablesData()
    {
        return Laratables::recordsOf(Product::class);
    }
    /**
     * return data of the Extra data datatables attribute data.
     *
     * @return Json
     */
    public function getExtraDataDatatablesAttributesData()
    {
        return Laratables::recordsOf(Person::class);
    }


    /**
     * Display a listing of the ajaxCreatePerson.
     *
     * @return \Illuminate\Http\Response
     */
    public function ajaxCreatePerson(StorePersonPost $request){
//        dd($request->get('f_nacimiento'));
        $personId = $request->get('id');
        $valid = true;
        if(isset($personId)){
            $valid = $this->updatePerson($request);
        } else {
            $valid = $this->createPerson($request);
        }
        if($valid) {
            return response()->json(['success'=>true, 'url' => route('analisis.crearanalisis', ['personId' => $valid])]);
        } else {
            return response()->json(['success'=> false, 'errors' => 'Existe un error por favor contactese con el administrador.']);
        }
    }

    public function ajaxGetPerson(Request $request){
        return response()
            ->json(['success'=> true, 'person' => Person::find($request->get('personId'))]);
    }

    private function createPerson($request){
        $person = new Person();
        $person->ci = $request->get('ci');
        $person->nombres = $request->get('nombres');
        $person->apellidos = $request->get('apellidos');
        $person->apellido_materno = $request->get('apellido_materno');
        $person->f_nacimiento = $request->get('f_nacimiento');
        $person->sexo = $request->get('sexo');

        if($person->save()) {
            return $person->id;
        }
        return false;
    }

    private function updatePerson($request){
        $person = Person::find($request->get('id'));
        $person->ci = $request->get('ci');
        $person->nombres = $request->get('nombres');
        $person->apellidos = $request->get('apellidos');
        $person->apellido_materno = $request->get('apellido_materno');
        $person->f_nacimiento = $request->get('f_nacimiento');
        $person->sexo = $request->get('sexo');

        if($person->update()) {
            return true;
        }
        return false;
    }

    /**
     * Display a listing of the ajaxSearchPerson.
     *
     * @return \Illuminate\Http\Response
     */
    public function ajaxSearchPerson(Request $request){
        $ci = $request->post('ci');
        $nombres = $request->post('nombres');
        $apellidos = $request->post('apellidos');
        $apellido_materno = $request->post('apellido_materno');
        $edad = $request->post('edad');

        $query = '';
        if(isset($ci)){
            $query .= "ci like '%".$ci."%' AND ";
        }
        if(isset($nombres)){
            $query .= "nombres like '%".$nombres."%' AND ";
        }
        if(isset($apellidos)){
            $query .= "apellidos like '%".$apellidos."%' AND ";
        }
        if(isset($apellido_materno)){
            $query .= "apellido_materno like '%".$apellido_materno."%' AND ";
        }
        if(isset($edad)){
            $query .= "edad like '%".$edad."%' AND ";
        }

        $query .= " 1=1 ";
        $persons = Person::query()->whereRaw($query, [])->limit(5)->get();
        return response()->json(['success'=>true, 'persons' => $persons]);
    }

    public function deleteDuplicados()
    {
        return view('clients.duplicados');
    }

    public function pDeleteDuplicados(Request $request)
    {
        $ids = explode(',', $request->get('ids'));
        $count = 0;
        $idMain = 0;
        foreach ($ids as $id){
            if($count==0){
                $idMain = $id;
            }
            $count++;
        }

        foreach ($ids as $id){
            if($idMain!=$id){
                $analisis = Analisis::where('person_id', '=', $id)->get();
                foreach ($analisis as $analisi){
                    $analisi->person_id = $idMain;
                    $analisi->save();
                }
                Person::destroy($id);
            }
        }

        dd($request->get('ids'));
//        return view('clients.duplicados');
    }
}
