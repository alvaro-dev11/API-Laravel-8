<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{

    // Retornar todos los clientes en formato JSON
    public function index()
    {
        // Traer todos los clients
        $clients = Client::all();

        // Validar si no hay clients
        if ($clients->isEmpty()) {
            $data = [
                'message' => 'No se encontraron clientes',
                'status' => 200
            ];

            return response()->json($data, 200);
        }

        // Crear la respuesta en una variable $data
        $data = [
            'clients' => $clients,
            'status' => 200
        ];

        // Devolver la respuesta en formato JSON
        return response()->json($data, 200);
    }

    // Lógica para guardar un cliente
    public function store(Request $request)
    {
        // Validar los datos de la petición
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'max:255'],
            'email' => ['required', 'email', 'unique:clients'],
            'phone' => ['nullable', 'digits:9'],
            'address' => ['nullable']
        ]);

        // Comprobar si hubo un error en la validación
        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];

            return response()->json($data, 400);
        }

        // Crear un nuevo cliente
        $client = Client::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address
        ]);

        // Validar si no se pudo crear el cliente
        if (!$client) {
            $data = [
                'message' => 'Error al crear el cliente',
                'status' => 500
            ];
            return response()->json($data, 500);
        }

        // Crear la respuesta en una variable $data
        $data = [
            'message' => 'Cliente creado con éxito',
            'cliente' => $client,
            'status' => 201
        ];

        // Devolver la respuesta en formato JSON
        return response()->json($data, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        //
    }
}
