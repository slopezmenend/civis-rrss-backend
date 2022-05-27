<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

function updatedValue($oldvalue, $newvalue)
{
    if (isset($newvalue))
     return $newvalue;
    else
     return $oldvalue;
}

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return User::all();
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
        //
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
        //return User::find($id);
        //dump ($id);
        $usuario = User::where('id','=', $id)->with('follows')->first();
        //dump ($usuario);

        if ($usuario != null)
            return response()->json(['data' => $usuario ]);
        else
            return response()->json(['message' => 'Not Found!'], 404);
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
        $user = User::find ($id);
        if ($user != null)
        {
            $user->name = updatedValue($user->name, $request->name);
            $user->name = updatedValue($user->name, $request->name);
            $user->email = updatedValue($user->email, $request->email);
            $user->fotoperfil = updatedValue($user->fotoperfil, $request->fotoperfil);
            $user->idcivis = updatedValue($user->idcivis, $request->idcivis);
            $user->following = updatedValue($user->following, $request->following);
            $user->followers = updatedValue($user->followers, $request->followers);
            $user->web = updatedValue($user->web, $request->web);
            $user->facebook = updatedValue($user->facebook, $request->facebook);
            $user->twitter = updatedValue($user->twitter, $request->twitter);
            $user->instagram = updatedValue($user->instagram, $request->instagram);
            $user->youtube = updatedValue($user->youtube, $request->youtube);
            $user->nombre = updatedValue($user->nombre, $request->nombre);
            $user->fotofondo = updatedValue($user->fotofondo, $request->fotofondo);
            $user->circunscripcion = updatedValue($user->circunscripcion, $request->circunscripcion);
            $user->partido = updatedValue($user->partido, $request->partido);
            $user->grupo = updatedValue($user->grupo, $request->grupo);
            $user->biografia = updatedValue($user->biografia, $request->biografia);
            $user->ideologia = updatedValue($user->ideologia, $request->ideologia);
            $user->ideologiaadicional = updatedValue($user->ideologiaadicional, $request->ideologiaadicional);

            $user->save();

        }

        return $user;
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
