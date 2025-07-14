<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;


class TenantUser extends Authenticatable
{

    use Notifiable, BelongsToTenant;

    protected $table = 'tenant_users';

    protected $fillable = [
        'name', 'email', 'password', 'tenant_id', 'role',
    ];

    protected $hidden = ['password', 'remember_token'];
}
