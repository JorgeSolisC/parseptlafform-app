<?php

namespace App\Console\Commands;

use App\Models\System\Tenant\Tenant;
use App\Models\User\User;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class CreateTenant extends Command
{
    protected $signature = 'tenant:create {id} {domain}';
    protected $description = 'Create a new tenant with a given ID and domain';

    public function handle()
    {
        $id = $this->argument('id');
        $domain = $this->argument('domain');

        $tenant = Tenant::where('id', $id)->first();
        if ($tenant) {
            $this->error("A tenant with ID '$id' already exists.");
            return;
        } else
            $tenant = Tenant::create([
                'id' => $id,
                'uuid' => Str::uuid(),
                'user_id' => User::first()->id,
                'domain' => $domain,
            ]);

        $tenant->domains()->create([
            'domain' => $domain,
        ]);

        $this->info("Tenant '$id' created successfully with domain '$domain'!");

        //$tenant->makeCurrent();
        $this->call('tenants:migrate'); 
        $this->info("Migrations executed for tenant '$id'.");
    }
}
