<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Получаем все категории авторизованного пользователя
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $categories = auth()->user()->categories;

        return response()->json([
            'success' => true,
            'data'    => $categories
        ]);
    }

    /**
     * Получаем категорию по id для авторизованного пользователя
     *
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $category = auth()->user()->categories()->find($id);

        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => "Category with {$id} not found"
            ], 400);
        }

        return response()->json([
            'success' => true,
            'data'    => $category->toArray()
        ], 400);
    }

    /**
     * Сохраняет категорию для авторизованного пользователя
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
        ]);
        $category = new Category();
        $category->title = $request->title;

        if (auth()->user()->categories()->save($category)) {
            return response()->json([
                'success' => true,
                'data'    => $category->toArray()
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Category could not be added'
        ], 500);
    }


    /**
     * Обновляем категорию для авторизованного пользователя
     *
     * @param \Illuminate\Http\Request $request
     * @param                          $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $category = auth()->user()->categories()->find($id);

        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => "Category with {$id} not found"
            ], 400);
        }

        $updated = $category->fill($request->all())->save();

        if ($updated) {
            return response()->json([
                'success' => true,
                'message' => "Category with {$id} successfully updated"
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Category could not be updated'
        ], 500);
    }

    /**
     * Удаляем категорию для авторизованного пользователя
     *
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $category = auth()->user()->categories()->find($id);

        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => "Category with {$id} not found"
            ], 400);
        }

        if ($category->delete()) {
            return response()->json([
                'success' => true,
                'message' => "Category with id {$id} deleted"
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Category could not be deleted'
        ], 500);
    }

    /**
     * Получаем список всех категорий
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function all()
    {
        return response()->json([
            'success' => true,
            'data'    => Category::all()->toArray()
        ]);
    }

    /**
     * Получаем список товаров в категории
     *
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProductsByCategoryId($id)
    {
        return response()->json([
            'success' => true,
            'data'    => Category::find($id)->products()
        ]);
    }
}
