<?php

namespace App\Http\Controllers;

use App\Models\Comentario;
use App\Models\Follow;
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
        $comentario = Comentario::where('user_id', '=', $id)->where('parent_id','=', NULL)->orderBy('id', 'desc')->paginate(15);
        if ($comentario != null)
            return response()->json(['data' => $comentario]);
        else
            return response()->json(['message' => 'Not Found!'], 404);
    }

    public function getTimeline($id)
    {
        //
        $comentario = DB::table('comentarios')
        ->join('follows', 'comentarios.user_id', '=', 'follows.seguido_id')->join('users', 'comentarios.user_id','=','users.id')->where ('follows.seguidor_id', '=', $id)
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

    public function searchUser ($pattern, $user_id)
    {
        //dump($mail);
        $user = User::
        //leftJoin ('follows', 'users.id', '=', 'follows.seguido_id')->
        where('nombre', 'LIKE', '%' . $pattern . '%')->
        orWhere('name', 'LIKE', '%' . $pattern . '%')->
        orWhere('email', 'LIKE', '%' . $pattern . '%')->
        orWhere('circunscripcion', 'LIKE', '%' . $pattern . '%')->
        orWhere('partido', 'LIKE', '%' . $pattern . '%')->
        orWhere('biografia', 'LIKE', '%' . $pattern . '%')->
        with('follows')->
        paginate(15);
        //dd($user);
        //dump ($user);

        if ($user != null)
            return response()->json(['data' => $user ]);
        else
            return response()->json(['message' => 'Not Found!'], 404);
    }

    public function getSeguidos ($user_id)
    {
        //dump($mail);
        $follows = Follow::where('seguidor_id','=', $user_id)->with('seguido')->get();
        //return $follows;
        //$users = User::with('follows')->where('seguidor_id','=', $user_id)->get();

        if ($follows != null)
        {
            $seguidos = array();
            //dump($seguidos);
            foreach ($follows as $follow)
                //dump ($follow->seguido);
                array_push($seguidos, $follow->seguido);

            return response()->json(['data' => $seguidos ]);
        }
        else
            return response()->json(['message' => 'Not Found!'], 404);
    }

    public function getSiguiendo ($user_id)
    {
        //dump($mail);
        $follows = Follow::where('seguido_id','=', $user_id)->with('seguidor')->get();
        //return $follows;
        //$users = User::with('follows')->where('seguidorr_id','=', $user_id)->get();

        if ($follows != null)
        {
            $seguidores = array();
            //dump($seguidores);
            foreach ($follows as $follow)
                //dump ($follow->seguidor);
                array_push($seguidores, $follow->seguidor);

            return response()->json(['data' => $seguidores ]);
        }
        else
            return response()->json(['message' => 'Not Found!'], 404);
    }

}
