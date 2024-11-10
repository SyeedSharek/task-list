<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Traits\AppResponse;

class ProductController extends Controller
{
    use AppResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {


        if (auth()->check()) {
            $products = Product::all();

            // return response()->json(['message' => 'All Products', 'products' => $products]);
            return $this->successResponse([
                'products' => $products
            ], 'All Products', 201);
        } else {
            return $this->errorResponse('Unauthorized', 401);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (Auth::check()) {
            $validation = Validator::make($request->all(), [
                'name' => 'required',
                'description' => 'required',
                'price' => 'required|numeric',
                'stock' => 'required|numeric',
            ]);

            if ($validation->fails()) {
                return response()->json(['error' => $validation->errors()->all()], 400);
            }

            // Create product and return success response
            $product = Product::create($request->all());
            return $this->successResponse($product, 'Product Created', 201);
        } else {
            return $this->errorResponse('Unauthorized', 401);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        if (Auth::check()) {

            $product = Product::find($id);
            return $this->successResponse(['products' => $product], 'All Products', 201);
        } else {
            return $this->errorResponse('Unauthorized', 401);
        }
    }


    public function edit(Product $product)
    {
        //
    }


    public function update(Request $request, $id)
    {
        if (Auth::check()) {
            $product = Product::find($id);
            $validation = Validator::make($request->all(), [
                'name' => 'required',
                'description' => 'required',
                'price' => 'required|numeric',
                'stock' => 'required|numeric',
            ]);


            if ($validation->fails()) {
                return $this->errorResponse('Validation Fails', $validation, 400);
            } else {
                $validatedData = $validation->validated();
                $product->update($validatedData);

                return $this->successResponse('', 'Product Update', 200);
            }
        } else {
            return $this->errorResponse('Unauthorizes', 401);
        }
    }

    public function destroy($id)
    {
        if (Auth::check()) {
            $product = Product::find($id);
            $product->delete();
            // return response()->json(['message' => 'Delete Succesfully'], 200);
            return $this->successResponse([], 'Delete Succesfully', 200);
        } else {
            // return $this->errorResponse('Unauthorized', 401);
            return $this->errorResponse('Unauthorized', 401);
        }
    }

    public function topSell()
    {
        if (Auth::check()) {
            $topSellingProducts = Product::orderBy('sold_count', 'desc')
                ->take(5)
                ->get();

                return $this->successResponse(['top_products'=>$topSellingProducts],'All Top Product',200);
        } else {
            return $this->errorResponse('Unauthorized', 401);
        }
    }

    public function topOrder(){
        if(Auth::check()){
            $topOrders = Order::orderBy('created_at','desc')->take(5)->with('product','customer')->get();
            return $this->successResponse(['top_orders'=>$topOrders],'All Top Order',200);

        }else{
            return $this->errorResponse('Unauthorized', 401);
        }
    }
}
