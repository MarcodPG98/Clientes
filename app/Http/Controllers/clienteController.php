<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\cliente;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

class clienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clientes = cliente::all();
        return response()->json([
            'clientes' => $clientes
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'nombre' => 'required',
            'dpi' => 'required',
            'correo' => 'required|email',
            'telefono' => 'required'
        ];
        $messages = [
            'required' => 'El campo :attribute es obligatorio.',
            'email' => 'El texto en el campo :attribute no es un correo válido'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        
        if ($validator->fails()) {
            return response()->json([
                'message' => "Información incompleta o inválida -> ".$validator->messages()->first()
            ], 400);
        }

        $cliente = cliente::create($request->all());
        return response()->json([
            'message' => "cliente saved successfully!",
            'cliente' => $cliente
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id_cliente)
    {
        $id_cliente = cliente::find($id_cliente);
        return response()->json([
            'message' => "client found!",
            'cliente' => $id_cliente
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, cliente $id_cliente)
    {
        $id_cliente->update($request->all());

        return response()->json([
            'message' => "cliente updated successfully!",
            'cliente' => $id_cliente
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(cliente $id_cliente)
    {
        $id_cliente->delete();

        return response()->json([
            'message' => "cliente deleted successfully!",
        ], 200);
    }
}
