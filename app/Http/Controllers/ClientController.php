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

        // Traer todos los clientes junto con sus servicios
        $array = [];
        foreach ($clients as $client) {
            $array[] = [
                'id' => $client->id,
                'name' => $client->name,
                'email' => $client->email,
                'phone' => $client->phone,
                'address' => $client->address,
                'services' => $client->services
            ];
        }

        // Crear la respuesta en una variable $data
        // $data = [
        //     'clients' => $clients,
        //     'status' => 200
        // ];

        // Devolver la respuesta en formato JSON
        return response()->json($array, 200);
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
        // $client = Client::create([
        //     'name' => $request->name,
        //     'email' => $request->email,
        //     'phone' => $request->phone,
        //     'address' => $request->address
        // ]);

        $client = new Client();
        $client->name = $request->name;
        $client->email = $request->email;
        $client->phone = $request->phone;
        $client->address = $request->address;
        $client->save();

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


    public function show(Client $client)
    {
        // Devolver el cliente con todos sus servicios
        $data = [
            'message' => 'Detalle del cliente',
            'client' => $client,
            'services' => $client->services
        ];
        return response()->json($data);
    }

    public function update(Request $request, Client $client)
    {
        // Validar que no se encontró el client
        if (!$client) {
            $data = [
                'message' => 'Cliente no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        // Validar los nuevos datos
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'max:255'],
            'email' => ['required', 'email', 'unique:clients'],
            'phone' => ['nullable', 'digits:9'],
            'address' => ['nullable']
        ]);

        // Comprobar si hubo error en la validación
        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        // Actualizamos con los nuevos datos
        $client->name = $request->name;
        $client->email = $request->email;
        $client->phone = $request->phone;
        $client->address = $request->address;
        $client->save();

        // Armamos la respuesta
        $data = [
            'message' => 'Cliente actualizado',
            'cliente' => $client,
            'status' => 200
        ];

        // Devolver la respuesta
        return response()->json($data, 200);
    }

    public function destroy(Client $client)
    {
        // Validar que no se encontró el client
        if (!$client) {
            $data = [
                'message' => 'Cliente no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        // Eliminar cliente
        $client->delete();

        // Armar la respuesta
        $data = [
            'message' => 'Cliente eliminado',
            'status' => 200
        ];

        // Devolver la respuesta
        return response()->json($data, 200);
    }

    // Para insertar un servicio a un cliente
    // Es decir un cliente puede tener varios servicios
    public function attach(Request $request)
    {
        $client = Client::find($request->client_id);
        $client->services()->attach($request->service_id);
        $data = [
            'message' => 'Servicio agregado con éxito',
            'client' => $client
        ];

        return response()->json($data);
    }

    // Para quitar un servicio a un cliente
    public function detach(Request $request)
    {
        $client = Client::find($request->client_id);
        $client->services()->detach($request->service_id);
        $data = [
            'message' => 'Servicio quitado con éxito',
            'client' => $client
        ];

        return response()->json($data);
    }
}
