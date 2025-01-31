<?php

namespace Tests\Feature;

use Tests\TestCase;

class TenantTest extends TestCase
{
    /** @test */
    public function tenantCanBeCreated(): void
    {
        $this->actingAs($this->user, 'api');
        $tenant_attributes = [
            'subdomain' => fake()->domainWord(),
        ];
        $response = $this->post(route('tenants.store'), $tenant_attributes);
        $response->assertStatus(201);
    }
}
