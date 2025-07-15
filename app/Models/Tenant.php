<?php

namespace App\Models;

use Illuminate\Support\Facades\Hash;
use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;

class Tenant extends BaseTenant implements TenantWithDatabase
{
    use HasDatabase, HasDomains;
    // protected $guarded = [];
    // public function setPasswordAttribute($value)
    // {
    //     $this->attributes['password'] = Hash::make($value);
    // }

    // public function setPasswordAttribute($value)
    // {
    //     $this->attributes['password'] = encrypt($value);
    // }

    public function getPlanAttribute()
{
    return Plan::find($this->plan_id ?? null);
}

}
