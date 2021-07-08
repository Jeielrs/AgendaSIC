<?php

namespace App\Http\Controllers;

use App\Models\Tecnico;
use App\Models\Veiculo;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use DataTables;
use Validator;

class VeiculoController extends Controller
{
    /**
     * Exibe uma listagem dos recursos
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $tecnicos = Tecnico::all();
        if ($request->ajax()) {            
            $data = Veiculo::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    $button = '<a href="#" class="show" id="'.$data->id.'"><i class="fas fa-eye text-info"></i></a>';
                    $button .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" class="edit" id="'.$data->id.'"><i class="fas fa-edit text-warning"></i></a>';
                    $button .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" class="delete" id="'.$data->id.'"><i class="fas fa-trash-alt text-danger"></i></a>';
                    return $button;
                })
                ->setRowAttr([
                    'style' => function() {
                        return "font-size:14px; white-space : nowrap;";
                    },
                    #'class' => function() {
                    #    return "text-center";
                    #},
                ])
                ->setRowClass(function ($row) {
                    if ( $row->situation == 'livre') {
                        $row->situation = 'alert-success';
                    } elseif ($row->situation == 'em_uso') {
                        $row->situation = 'alert-warning';
                    }else {
                        $row->situation = 'alert-danger';
                    }
                    return $row->situation;
                })
                ->editColumn('situation', function ($row) {
                    if ($row->situation === 'livre'){
                        $situation = 'Livre';
                    }elseif ($row->situation === 'em_uso') {
                        $situation = 'Em uso';
                    }
                    elseif ($row->situation === 'inativo') {
                        $situation = 'Inativo';
                    }
                    return $situation;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        session_start();
        if($_SESSION['nivel'] == 'admin'){
            return view('veiculos.admin.index', ['tecnicos' => $tecnicos]);
        }        
        elseif ($_SESSION['nivel'] == 'manager') {
            return view('veiculos.manager.index', ['tecnicos' => $tecnicos]);
        }        
        elseif ($_SESSION['nivel'] == 'user') {
            return view('veiculos.user.index', ['tecnicos' => $tecnicos]);
        }
        //return view('veiculos')->with(compact('tecnicos'));
    }
    
    /**
     * Adiciona um novo registro ao BD
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tecnicos = Tecnico::all();
        session_start();
        if($_SESSION['nivel'] == 'admin'){
            return view('veiculos.admin.create', ['tecnicos' => $tecnicos]);
        }        
        elseif ($_SESSION['nivel'] == 'manager') {
            return view('veiculos.manager.create', ['tecnicos' => $tecnicos]);
        }        
        elseif ($_SESSION['nivel'] == 'user') {
            return view('veiculos.user.create', ['tecnicos' => $tecnicos]);
        }
    }

    
    
    /**
    * Display the specified resource.
    *
    * @param int $id
    * @return \Illuminate\Http\Response
    */    
    public function show($id)
    {
        if(request()->ajax())
        {
            $data = Veiculo::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }
    
    /**
    * Mostra o formulário para editar o recurso especificado.
    *
    * @param int $id
    * @return \Illuminate\Http\Response
    */    
    public function edit($id)
    {
        //$tecnicos = Tecnico::all();
        if(request()->ajax())
        {
            $data = Veiculo::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Veiculo  $veiculo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Veiculo $veiculo)
    {
        $rules = array(
            'vehicle_plate'=>  'required',
            'owner'        =>  'required',
            'brand'        =>  'required',
            'km'           =>  'required',
            'situation'    =>  'required',
            'model'        =>  'required',
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'vehicle_plate'=>  $request->vehicle_plate,
            'owner'        =>  $request->owner,
            'vehicle_user' =>  $request->vehicle_user == null?'':$request->vehicle_user,
            'brand'        =>  $request->brand,
            'km'           =>  $request->km,
            'obs'          =>  $request->obs,
            'situation'    =>  $request->situation,
            'rent_date'    =>  $request->rent_date == null?'':$request->rent_date,
            'rental_term'  =>  $request->rental_term == null?'':$request->rental_term,
            'model'        =>  $request->model,
        );

        Veiculo::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => 'Registro atualizado com sucesso!']);
    }
    
    /**
    * Remove o registro especificado.
    *
    * @param int $id
    * @return \Illuminate\Http\Response
    */    
    public function destroy($id)
    {
        $data = Veiculo::findOrFail($id);
        $data->delete();
    }

    public function insert(Request $request){
        $tecnicos = Tecnico::all();
        #se for nulo recebe null, senão pega apenas o numero antes do hífen #ternária
        $usuario = is_null($request->usuario) ? null : $request->usuario;
        
        $veiculo = new Veiculo();        
        $veiculo->vehicle_plate = $request->placa;
        $veiculo->vehicle_user = $usuario;
        $veiculo->brand = $request->marca;
        $veiculo->model = $request->modelo;
        $veiculo->km = $request->km;
        $veiculo->situation = $request->situacao;
        $veiculo->owner = $request->proprietario;
        $veiculo->rent_date = $request->data_locacao;
        $veiculo->rental_term = $request->prazo_locacao;
        $veiculo->obs = $request->obs;
        
        $itens = $veiculo::where('vehicle_plate', '=', $request->placa)->count();
        if ($itens > 0) {
            echo "<script language='javascript'> window.alert('Já existe um veículo cadastrado com essa placa!') </script>";
            session_start();
            return view('veiculos.manager.create');
        }else {
            $veiculo->save();
            echo "<script language='javascript'> window.alert('Veículo cadastrado com sucesso!') </script>";
            session_start();
            return redirect()->route('veiculos.index');
        }
        
    }
}
