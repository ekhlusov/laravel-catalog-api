<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Получаем все товары авторизованного пользователя
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $products = auth()->user()->products;

        return response()->json([
            'success' => true,
            'data'    => $products
        ]);
    }

    /**
     * Получаем товар по id для авторизованного пользователя
     *
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $product = auth()->user()->products()->find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => "Product with id {$id} not found"
            ], 400);
        }

        return response()->json([
            'success' => true,
            'data'    => $product->toArray()
        ]);
    }

    /**
     * Сохраняет товар для авторизованного пользователя
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request,
            [
                'title'       => 'required',
                'price'       => 'required|integer', // @TODO float
                'category_id' => 'required|integer|max:150|exists:categories,id'
            ],
            [
                'category_id.exists' => "Category with id {$request->category_id} not found"
            ]
        );
        $product = new Product();
        $product->title = $request->title;
        $product->price = $request->price;
        $product->category_id = $request->category_id;

        if (auth()->user()->products()->save($product)) {
            return response()->json([
                'success' => true,
                'data'    => $product->toArray()
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Product could not be added'
        ], 500);
    }


    /**
     * Обновляем товар авторизованного пользователя
     *
     * @param \Illuminate\Http\Request $request
     * @param                          $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $product = auth()->user()->products()->find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => "Product with id {$id} not found"
            ], 400);
        }

        $updated = $product->fill($request->all())->save();

        if ($updated) {
            return response()->json([
                'success' => true
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Product could not be updated'
        ], 500);
    }

    /**
     * Удаляем товар для авторизованного пользователя
     *
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $product = auth()->user()->products()->find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => "Product with id {$id} not found"
            ], 400);
        }

        if ($product->delete()) {
            return response()->json([
                'success' => true
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Product could not be deleted'
        ], 500);
    }

    /**
     * Получаем список всех товаров
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function all()
    {
        return response()->json([
            'success' => true,
            'data' => Product::all()->toArray()
        ]);
    }
}
