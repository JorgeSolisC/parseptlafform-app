<?php

namespace App\Models\Tenant\Collaborator;

use MongoDB\Laravel\Eloquent\Model;

class User extends Model
{
    protected $connection = 'mongodb';
    protected $collection = '_User';

    protected $fillable = [
        'tenant_id',
        'name',
        'email',
        'password',
        'parse_id',
    ];
}
