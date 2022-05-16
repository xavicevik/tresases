<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Ventas/Carthome');
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
        \Cart::session(Auth::user()->id);
        \Cart::add(array(
            'id' => $request->id, // inique row ID
            'name' => $request->name,
            'price' =>$request->price,
            'quantity' => $request->quantity,
            'attributes' => array(
                'url' => $request->url,
                'serie' => $request->serie,
                'descripcion' => $request->descripcion,
                'idrifa' => $request->idrifa,
                'numero' => $request->numero,
                'codigo' => $request->codigo
            ),
            'associatedModel' => Boleta::class
        ));

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        \Cart::session(Auth::user()->id);
        $items = \Cart::getContent();

        return ['cart' => $items];
    }

    public function validarId(Request $request)
    {
        $status = 0;
        $items = \Cart::session(Auth::user()->id)->get($request->iditem);

        if (is_null($items)) {
            $status = 0;
        } else {
            $status = 1;
        }

        return ['cart' => $status];
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
    public function destroy($cart)
    {
        \Cart::session(Auth::user()->id);
        \Cart::remove($cart);

        return back();
    }
}
