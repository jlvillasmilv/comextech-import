<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CategoryServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('category_services.index')) {
            return abort(401);
        }
        
        return view('admin.category_services.index');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('category_services.create')) {
            return abort(401);
        }

        return view('admin.category_services.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = new CategoryService;
        $data->user_id = auth()->user()->id;
        $data->fill($request->all());
        $data->save();

        $notification = array(
            'message'    => 'Registro Agregado',
            'alert_type' => 'success',);

        \Session::flash('notification', $notification);

        return redirect()->route('admin.category_services.edit', $data->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CategoryService  $categoryService
     * @return \Illuminate\Http\Response
     */
    public function show(CategoryService $data)
    {
        if (! Gate::allows('currency.show')) {
            return abort(401);
        }

        return view('admin.category_services.form', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CategoryService  $categoryService
     * @return \Illuminate\Http\Response
     */
    public function edit(CategoryService $data)
    {
        if (! Gate::allows('currency.edit')) {
            return abort(401);
        }

        return view('admin.category_services.form', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CategoryService  $categoryService
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = CategoryService::findOrFail($id);
        $data->modified_user_id = auth()->user()->id;
        $data->fill($request->all())->save();

        $notification = array(
            'message'    => 'Registro actualizado',
            'alert_type' => 'success',);

        \Session::flash('notification', $notification);

        return redirect()->route('admin.currencies.edit', $data->id);
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CategoryService  $categoryService
     * @return \Illuminate\Http\Response
     */
    public function destroy(CategoryService $categoryService)
    {
        $data = CategoryService::findOrFail($id);
        $data->status = false;
        $data->save();

    }
}
