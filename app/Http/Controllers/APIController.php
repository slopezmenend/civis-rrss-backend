<?php

namespace App\Http\Controllers;

use App\Models\Comentario;
use App\Models\Follow;
use App\Models\Reaccion;
use App\Models\User;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
//use App\Jobs\ImportarDiputadosJob;

class APIController extends Controller
{
    /*public static function inicializar ()
    {
        InicializarJob::dispatch();
        return response()->json(['message' => 'Proceso de inicializado lanzado correctamente'], 200);
    }*/

    public static function getProfile ($id, $uid)
    {
        $user = User::find ($id);
        if ($user != null)
        {
            $follow = Follow::where('seguido_id','=',$id)->where('seguidor_id','=', $uid)->first();
            //dd($follow);
            $user2 = $user;
            $user2->follow = $follow!=null;
            return response()->json(['data' => $user2]);
        }
        else
            return response()->json(['message' => 'Not Found!'], 404);
    }

    public static function getMuro($id, $uid)
    {
        //
        //if ($uid == 0)
        if ($uid != 0)
        {
            $comentarios = Comentario::where('user_id', '=', $id)
            ->with('diputado')->where('parent_id','=', NULL)
            ->orderBy('id', 'desc')->paginate(50);

            if ($comentarios != null)
            {
                $result = [];
                foreach ($comentarios->items() as $comentario)
                {
                    $com = $comentario;
                    $diputado = User::find($comentario->user_id);
                    //dump ($diputado);
                    $reaccion = Reaccion::where('comentario_id','=',$comentario->id)->where ('user_id','=',$uid)->first();
                    //dump ($reaccion);
                    $com->diputado = $diputado;
                    if ($reaccion!=null)
                        $com->reaccion = $reaccion->tipo;
                    else
                        $com->reaccion = 0;
                    //dump ($com);
                    array_push ($result, $com);
                }
                return response()->json(['data' => $result]);
            }
            else
                return response()->json(['message' => 'Not Found!'], 404);
            }
            else return response()->json(['data' => []]);
                //dd($comentarios->items());
        /*else
            $comentarios = DB::table('comentarios')
        ->join('users', 'comentarios.user_id', '=', 'users.id')
        ->leftJoin ('reacciones', 'comentarios.id','=','reacciones.comentario_id')
        ->where ('comentarios.user_id', '=', $id)
        ->where('reacciones.user_id', '=', $uid)
        ->orWhere('reacciones.user_id', '=', null)
        ->select('comentarios.*', 'users.*', 'reacciones.*', 'comentarios.id as id')->orderBy('comentarios.id', 'desc')->paginate(50);
        //$comentario = Comentario::where('user_id', '=', $id)->with('diputado')->where('parent_id','=', NULL)->orderBy('id', 'desc')->paginate(50);*/
        /*if ($comentarios != null)
        {
            return response()->json(['data' => $comentarios]);
        }
        else
            return response()->json(['message' => 'Not Found!'], 404);*/
    }

    public static function getTimeline($id, $uid)
    {
        //dump ('llamada al timeline con datos:', $id, $uid);
        //if ($uid != 0)
        //{
        //
            $comentarios = DB::table('comentarios')
            ->join('follows', 'comentarios.user_id', '=', 'follows.seguido_id')->join('users', 'comentarios.user_id','=','users.id')->where ('follows.seguidor_id', '=', $id)
            ->select('comentarios.*', 'users.*', 'comentarios.id as id')->orderBy('comentarios.id', 'desc')->paginate(50);

            //dump('Recuperamos comentarios:', $comentarios);
            if ($comentarios != null)
            {
                $result = [];
                foreach ($comentarios->items() as $comentario)
                {
                    $com = Comentario::find($comentario->id);
                    $diputado = User::find($comentario->user_id);
                    //dump ($diputado);
                    $reaccion = Reaccion::where('comentario_id','=',$comentario->id)->where ('user_id','=',$uid)->first();
                    //dump ($reaccion);
                    $com->diputado = $diputado;
                    if ($reaccion!=null)
                        $com->reaccion = $reaccion->tipo;
                    else
                        $com->reaccion = 0;
                    //dump ($com);
                    array_push ($result, $com);
                }
                return response()->json(['data' => $result]);
            }
            else
            {
                //dump ("No se encontró comentario");
                return response()->json(['message' => 'Not Found!'], 404);
            }
        //}
        //else { return response()->json(['data' => []]); }

        /*if ($comentario != null)
            return response()->json(['data' => $comentario]);
        else
            return response()->json(['message' => 'Not Found!'], 404);*/
    }

