<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserPost;
use App\Role;
use App\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UsersController extends Controller
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
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        if(Gate::denies('edit-users')){
            return redirect(route('admin.users.index'));
        }

        $user = null;
        $roles = Role::all();

        return view('admin.users.edit')->with([
            'user' => $user,
            'roles' => $roles
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreUserPost  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserPost $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
//        dd($user);
        $user->save();
        $user->roles()->sync($request->roles);
        $user->save();
        return redirect()->route('admin.users.index');
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
        if(Gate::denies('edit-users')){
            return redirect(route('admin.users.index'));
        }

        $user = User::find($id);
        $roles = Role::all();

        return view('admin.users.edit')->with([
            'user' => $user,
            'roles' => $roles
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\StoreUserPost  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUserPost $request, $id)
    {
        $user = User::find($id);
        $user->roles()->sync($request->roles);

        $user->name = $request->name;
        $user->email = $request->email;

        if(isset($request->password)){
            $user->password = Hash::make($request->password);
        }
//        dd($user);
        $user->save();

        return redirect()->route('admin.users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Gate::denies('delete-users')){
            return redirect(route('admin.users.index'));
        }
        $user = User::find($id);
        $user->roles()->detach();
        $user->delete();

        return redirect()->route('admin.users.index');
    }

    public function aGetUser($userId){
        $user = User::find($userId);
        return response()->json(['success' => true, 'user' => $user]);
    }

    public function aActiveUser(Request $request){
        $user = User::find($request->post('user_id'));
        if($user->active){
            $user->active = 0;
        } else {
            $user->active = 1;
        }
//        return response()->json(['success' => true, 'active' => $user->active]);
        $user->save();
        return response()->json(['success' => true]);
    }
}
