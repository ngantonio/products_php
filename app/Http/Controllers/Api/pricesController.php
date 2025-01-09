<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Currency;
use App\Models\Price;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class pricesController extends Controller
{

    public function show($id)
    {
        $price_detail = DB::table('prices as pc')
            ->join('products as ps', 'ps.id', '=', 'pc.product_id')
            ->join('currency as c', 'c.id', '=', 'pc.currency_id')
            ->select('ps.id', 'ps.name', 'ps.description', 'pc.price', 'c.symbol', 'ps.tax_cost')
            ->get();

        if (!$price_detail) {
            return response()->json(['message' => "No hay lista de precios para el producto especificado!"], 404);
        }

        return response()->json(['price_detail' => $price_detail], 200);
    }


    public function store($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'price' => 'required',
            'currency_id' => 'required',
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error al intentar almacenar el precio',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $currency = Currency::find($request->currency_id);
        if (!$currency) {
            return response()->json(['message' => "El currency_id no corresponde a ninguna moneda."], 400);
        }

        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => "El product_id no corresponde a ningun producto del stock."], 400);
        }

        // Create price register
        $price = Price::create([
            'price' => $request->price,
            'product_id' => $id,
            'currency_id' => $request->currency_id
        ]);

        if (!$price) {
            return response()->json(['message' => "No se pudo actualizar la lista de precios"], 500);
        }

        // update product price
        $product->price = $request->price;
        $product->save();

        return response()->json(['price' => $price, 201]);
    }
}