    public static function updateNameFoto ($request)
    {

        $user = User::where('email', '=', $request->mail)->first();

        if ($user != null)
        {
            if ($user->name == '' || $user->nombre == '' || $user->fotoperfil == '')
            {
                if ($user->name == '')  $user->name = $request->name;
                if ($user->nombre == '')  $user->nombre = $request->name;
                if ($user->fotoperfil == '') $user->fotoperfil = $request->foto;
                $user->save();
            }
        }
        else
        {
            $user = new User();
            $user->email = $request->mail;
            $user->name = $request->name;
            $user->nombre = $request->name;
            $user->fotoperfil = $request->foto;
            $user->password = '123456';
            $user->save();
        }

        return response()->json(['data' => $user]);
    }

    public static function getUserByEmail ($mail)
    {
        $user = User::where('email', '=', $mail)->first();
        if ($user != null)
        {
            //$follow = Follow::where('seguido_id','=',$id)->where('seguidor_id','=', $uid)->first();
            //dd($follow);
            $user2 = $user;
            $user2->follow = false;
            return response()->json(['data' => $user2]);
        }
        else
            return response()->json(['message' => 'Not Found!'], 404);
    }

    public static function searchUser ($pattern, $user_id)
    {
        //dump($pattern, $user_id);
        error_log("Inicio searchUser");
        error_log($pattern);
        error_log($user_id);
        $users = User::
        //leftJoin ('follows', 'users.id', '=', 'follows.seguido_id')->
        where('nombre', 'LIKE', '%' . $pattern . '%')->
        orWhere('name', 'LIKE', '%' . $pattern . '%')->
        orWhere('email', 'LIKE', '%' . $pattern . '%')->
        orWhere('circunscripcion', 'LIKE', '%' . $pattern . '%')->
        orWhere('partido', 'LIKE', '%' . $pattern . '%')->
        orWhere('biografia', 'LIKE', '%' . $pattern . '%')->get();
        //with('follows')->
        //paginate(50);
        //dd($user);
        //dump ($users);
        //error_log($users);

/*        if ($user != null)
            return response()->json(['data' => $user ]);
        else
            return response()->json(['message' => 'Not Found!'], 404);*/
            if ($users != null)
            {
                $result = [];
                foreach ($users as $user)
                {
                    $temp = $user;
                    $follow = Follow::where('seguido_id','=', $user->id)->where('seguidor_id','=',$user_id)->first();
                    $temp->follow = $follow!=null;
                    array_push ($result, $temp);
                }
                //dump ($result);
                error_log("Vamos a contestar con ", count($result));
                return response()->json(['data' => $result]);
            }
            else
                return response()->json(['message' => 'Not Found!'], 404);
    }

    public static function getSeguidos ($user_id, $uid)
    {
        //dump($mail);
        $follows = Follow::where('seguidor_id','=', $user_id)->with('seguido')->get();
        //return $follows;
        //$users = User::with('follows')->where('seguidor_id','=', $user_id)->get();

        /*if ($follows != null)
        {
            $seguidos = array();
            //dump($seguidos);
            foreach ($follows as $follow)
                //dump ($follow->seguido);
                array_push($seguidos, $follow->seguido);

            return response()->json(['data' => $seguidos ]);
        }
        else
            return response()->json(['message' => 'Not Found!'], 404);*/
            if ($follows != null)
            {
                //dd($follows);
                $result = [];
                foreach ($follows as $follow)
                {
                    //dd($follow);
                    $user = User::find($follow->seguido_id);
                    $temp = $user;
                    $follow = Follow::where('seguido_id','=', $user->id)->where('seguidor_id','=',$uid)->first();
                    $temp->follow = $follow!=null;
                    array_push ($result, $temp);
                }
                return response()->json(['data' => $result]);
            }
            else
                return response()->json(['message' => 'Not Found!'], 404);
    }

