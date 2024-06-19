<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{

    public function index()
    {
        $services = Service::all();

        if ($services->isEmpty()) {
            $data = [
                'message' => 'No se encontraron servicios',
                'status' => 200
            ];

            return response()->json($data, 200);
        }

        // Crear la respuesta en una variable $data
        $data = [
            'services' => $services,
            'status' => 200
        ];

        // Devolver la respuesta en formato JSON
        return response()->json($data, 200);
    }

    public function store(Request $request)
    {
        // Validar los datos de la petición
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric'],
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

        $service = new Service();
        $service->name = $request->name;
        $service->description = $request->description;
        $service->price = $request->price;
        $service->save();

        // Validar si no se pudo crear el cliente
        if (!$service) {
            $data = [
                'message' => 'Error al crear el servicio',
                'status' => 500
            ];
            return response()->json($data, 500);
        }

        // Crear la respuesta en una variable $data
        $data = [
            'message' => 'Servicio creado con éxito',
            'service' => $service,
            'status' => 201
        ];

        // Devolver la respuesta en formato JSON
        return response()->json($data, 201);
    }

    public function show(Service $service)
    {
        return response()->json($service);
    }


    public function update(Request $request, Service $service)
    {
        // Validar los datos de la petición
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric'],
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

        $service->name = $request->name;
        $service->description = $request->description;
        $service->price = $request->price;
        $service->save();

        // Armamos la respuesta
        $data = [
            'message' => 'Cliente actualizado',
            'cliente' => $service,
            'status' => 200
        ];

        // Devolver la respuesta
        return response()->json($data, 200);
    }

    public function destroy(Service $service)
    {
        $service->delete();

        // Armar la respuesta
        $data = [
            'message' => 'Servicio eliminado',
            'status' => 200
        ];

        // Devolver la respuesta
        return response()->json($data, 200);
    }

    // Para ver cuantos clientes hacen uso del servicio
    public function clients(Request $request)
    {
        $service = Service::find($request->service_id);
        $clients = $service->clients;
        $data = [
            'message' => 'Clientes encontrados con éxito',
            'clients' => $clients
        ];
        return response()->json($data);
    }
}
