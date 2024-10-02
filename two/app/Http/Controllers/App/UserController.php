<?php

namespace App\Http\Controllers\App;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::with('roles')->get();
        return view('app.users.index',['user'=>$user]); 
       }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('app.users.create'); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
           
        $validation=$request->validate([
            'name'=>'required|string|max:225',
            'email'=>'required|email|max:225|unique:users,email',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

       User::create($validation);
        return redirect()->route('users.index')->with('success','Tenant created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $tenant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = Role::get();
        return view('app.users.edit',['user'=>$user,'roles'=>$roles]); 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validation = $request->validate([
            'name' => 'required|string|max:225',
            'email' => 'required|email|max:225|unique:users,email,' . $user->id, // Correcting the unique rule
            // 'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'roles' => 'required|array'
        ]);
    
        $user->update($validation);
        $user->roles()->sync($request->input('roles'));
        
        return redirect()->route('users.index');
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $tenant)
    {
        //
    }
}
