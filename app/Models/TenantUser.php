<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class TenantUser extends Authenticatable
{

    use Notifiable,HasFactory, BelongsToTenant;

    protected $table = 'tenant_users';

    protected $fillable = [
        'name', 'email', 'password', 'tenant_id', 'role',
    ];

    protected $hidden = ['password', 'remember_token'];
}
