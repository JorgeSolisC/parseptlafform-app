<?php

namespace App\Console\Commands;

use App\Http\Controllers\Tenant\CollaboratorController;
use App\Models\System\Tenant\Tenant;
use App\Models\Tenant\Collaborator\Collaborator;
use Illuminate\Console\Command;
use App\Services\UserService;
use Illuminate\Http\Request;

class CreateTenantUserSDK extends Command
{
    protected $signature = 'tenant:user-create-sdk {tenant_id}';

    protected $description = 'Create a new user within a specific tenant';

    public function handle()
    {
        $tenantId = $this->argument('tenant_id');
        $name = fake()->name();
        $email = fake()->email();

        $tenant = Tenant::find($tenantId);
        if (!$tenant) {
            $this->error("Tenant with ID '$tenantId' not found.");
            return;
        }
        tenancy()->initialize($tenant);
        if (Collaborator::where('email', $email)->exists()) {
            $this->error("User with email '$email' already exists in this tenant.");
            return;
        }

        $userService = app(UserService::class);
        $controller = new CollaboratorController($userService);

         $user = $controller->store(new Request([
             'name' => $name,
             'email' => $email,
             'tenant_id' => $tenant->id,
         ]));

        $this->info("User {$user} created successfully in tenant.");
    }
}
