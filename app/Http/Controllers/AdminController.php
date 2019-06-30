<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
            $users = User::paginate(5);
            return view('admin.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
            $roles = Role::all();
            return view("admin.create", compact("roles"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:2|max:50',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|string',
        ]);
     $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);
        $user->roles()->sync($request['role']);
        return redirect()->route('admin.index')
            ->with('success','User created successfully');
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
        $user = User::find($id);
        $roles = Role::all();
        return view('admin.edit',compact('user','roles'));
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
        $request->validate([
            'name' => 'required|min:2|max:50',
            'email' => ['required', 'email', Rule::unique('users')->ignore($id)],
            'role' => 'required|string',
        ]);
           $user=User::find($id);
           $user->name = $request['name'];
           $user->email= $request['email'];
           $user->save();
           $user->roles()->sync($request['role']);
        return redirect()->route('admin.index')
            ->with('success','User edited successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('admin.index')
            ->with('success','User deleted successfully');
    }
    /**
    edit password
     */
    public function edit_password($id)
    {
        $user = User::find($id);
        return view('admin.edit-password',compact('user'));
    }
    /**
     update password
     */
    public function update_password(Request $request, $id)
    {
        $request->validate([
            'password' => 'required|min:6|confirmed',
        ]);
        $user=User::find($id);

        $user->password = Hash::make($request['password']);
        $user->save();
        return redirect()->route('admin.index')
            ->with('success','User password changed successfully');
    }
}
