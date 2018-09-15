<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class PassportController extends Controller
{
    const TOKEN_STRING = 'CatalogApiTest';
    /**
     * Обработчик запроса на регистрацию пользователей
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $this->validate($request, [
            'name'     => 'required|min:3',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password)
        ]);

        $token = $user->createToken(self::TOKEN_STRING)->accessToken;

        return response()->json(['token' => $token], 200);
    }

    /**
     * Обработчик запроса на авторизацию пользователя
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $creditials = [
            'email'    => $request->email,
            'password' => $request->password
        ];

        if (auth()->attempt($creditials)) {
            $token = auth()->user()->createToken(self::TOKEN_STRING)->accessToken;

            return response()->json(['token' => $token], 200);
        }

        return response()->json(['error' => 'Unauthorised'], 401);
    }

    /**
     * Обработчик запроса на отображение информации
     * об авторизованном пользователе
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function details()
    {
        return response()->json(['user' => auth()->user()], 200);
    }
}
