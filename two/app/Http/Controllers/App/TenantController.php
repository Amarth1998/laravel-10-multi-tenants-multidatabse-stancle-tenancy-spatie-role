<?php

namespace App\Http\Controllers\App;

use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;

class TenantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tenants = Tenant::with('domains')->get();
        return view('tenants.index',['tenants'=>$tenants]); 
       }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tenants.create'); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
           
        $validation=$request->validate([
            'name'=>'required|string|max:225',
            'email'=>'required|email|max:225',
            'domain_name'=>'required|string|max:225|unique:domains,domain',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        $tenant = Tenant::create($validation);
        $tenant->domains()->create([
            'domain' => $validation['domain_name'].'.'.config('app.domain')
        ]);
        return redirect()->route('tenants.index')->with('success','Tenant created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tenant $tenant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tenant $tenant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tenant $tenant)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tenant $tenant)
    {
        //
    }
}
