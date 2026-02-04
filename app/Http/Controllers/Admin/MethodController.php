<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Method;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MethodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $methods = Method::orderBy('name', 'asc')->get();
        return view('admin.methods.index', compact('methods'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
        $request->validate(['name' => 'required|unique:methods,name']);
        
        Method::create([
            'name' => strtoupper($request->name),
            'user_id' => Auth::id()
        ]);

        return redirect()->route('methods.index')->with('status', 'Método creado correctamente.');
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
     * @param  Method $method
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Method $method)
    {
        $request->validate(['name' => 'required|unique:methods,name,' . $method->id]);
        
        $method->update([
            'name' => strtoupper($request->name)
        ]);

        return redirect()->route('methods.index')->with('status', 'Método actualizado.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Method $method
     * @return \Illuminate\Http\Response
     */
    public function destroy(Method $method)
    {
        $method->delete();
        return redirect()->route('methods.index')->with('status', 'Método eliminado.');
    }
}
