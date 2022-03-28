<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\Client\UserRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::where('company_id', auth()->user()->company->id)
        ->whereNotin('id', [auth()->user()->id])
        ->with(['roles' => function ($query) {
            $query->select('name','id');
        }])
        ->get();


        return response()->json($users, 200);
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
    public function store(UserRequest $request)
    {
        $user = User::create($request->all());
        $user->company_id = auth()->user()->company->id;
        $user->email_verified_at = date('Y-m-d');
        $user->save();

        $roles = $request->input('role_id') ? $request->input('role_id') : 3;

        $user->assignRole($roles);

        return response()->json($user, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        $user = User::where([
            ['id', $id],
            ['company_id', auth()->user()->company->id]
        ])
        ->firstOrFail();

        $user->fill($request->all())->save();

        $roles = $request->input('role_id') ? $request->input('role_id') : 3;
        $user->syncRoles($roles);
        
        return response()->json($user, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $reponse =  $user->destroy();
        return response()->json($reponse, 200);
    }
}
