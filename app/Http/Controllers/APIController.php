<?php

namespace App\Http\Controllers;

use App\Models\Comentario;
use App\Models\User;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
//use App\Jobs\ImportarDiputadosJob;

class APIController extends Controller
{
    /*public function inicializar ()
    {
        InicializarJob::dispatch();
        return response()->json(['message' => 'Proceso de inicializado lanzado correctamente'], 200);
    }*/

    public function getMuro($id)
    {
        //
        $comentario = Comentario::where('user_id', '=', $id)->orderBy('id', 'desc')->paginate(15);
        if ($comentario != null)
            return response()->json(['data' => $comentario]);
        else
            return response()->json(['message' => 'Not Found!'], 404);
    }

    public function getTimeline($id)
    {
        //
        $comentario = DB::table('comentarios')
        ->join('follows', 'comentarios.user_id', '=', 'follows.seguido_id')->where ('follows.seguidor_id', '=', $id)
        ->paginate(15);
        if ($comentario != null)
            return response()->json(['data' => $comentario]);
        else
            return response()->json(['message' => 'Not Found!'], 404);
    }

    public function getUserByEmail ($mail)
    {
        //dump($mail);
        $user = User::where('email', '=', $mail)->first();
        //dd($user);
        //dump ($user);

        if ($user != null)
            return response()->json(['data' => $user ]);
        else
            return response()->json(['message' => 'Not Found!'], 404);
    }

    public function searchUser ($pattern)
    {
        //dump($mail);
        $user = User::where('nombre', 'LIKE', '%' . $pattern . '%')->
        orWhere('name', 'LIKE', '%' . $pattern . '%')->
        orWhere('email', 'LIKE', '%' . $pattern . '%')->
        orWhere('circunscripcion', 'LIKE', '%' . $pattern . '%')->
        orWhere('partido', 'LIKE', '%' . $pattern . '%')->
        orWhere('biografia', 'LIKE', '%' . $pattern . '%')
        ->paginate(15);
        //dd($user);
        //dump ($user);

        if ($user != null)
            return response()->json(['data' => $user ]);
        else
            return response()->json(['message' => 'Not Found!'], 404);
    }
}