    public static function getSiguiendo ($user_id, $uid)
    {
        //dump($mail);
        $follows = Follow::where('seguido_id','=', $user_id)->with('seguidor')->get();
        //return $follows;
        //$users = User::with('follows')->where('seguidorr_id','=', $user_id)->get();

/*        if ($follows != null)
        {
            $seguidores = array();
            //dump($seguidores);
            foreach ($follows as $follow)
                //dump ($follow->seguidor);
                array_push($seguidores, $follow->seguidor);

            return response()->json(['data' => $seguidores ]);
            */
            if ($follows != null)
            {
                //dd($follows);
                $result = [];
                foreach ($follows as $follow)
                {
                    //dd($follow);
                    $user = User::find($follow->seguidor_id);
                    $temp = $user;
                    $follow = Follow::where('seguido_id','=', $user->id)->where('seguidor_id','=',$uid)->first();
                    $temp->follow = $follow!=null;
                    array_push ($result, $temp);
                }
                return response()->json(['data' => $result]);
            }
            else
                return response()->json(['message' => 'Not Found!'], 404);
        //}
        //else
            //return response()->json(['message' => 'Not Found!'], 404);
    }

    public static function crearReaccion ($request)
    {

        $reaccion = new Reaccion();
        $reaccion->user_id = $request->user_id;
        $reaccion->comentario_id = $request->id;
        $reaccion->tipo = $request->reaccion;
        $reaccion->save();

        //actualizamos el contador de reacciones del comentario
        $comentario = Comentario::find ($reaccion->comentario_id);
        if ($comentario != null)
        {
            switch ($reaccion->tipo)
            {
                case 1: $comentario->encanta = $comentario->encanta + 1; break;
                case 2: $comentario->gusta = $comentario->gusta + 1; break;
                case 3: $comentario->igual = $comentario->igual + 1; break;
                case 4: $comentario->disgusta = $comentario->disgusta + 1; break;
                case 5: $comentario->odia = $comentario->odia + 1; break;
            }
            $comentario->save();
        }

        return response()->json(['data' => $reaccion]);
    }

    public static function borrarReaccion ($request)
    {

        $id = $request->id;
        $user_id  = $request->user_id;

        $reaccion = Reaccion::where ('user_id','=',$user_id)->where ('comentario_id','=',$id)->first();

        if ($reaccion!=null)
        {
            $reaccion->delete();

            //actualizamos el contador de reacciones del comentario
            $comentario = Comentario::find ($reaccion->comentario_id);
            if ($comentario != null)
            {
                switch ($reaccion->tipo)
                {
                    case 1: $comentario->encanta = $comentario->encanta - 1; break;
                    case 2: $comentario->gusta = $comentario->gusta - 1; break;
                    case 3: $comentario->igual = $comentario->igual - 1; break;
                    case 4: $comentario->disgusta = $comentario->disgusta - 1; break;
                    case 5: $comentario->odia = $comentario->odia - 1; break;
                }
                $comentario->save();
            }
            return response()->json(['data' => $reaccion]);
        }
        else
            return response()->json(['message' => 'Not found']);
    }

    public static function getComentarios($comentario_id, $uid)
    {
        if ($uid != 0)
        {
            $comentarios = Comentario::where('parent_id','=', $comentario_id)
            ->with('diputado')->orderBy('id', 'desc')->paginate(50);

            if ($comentarios != null)
            {
                $result = [];
                foreach ($comentarios->items() as $comentario)
                {
                    $com = $comentario;
                    $diputado = User::find($comentario->user_id);
                    //dump ($diputado);
                    $reaccion = Reaccion::where('comentario_id','=',$comentario->id)->where ('user_id','=',$uid)->first();
                    //dump ($reaccion);
                    $com->diputado = $diputado;
                    if ($reaccion!=null)
                        $com->reaccion = $reaccion->tipo;
                    else
                        $com->reaccion = 0;
                    //dump ($com);
                    array_push ($result, $com);
                }
                return response()->json(['data' => $result]);
            }
            else
                return response()->json(['message' => 'Not Found!'], 404);
            }
            else return response()->json(['data' => []]);
    }

}
