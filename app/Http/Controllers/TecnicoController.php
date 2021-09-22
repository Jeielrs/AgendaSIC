<?php

namespace App\Http\Controllers;

use App\Models\Tecnico;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use DataTables;
use Validator;

class TecnicoController extends Controller
{
    /**
    * Exibe uma listagem dos recursos
    *
    * @return \Illuminate\Http\Response
    */    
    public function index(Request $request)
    {
        if ($request->ajax()) {            
            $data = Tecnico::latest()->get();
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
                    if ( $row->situation == 'Ativo') {
                        $row->situation = 'alert-success';
                    } elseif ($row->situation == 'Férias') {
                        $row->situation = 'alert-warning';
                    }else {
                        $row->situation = 'alert-secondary';
                    }
                    return $row->situation;
                })
                ->editColumn('birth', function ($row) {
                    return date("d/m/Y", strtotime($row->birth));
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        session_start();
        if($_SESSION['nivel'] == 'admin'){
            return view('tecnicos.admin.index');
        }        
        elseif ($_SESSION['nivel'] == 'manager') {
            return view('tecnicos.manager.index');
        }        
        elseif ($_SESSION['nivel'] == 'user') {
            return view('tecnicos.user.index');
        }
    }

    public function create()
    {
        @session_start();
        if($_SESSION['nivel'] == 'admin'){
            return view('tecnicos.admin.create');
        }        
        elseif ($_SESSION['nivel'] == 'manager') {
            return view('tecnicos.manager.create');
        }        
        elseif ($_SESSION['nivel'] == 'user') {
            return view('tecnicos.user.create');
        }    
    }

    public function insert(Request $request)
    {   #o que vem da request é atribuido na classe tecnico
        //print_r($request); exit();
        $tecnico = new Tecnico();
        $tecnico->name = $request->nome;
        $tecnico->birth = $request->nascimento;
        $tecnico->rg = $request->rg;
        $tecnico->cpf = $request->cpf;
        $tecnico->cnh = $request->cnh;
        $tecnico->ctps = $request->ctps;
        $tecnico->phone = $request->telefone;
        $tecnico->validity_aso = $request->validade_aso;
        $tecnico->validity_epi = $request->validade_epi;
        $tecnico->validity_nr10 = $request->validade_nr10;
        $tecnico->validity_nr11 = $request->validade_nr11;
        $tecnico->validity_nr35 = $request->validade_nr35;
        $tecnico->situation = $request->situacao;
        $tecnico->obs = $request->obs;

        $nomes = $tecnico::where('name', '=', $request->nome)->count();
        $cpfs = $tecnico::where('cpf', '=', $request->cpf)->count();
        $rgs = $tecnico::where('rg', '=', $request->rg)->count();
        if ($nomes > 0) {
            echo "<script language='javascript'> window.alert('Já existe um técnico cadastrado com esse nome!') </script>";
            session_start();
            return view('tecnicos.manager.create');
        }elseif ($cpfs > 0) {
            echo "<script language='javascript'> window.alert('Já existe um técnico cadastrado com esse CPF!') </script>";
            session_start();
            return view('tecnicos.manager.create');
        }elseif ($rgs > 0) {
            echo "<script language='javascript'> window.alert('Já existe um técnico cadastrado com esse RG!') </script>";
            session_start();
            return view('tecnicos.manager.create');
        }else {
            $tecnico->save();
            echo "<script language='javascript'> window.alert('Técnico cadastrado com sucesso!') </script>";
            session_start();
            return redirect()->route('tecnicos.index');
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
            $data = Tecnico::findOrFail($id);
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
        if(request()->ajax())
        {
            $data = Tecnico::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tecnico  $tecnico
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tecnico $tecnico)
    {
        $rules = array(
            'name'      =>  'required',
            'cpf'       =>  'required',
            'rg'        =>  'required',
            'birth'     =>  'required',
            'cnh'       =>  'required',
            'ctps'      =>  'required',
            'phone'     =>  'required',
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'name'          =>  $request->name,
            'birth'         =>  $request->birth,
            'rg'            =>  $request->rg,
            'cpf'           =>  $request->cpf,
            'cnh'           =>  $request->cnh,
            'ctps'          =>  $request->ctps,
            'phone'         =>  $request->phone,
            'validity_aso'  =>  $request->validity_aso == null?'':$request->validity_aso,
            'validity_epi'  =>  $request->validity_epi == null?'':$request->validity_epi,
            'validity_nr10' =>  $request->validity_nr10 == null?'':$request->validity_nr10,
            'validity_nr11' =>  $request->validity_nr11 == null?'':$request->validity_nr11,
            'validity_nr35' =>  $request->validity_nr35 == null?'':$request->validity_nr35,
            'situation'     =>  $request->situation == null?'':$request->situation,
            'obs'           =>  $request->obs == null?'':$request->obs
        );

        Tecnico::whereId($request->hidden_id)->update($form_data);

        //$debug = $request->all();
        //return response()->json(['success' => $debug]);

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
        $data = Tecnico::findOrFail($id);
        $data->delete();
    }
}
