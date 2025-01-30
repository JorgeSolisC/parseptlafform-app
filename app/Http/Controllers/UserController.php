<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
        ]);

        $parseId = $this->userService->createUserInParse(
            [
                ...$request->all(),
                'password' => "123456789"
            ]
        );

        if (isset($parseId['error'])) {
            return response()->json(['error' => $parseId['error']], 400);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make(123456789),
            'parse_id' => $parseId,
        ]);

        return response()->json($user, 201);
    }

    public function storeMongo(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
        ]);

        $data = [
            'username' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => "123456789",
        ];

        $parseUrl = env('PARSE_SERVER_URL') . '/users';

        $headers = [
            'X-Parse-Application-Id' => env('PARSE_APP_ID'),
            'X-Parse-REST-API-Key' => env('PARSE_REST_API_KEY'),
            'Content-Type' => 'application/json',
        ];

        $response = Http::withHeaders($headers)->post($parseUrl, $data);

        if ($response->successful()) {
            $parseUser = $response->json();

            User::create([
                'name' => $data['username'],
                'email' => $data['email'],
                'parse_id' => $parseUser['objectId'],
                'password' => Hash::make(123456789),
            ]);
            return response()->json($parseUser, 201);
        }

        return response()->json([
            'error' => 'No se pudo crear el usuario',
            'message' => $response->body(),
        ], $response->status());
    }
}
