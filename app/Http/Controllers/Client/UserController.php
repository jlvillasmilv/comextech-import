<?php

namespace App\Http\Controllers\Client;

use App\Models\{User, JumpSellerUser, TransCompany};
use App\Http\Controllers\Controller;
use App\Http\Requests\Client\UserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        DB::beginTransaction();

        try {

            $user = User::create($request->all());
            $user->company_id = auth()->user()->company->id;
            $user->email_verified_at = date('Y-m-d');
            $user->save();

            $roles = $request->input('role_id') ? $request->input('role_id') : 3;

            $user->assignRole($roles);

            \DB::table('user_mark_ups')->insert(['user_id' => $user->id]);

            $data = [
                "customer" => [
                    "name"      => $request->input('name'),
                    "surname"   => $request->input('name'),
                    "email"     => $request->input('email'),
                    "phone"     => "00000000",
                    "password"  => 'COMEXTECH.'.date('Ymd'),
                    "status"    => "approved",
                    "billing_addresses" => [
                        [
                            "name"          => $request->input('name'),
                            "surname"       => $request->input('name'),
                            "address"       => "...",
                            "city"          => "...",
                            "postal"        => "0000",
                            "country"       => "CL",
                            "region"        => "12",
                            "taxid"         => null,
                            "primary"       => true,
                            "municipality"  => "Las Condes"
                        ]
                    ],
                ]
            ];

            $trans_company  = TransCompany::get();

            foreach ($trans_company as $key => $company) {
                $user->discount()->create([
                    'trans_company_id' => $company->id,
                    'imp_a' => 60
                ]);
            }

            $user_jumpseller = JumpSellerUser::createJumpSellerUser($data);
            
            if(isset($user_jumpseller["id"]) || $user_jumpseller["id"] > 0 )
            {
                $user->jumpSellerUser()->create([
                    'customer_id' => $user_jumpseller["id"]
                ]);
            }

            DB::commit();

        } catch (Throwable $e) {
            DB::rollback();
            return redirect()->back();
        }

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
