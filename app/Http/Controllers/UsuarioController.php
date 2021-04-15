<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\ElseIf_;

class UsuarioController extends Controller
{
    public function login(Request $request){

        $conta = $request->conta;
        $senha = $request->senha;

        $usuarios = Usuario::where('conta', '=', $conta)->where('senha', '=', $senha)->first();
        if(@$usuarios->id != null){ #@ para não dar warning de indefinido caso seja null
            @session_start();
            $_SESSION['id'] = $usuarios->id;
            $_SESSION['nome'] = $usuarios->nome;
            $_SESSION['email'] = $usuarios->email;
            $_SESSION['nivel'] = $usuarios->nivel;

            if($_SESSION['nivel'] == 'admin'){
                return view('dashboard.admin.index');
            }
            
            if ($_SESSION['nivel'] == 'manager') {
                return view('dashboard.manager.index');
            }
            
            if ($_SESSION['nivel'] == 'user') {
                return view('dashboard.user.index');
            }
        } else {
            echo "<script language='javascript'>alert('Dados Incorretos')</script>";
            return view('index');
        }
    }

    public function logout(){
        session_start();
        session_destroy();
        return view('index');
    }
}
