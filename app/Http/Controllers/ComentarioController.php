<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comentario;

class ComentarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $comentario = Comentario::orderBy('id')->paginate(15);
        if ($comentario != null)
            return response()->json(['data' => $comentario]);
        else
            return response()->json(['message' => 'Not Found!'], 404);
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
        //dump ($request);

        //$comentario = new Comentario ();
        //$comentario->save();
        //if ($request->all != null)
        //{
        //    $comentario->update($request->all);
            //$comentario->save();
        //}*/
        $comentario = Comentario::create ($request->all);

        //$comentario = $request;
        if ($comentario != null)

            return response()->json(['data' => $comentario]);
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
        //dump ($id);
        $comentario = Comentario::find($id);
        //dump ($comentario);

        if ($comentario != null)
            return response()->json(['data' => $comentario ]);
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
        $comentario = Comentario::find($id);
        if ($comentario != null)
            $comentario->delete();
    }
}
