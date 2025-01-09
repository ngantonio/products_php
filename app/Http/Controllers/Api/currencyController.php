<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Currency;
use Illuminate\Support\Facades\Validator;

class currencyController extends Controller
{
    public function index()
    {
        $currency = Currency::all();

        if ($currency->isEmpty()) {
            return response()->json(['message' => "No hay monedas para listar"], 200);
        }
        return response()->json($currency, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'symbol' => 'required',
            'exchange_rate' => 'required',
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error al intentar almacenar la moneda',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $currency = Currency::create([
            'name' => $request->name,
            'symbol' => $request->symbol,
            'exchange_rate' => $request->exchange_rate,
        ]);

        if (!$currency) {
            return response()->json(['message' => "No se pudo almacenar la moneda"], 500);
        }

        return response()->json([$currency, 201]);
    }


    public function show($id)
    {

        $currency = Currency::find($id);

        if (!$currency) {
            return response()->json(['message' => "Moneda no encontrada!"], 404);
        }

        return response()->json(['currency' => $currency], 200);
    }

    public function destroy($id)
    {

        $currency = Currency::find($id);

        if (!$currency) {
            return response()->json(['message' => "Moneda no encontrada!"], 404);
        }

        $currency->delete();

        return response()->json(['message' => "Moneda eliminada!"], 200);
    }

    public function update($id, Request $request)
    {

        $currency = Currency::find($id);

        if (!$currency) {
            return response()->json(['message' => "Producto no encontrado!"], 404);
        }


        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'symbol' => 'required',
            'exchange_rate' => 'required',
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error al intentar actualizar la moneda',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        // Update product fields
        $currency->name =  $request->name;
        $currency->symbol =  $request->symbol;
        $currency->exchange_rate =  $request->exchange_rate;

        $currency->save();

        return response()->json(['currency' => $currency], 200);
    }
}
