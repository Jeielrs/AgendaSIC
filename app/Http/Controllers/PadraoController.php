<?php

namespace App\Http\Controllers;

use App\Models\Padrao;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use DataTables;
use Validator;

class PadraoController extends Controller
{
    /**
     * Exibe uma listagem dos recursos
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {            
            $data = Padrao::latest()->get();
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
                    if ( $row->situation == 'ativo') {
                        $row->situation = 'alert-success';
                    } elseif ($row->situation == 'manutencao') {
                        $row->situation = 'alert-warning';
                    }elseif ($row->situation == 'inativo') {
                        $row->situation = 'alert-secondary';
                    }
                    return $row->situation;
                })
                ->editColumn('situation', function ($row) {
                    if ($row->situation === 'ativo'){
                        $situation = 'Ativo';
                    }elseif ($row->situation === 'manutencao') {
                        $situation = 'Em manutenção';
                    }
                    elseif ($row->situation === 'inativo') {
                        $situation = 'Inativo';
                    }
                    return $situation;
                })
                ->editColumn('calibration_validity', function ($row) {
                    return date("d/m/Y", strtotime($row->birth));
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        session_start();
        if($_SESSION['nivel'] == 'admin'){
            return view('padroes.admin.index');
        }        
        elseif ($_SESSION['nivel'] == 'manager') {
            return view('padroes.manager.index');
        }        
        elseif ($_SESSION['nivel'] == 'user') {
            return view('padroes.user.index');
        }
    }

    /**
     * Adiciona um novo registro ao BD
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        session_start();
        if($_SESSION['nivel'] == 'admin'){
            return view('padroes.admin.create');
        }        
        elseif ($_SESSION['nivel'] == 'manager') {
            return view('padroes.manager.create');
        }        
        elseif ($_SESSION['nivel'] == 'user') {
            return view('padroes.user.create');
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
            $data = Padrao::findOrFail($id);
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
            $data = Padrao::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Padrao  $padrao
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Padrao $padrao)
    {
        $rules = array(
            'tag'           =>  'required',
            'description'   =>  'required',
            'sector'        =>  'required',
            'situation' =>  'required',
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'tag'                   =>  $request->tag,
            'description'           =>  $request->description,
            'sector'                =>  $request->sector,
            'particularity'         =>  $request->particularity,
            'calibration_frequency' =>  $request->calibration_frequency == null?'':$request->calibration_frequency,
            'calibration_date'      =>  $request->calibration_date == null?'':$request->calibration_date,
            'calibration_validity'  =>  $request->calibration_validity == null?'':$request->calibration_validity,
            'situation'             =>  $request->situation == null?'':$request->situation,
            'obs'                   =>  $request->obs,
        );

        Padrao::whereId($request->hidden_id)->update($form_data);

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
        $data = Padrao::findOrFail($id);
        $data->delete();
    }

    public function insert(Request $request){
        $padrao = new Padrao();
        $padrao->tag = $request->tag;
        $padrao->description = $request->descricao;
        $padrao->sector = $request->setor;
        $padrao->particularity = $request->particularidade;
        $padrao->calibration_frequency = $request->frequencia;
        $padrao->calibration_date = $request->data;
        $padrao->calibration_validity = $request->validade;
        $padrao->situation = $request->situacao;
        $padrao->obs = $request->obs;
        
        $itens = $padrao::where('tag', '=', $request->tag)->count();
        if ($itens > 0) {
            echo "<script language='javascript'> window.alert('Já existe um padrão cadastrado com essa Etiqueta!') </script>";
            session_start();
            return view('padroes.manager.create');
        }else {
            $padrao->save();
            echo "<script language='javascript'> window.alert('Padrão cadastrado com sucesso!') </script>";
            session_start();
            return redirect()->route('padroes.index');
        }
    }
}
