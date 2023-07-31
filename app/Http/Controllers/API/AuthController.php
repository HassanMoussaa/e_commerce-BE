<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Cart;


class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $credentials = $request->only('email', 'password');
        $token = Auth::attempt($credentials);

        if (!$token) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 401);
        }

        $user = Auth::user();
        return response()->json([
            'user' => $user,
            'authorization' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }

    public function register(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',

        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'user_types_id' => $request->user_types_id,
        ]);


        // // Create a new cart for the user
        // $cart = Cart::create([
        //     'user_id' => $user->id,
        // ]);

        try {
            $cart = Cart::create([
                'user_id' => $user->id,
            ]);

            return response()->json([
                'message' => 'User created successfully',
                'user' => $user,
                'cart' => $cart
            ]);
        } catch (\Exception $e) {
            // Log the error or send it as a response for debugging
            return response()->json([
                'message' => 'Error occurred during registration',
                'error' => $e->getMessage(),
            ], 500);
        }

        // return response()->json([
        //     'message' => 'User created successfully',
        //     'user' => $user,
        //     'cart' => $cart
        // ]);
    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'message' => 'Successfully logged out',
        ]);
    }

    public function refresh()
    {
        return response()->json([
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }
}