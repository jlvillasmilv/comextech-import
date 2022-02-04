<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Transport, Port};
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Web\TransportRequest;

class FreightQuotesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('web.freight-quotes.index');   
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
       // dd($request->dataLoad);

       
        try {
                      
            $transport_amount = is_null($request->app_amount) ? 0 : $request->app_amount;

            $rate_insurance_transp = \DB::table('settings')->first(['min_rate_transp'])->min_rate_transp;

            $amount = 0;

          
            $cif = $amount + $transport_amount;
            $oth_exp  = 0;
            $fee_date = $request->estimated_date;
            $local_transp = 0;
            $from_port_transport = '';
            $to_port_transport   = '';

          

            $insurance_amount = $cif * 0.015 > $rate_insurance_transp ? $cif * 0.015 : $rate_insurance_transp;

            if($request->type_transport == "CONTAINER" || $request->type_transport == "CONSOLIDADO")
            {
                
                $total_weight = 0;
                foreach ($request->dataLoad as $key => $item) {
                    
                    $cargo[]  = $item;

                    $container_name = \DB::table('category_containers')->where('id', $item['type_container'])
                        ->first('name')->name;

                    $cargo[$key]['container_name'] = $container_name;

                    $total_weight += $item['weight'];
                }

                $data = [
                    'commodity'      => $amount,
                    'from'           => Port::where('id', $request->origin_port_id)->firstOrFail()->unlocs,
                    'to'             => Port::where('id', $request->dest_port_id)->firstOrFail()->unlocs,
                    'type_transport' => $request->type_transport,
                    'weight'         => $total_weight/1000,
                    'cargo'          => $cargo,
                ];
                
                $transp = Transport::rateTransport($data);

                if($request->dest_port_id > 0 && strlen($request->dest_address) > 0)
                {
                    $local_transp = Transport::rateLocalTransport($request->only([
                        'dest_port_id,',
                        'dest_province',
                        'dest_address',
                        'fav_dest_address',
                        'dataLoad',
                        'mode_selected'
                    ]));

                }

                $transport_amount  = $transp['int_trans'];
                $cif               = $transp['cif'];
                $oth_exp           = $transp['oth_exp'];
                $t_time            = $transp['t_time'];
                $insurance_amount  = $transp['insurance'];
                $currency_id       = 1;
              
                $fee_date = date('Y-m-d', strtotime($request->estimated_date. ' + '.$t_time.' day'));

            }

            $trans_summary = [
                'transport_amount' => round($transport_amount, 2),
                'cif'              => $cif,       
                'oth_exp'          => $oth_exp,  
                'insurance'        => $request->insurance ?  round($insurance_amount, 2) : 0,
                'local_transp'     => round($local_transp, 2)
            ];

        DB::commit();

        } catch (Throwable $e) {
            DB::rollback();
            return response()->json(['status' => $e], 500);
        }
        return response()->json(['transport' => $trans_summary], 200);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
