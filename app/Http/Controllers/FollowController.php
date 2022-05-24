<?php

namespace App\Http\Controllers;
use App\Models\Follow;
use App\Models\User;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $follow = Follow::create ($request->all);

        //$follow = $request;
        if ($follow != null)
            return response()->json(['data' => $follow]);
        else
            return response()->json(['message' => 'Not Found!'], 404);
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
        $follow = Follow::find($id);
        if ($follow != null)
            $follow->delete();
    }

    public function createFollow ($seguido_id, $seguidor_id)
    {
        $follow = Follow::where ('seguido_id', '=', $seguido_id)->where('seguidor_id', '=', $seguidor_id)->first();
        if ($follow == null)
        {
            $follow = new Follow ();
            $follow->seguido_id = $seguido_id;
            $follow->seguidor_id = $seguidor_id;
            $follow->save();
        }

        if ($follow != null)
        {
            //Actualizamos ambos usuarios bajando los seguidores a uno y los seguidos a otro:
            $seguidor = User::find($seguidor_id);
            $seguidor->following = $seguidor->following + 1;
            $seguidor->save();

            $seguido = User::find($seguido_id);
            $seguido->followers = $seguido->followers + 1;
            $seguido->save();
            return $seguido;
        }
        return "Relation not found";

    }

    public function deleteFollow ($seguido_id, $seguidor_id)
    {
        $follow = Follow::where('seguido_id', '=', $seguido_id)->where('seguidor_id', '=', $seguidor_id)->first();

        if ($follow != null)
        {
            $follow->delete();
            //Actualizamos ambos usuarios bajando los seguidores a uno y los seguidos a otro:
            $seguidor = User::find($seguidor_id);
            $seguidor->following = $seguidor->following - 1;
            $seguidor->save();

            $seguidor = User::find($seguido_id);
            $seguidor->followers = $seguido->followers - 1;
            $seguidor->save();

            return $seguidor;
        }
        return "Relation not found";
    }

}
