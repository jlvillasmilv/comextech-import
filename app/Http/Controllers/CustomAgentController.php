<?php

namespace App\Http\Controllers;

use App\Models\CustomAgent;
use Illuminate\Http\Request;
use App\Http\Requests\CustomAgentRequest;

class CustomAgentController extends Controller
{
    public function index()
    {
        return view('custom_agents.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('custom_agents.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CustomAgentRequest $request)
    {
        $data = new CustomAgent;
        $data->fill($request->all());
        $data->user_id = auth()->user()->id;
        $data->save();

        $notification = array(
            'message'    => 'Registro actualizado',
            'alert_type' => 'success',);

        \Session::flash('notification', $notification);

        return redirect()->route('custom-agents.edit', base64_encode($data->id));
    }

   
    public function show($id)
    {
        $data = CustomAgent::where([
            ['id',  base64_decode($id)],
            ['user_id', auth()->user()->id],
        ])->firstOrFail();

        if(auth()->user()->hasRole('Admin')) {
            $data = CustomAgent::findOrFail(base64_decode($id));
        }

        return view('custom_agents.show', compact('data'));
    }

   
    public function edit($id)
    {
        $data = CustomAgent::where([
            ['id',  base64_decode($id)],
            ['user_id', auth()->user()->id],
        ])->firstOrFail();

        if(auth()->user()->hasRole('Admin')) {
            $data = CustomAgent::findOrFail(base64_decode($id));
        }

        return view('custom_agents.form', compact('data'));
    }

    
    public function update(CustomAgentRequest $request, $id)
    {
        $data = CustomAgent::findOrFail(base64_decode($id));
        $data->modified_user_id = auth()->user()->id;
        $data->fill($request->all())->save();

        $notification = array(
            'message'    => 'Registro actualizado',
            'alert_type' => 'success',);

        \Session::flash('notification', $notification);

        return redirect()->route('custom-agents.edit', base64_encode($data->id));

    }

    public function list()
    {
        $data = CustomAgent::where('user_id', auth()->user()->id)->get(['id','name','contact_person']);
        return response()->json($data, 200);
    }

    public function customsHouse()
    {
        $admin = User::whereHas('roles', function ($query) {
            $query->where('name', 'Admin');
        })->pluck('id');

        $data = CustomAgent::whereIn('user_id', $admin)->get();
        return response()->json($data, 200);
    }

    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        CustomAgent::where([
            ['id',  base64_decode($id)],
            ['user_id', auth()->user()->id],
        ])->delete();
        
        return response(null, 204);
    }
}
