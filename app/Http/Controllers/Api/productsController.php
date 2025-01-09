<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Currency;
use App\Models\Price;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class productsController extends Controller
{
    //
    public function index()
    {
        $products = DB::table('products as P')
            ->join('currency as C', 'C.id', '=', 'P.currency_id')
            ->select('P.id', 'P.name', 'P.description', 'P.price', 'C.symbol', 'P.tax_cost')
            ->get();

        if ($products->isEmpty()) {
            return response()->json(['message' => "No hay productos para listar"], 200);
        }
        return response()->json($products, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'tax_cost' => 'required',
            'currency_id' => 'required',
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error al intentar almacenar el producto',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $currency = Currency::find($request->currency_id);

        if ($currency == NUll) {
            return response()->json(['message' => "El currency_id no corresponde a ninguna moneda, por favor, registrela en /api/currency"], 400);
        }

        // Create product register
        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'tax_cost' => $request->tax_cost,
            'manufacturing_cost' => $request->manufacturing_cost,
            'currency_id' => $request->currency_id
        ]);

        if (!$product) {
            return response()->json(['message' => "No se pudo almacenar el producto"], 500);
        }

        // Create Price Register
        Price::create([
            'price' => $request->price,
            'product_id' => $product->id,
            'currency_id' => $request->currency_id,
        ]);

        return response()->json(['product' => $product, 201]);
    }

    public function show($id)
    {

        $product = DB::table('products as P')
            ->join('currency as C', 'C.id', '=', 'P.currency_id')
            ->select('P.id', 'P.name', 'P.description', 'P.price', 'C.symbol', 'P.tax_cost')
            ->get();

        if (!$product) {
            return response()->json(['message' => "Producto no encontrado!"], 404);
        }

        return response()->json(['product' => $product], 200);
    }

    public function destroy($id)
    {

        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => "Producto no encontrado!"], 404);
        }

        $product->delete();

        return response()->json(['message' => "Producto eliminado!"], 200);
    }

    public function update($id, Request $request)
    {

        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => "Producto no encontrado!"], 404);
        }


        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'tax_cost' => 'required',
            'currency_id' => 'required',
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error al intentar actualizar el producto',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $currency = Currency::find($request->currency_id);

        if ($currency == NUll) {
            return response()->json(['message' => "El currency_id no corresponde a ninguna moneda, por favor, registrela en /api/currency"], 400);
        }

        // Update product fields
        $product->name =  $request->name;
        $product->description =  $request->description;
        $product->price =  $request->price;
        $product->tax_cost =  $request->tax_cost;
        $product->manufacturing_cost =  $request->manufacturing_cost;
        $product->currency_id =  $request->currency_id;

        $product->save();

        return response()->json(['product' => $product], 200);
    }
}
