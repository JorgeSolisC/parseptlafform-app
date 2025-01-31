<?php

namespace App\Http\Controllers\System\Tenant;

use App\Http\Controllers\Controller;
use App\Repositories\System\Tenant\TenantRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TenantController extends Controller
{
    private TenantRepository $repository;
    public function __construct(TenantRepository $repository)
    {
        $this->repository = $repository;
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $tenant = $this->repository->create();
            return response()->json($tenant, 201);
        } catch (Exception $e) {
            return response()->json([
                'message' => [$e->getMessage()],
                'line' => $e->getTrace(),
            ], 422);
        }
    }
}
