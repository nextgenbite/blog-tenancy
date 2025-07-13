<?php

namespace App\Http\Controllers;

use App\Http\Requests\TenancyStoreRequest;
use App\Models\Tenant;
use Illuminate\Http\Request;

class TenancyController extends Controller
{

    public function index()
    {
        $data = Tenant::all();
        return view('tenant.index', compact('data'));
    }
    public function register()
    {
        return view('auth.tenancy_register');
    }

    public function  store(TenancyStoreRequest $request)
    {
        $tenant = Tenant::create($request->validated());
        $tenant->createDomain(['domain' => $request->domain]);
        return redirect(route('tenant.index'));
        // return $tenant->password;
    }
}
