<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Tenant\Collaborator\Collaborator;
use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class CollaboratorController extends Controller
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
            'tenant_id' => 'nullable|string',
            'email' => 'required|email|unique:collaborators',
        ]);

        $data = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'tenant_id' => $request->input('tenant_id') ?? null,
            'password' => "123456789",
        ];

        $parseId = $this->userService->createUserInParse($data);

        if (isset($parseId['error'])) {
            return response()->json(['error' => $parseId['error']], 400);
        }

        $user = Collaborator::create([
            'name' => $request->name,
            'email' => $request->email,
            'tenant_id' => $request->tenant_id,
            'password' => Hash::make(123456789),
            'parse_id' => $parseId,
        ]);

        return response()->json($user, 201);
    }

    public function storeMongo(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'tenant_id' => 'nullable|string',
            'email' => 'required|email|unique:collaborators',
        ]);

        $data = [
            'username' => $request->input('name'),
            'email' => $request->input('email'),
            'tenant_id' => $request->input('tenant_id') ?? null,
            'password' => "123456789",
        ];

        $parseUrl = config('services.parse.server_url') . '/users';

        $headers = [
            'X-Parse-Application-Id' => config('services.parse.app_id'),
            'X-Parse-REST-API-Key' => config('services.parse.rest_key'),
            'Content-Type' => 'application/json',
        ];

        $response = Http::withHeaders($headers)->post($parseUrl, $data);

        if ($response->successful()) {
            $parseUser = $response->json();

            Collaborator::create([
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
