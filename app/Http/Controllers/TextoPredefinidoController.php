<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveTextoPost;
use App\Institucion;
use App\TextoPredefinido;
use Freshbitsweb\Laratables\Laratables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TextoPredefinidoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('textopredefinido.home');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('textopredefinido.crear');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  SaveTextoPost  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaveTextoPost $request)
    {
        $texto = new TextoPredefinido();
        $texto->texto = $request->get('texto');
        $texto->user_id = Auth::id();
        $texto->save();

        return redirect()->route('texto-predefinido.index');
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
        $texto = TextoPredefinido::find($id);

        return view('textopredefinido.edit', compact('texto'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  SaveTextoPost  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SaveTextoPost $request, $id)
    {
        $texto = TextoPredefinido::find($id);
        $texto->texto = $request->get('texto');
        $texto->save();
        return redirect()->route('texto-predefinido.index');
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
    public function getDatatablesData()
    {
        return Laratables::recordsOf(TextoPredefinido::class);
    }

    /**
     * Display a listing of the ajaxCreateInstitucion.
     *
     * @return \Illuminate\Http\Response
     */
    public function ajaxCreateTexto(Request $request){
        $textoId = $request->get('id');
        $valid = true;
        if(isset($textoId)){
            $texto = TextoPredefinido::find($textoId);
            $texto->texto = $request->get('texto');
            $valid = $texto->save();
        } else {
            $texto = new TextoPredefinido();
            $texto->texto = $request->get('texto');
            $texto->user_id = Auth::id();
            $valid = $texto->save();
        }
        if($valid) {
            return response()->json(['success'=>true]);
        } else {
            return response()->json(['success'=> false, 'errors' => 'Existe un error por favor contactese con el administrador.']);
        }
    }

    public function ajaxGetTexto(Request $request){
        return response()
            ->json(['success'=> true, 'result' => TextoPredefinido::find($request->get('id'))]);
    }

    public function ajaxDeleteTexto(Request $request){
        $textoId = $request->get('id');
        $valid = TextoPredefinido::find($textoId)->delete();
        if($valid) {
            return response()->json(['success'=>true]);
        } else {
            return response()->json(['success'=> false, 'errors' => 'Existe un error por favor contactese con el administrador.']);
        }
    }
}
