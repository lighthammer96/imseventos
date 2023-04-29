<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    //
    public function loguearse(Request $request) {

        $data = array();
        $data["response"] = "nopass";
        $user = strtolower($request->input('user'));
        $pass = $request->input('pass');
        // $clave = Hash::make('1235');
        // echo $clave; exit;
        // echo Hash::check("1235", $clave);
        $sql_login = "SELECT u.*, p.* FROM seguridad.usuarios AS u
        INNER JOIN seguridad.perfiles AS p ON(u.perfil_id=p.perfil_id)


        WHERE lower(u.usuario_user)='{$user}'";
        // die($sql_login);
        $result = DB::select($sql_login);


        if(!isset($result[0]->usuario_user) || !isset($result[0]->idmiembro) || !isset($result[0]->perfil_id)) {
            $data["response"] = "nouser";
        }

        if(count($result) > 0 && $result[0]->perfil_id != 1 && $result[0]->perfil_id != 2) {
            $data["response"] = "nouser";
        }

        // print_r($result); exit;
        if(count($result) > 0 && isset($result[0]->usuario_pass) && Hash::check($pass, $result[0]->usuario_pass)) {
            $data["response"] = "ok";
            //$request->session()->put('usuario_id', $result[0]->usuario_id);
            $usuario_id = (isset($result[0]->usuario_id)) ? $result[0]->usuario_id : '';

            $usuario_user = (isset($result[0]->usuario_user)) ? $result[0]->usuario_user : '';
            $perfil_id = (isset($result[0]->perfil_id)) ? $result[0]->perfil_id : '';



            session(['usuario_id' => $usuario_id]);

            session(['usuario_user' => $usuario_user]);
            session(['perfil_id' => $perfil_id]);

            $foto = "hombre.png";
            session(['foto' => $foto]);



            $sql_perfil = "SELECT * FROM seguridad.perfiles WHERE perfil_id={$perfil_id}";
            //die($sql_perfil);
            $perfil = DB::select($sql_perfil);

            session(['perfil_descripcion' => (isset($perfil[0]->perfil_descripcion)) ? $perfil[0]->perfil_descripcion : "" ]);

        }

        echo json_encode($data);
        // echo $clave; // Imprime:

    }

    public function logout(Request $request) {
        $request->session()->flush();
        return redirect('/');
    }
}
