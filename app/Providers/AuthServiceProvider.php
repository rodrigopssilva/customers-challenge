<?php

namespace App\Providers;

use App\Models\Customer;
use App\Policies\CustomersPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Customer::class => CustomersPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     * @codeCoverageIgnore
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
