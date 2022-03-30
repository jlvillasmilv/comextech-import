<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Company, User, TransCompany, JumpSellerUser};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use App\Http\Requests\UserRequest;

class UserController extends Controller
{
   public function index()
    {
        if (! Gate::allows('user.index')) {
            return abort(401);
        }

        return view('admin.users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('user.create')) {
            return abort(401);
        }

        return view('admin.users.form');
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
            $roles = $request->input('roles') ? $request->input('roles') : '';
            $user->assignRole($roles);

            if($user->hasRole('Cliente')){
                do {
                    $code = Str::upper(Str::random(6));
                } while (Company::where("tax_id", "=", $code)->first());

                $company = Company::create([
                    'tax_id'        => $code,
                    'name'          => $request->input('name'),
                    'email'         => $request->input('email'),
                    'contact_name'  => $request->input('name'),
                    'country_id'    => 41
                ]);

                $user->company_id =  $company->id;
                $user->save();

                $trans_company  = TransCompany::get();

                foreach ($trans_company as $key => $company) {
                    $user->discount()->create([
                        'trans_company_id' => $company->id,
                        'imp_a' => 60
                    ]);
                }
                
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
        
               $user_jumpseller = JumpSellerUser::createJumpSellerUser($data);
        
               if(isset($user_jumpseller["id"]) || $user_jumpseller["id"] > 0 )
               {
                    $user->jumpSellerUser()->create([
                        'customer_id' => $user_jumpseller["id"]
                    ]);
               }

               
            }

            DB::commit();

            } catch (Throwable $e) {
                DB::rollback();
                return redirect()->back();
            }

            $notification = array(
                'message'    => 'Registro actualizado',
                'alert_type' => 'success',);

            \Session::flash('notification', $notification);

            return redirect()->route('admin.users.edit', $user->id);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data  = User::findOrFail($id);

        return view('admin.users.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('currency.edit')) {
            return abort(401);
        }

        $data  = User::findOrFail($id);

        return view('admin.users.form', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        $user = User::findOrFail($id);

        $user->fill($request->all())->save();

        $roles = $request->input('roles') ? $request->input('roles') : '';
        $user->syncRoles($roles);

        $notification = array(
            'message'    => 'Registro actualizado',
            'alert_type' => 'success',);

        \Session::flash('notification', $notification);

        return redirect()->route('admin.users.edit', $user->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('user.destroy')) {
            return abort(401);
        }

        User::findOrFail($id)->delete();
        return response(null, 204);
    }

}
