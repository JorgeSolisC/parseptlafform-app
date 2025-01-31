<?php
namespace App\Repositories\System\Tenant;
use App\Models\System\Tenant\Tenant;
use App\Repositories\IndexRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
/**
 * Class InvoiceRepository
 */
class TenantRepository extends IndexRepository
{
    public Model $model;
    public function __construct(Tenant $tenant)
    {
        $this->model = $tenant;
    }
    public function create(): Tenant
    {
        $uuid = str_replace('-', null, Str::uuid());
        $password = md5(sprintf('%s.%d', $uuid, Carbon::now()->toDateTimeString()));
        $tenant = Tenant::create([
            'uuid' => $uuid,
            'tenancy_db_name' => $uuid,
            'tenancy_db_username' => $password,
            'tenancy_db_password' => $password,
        ]);
        return $tenant;
    }
}