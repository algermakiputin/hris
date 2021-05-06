<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */

    protected $policies = [
        App\employee::class => App\Policies\EmployeePolicy::class
    ];

    public function boot()
    { 
        $this->registerPolicies();

        if(config('app.env') === 'production') {
            \URL::forceScheme('https');
        }
        
        Gate::define('show','App\Policies\EmployeePolicy@show');
        Gate::define('edit','App\Policies\EmployeePolicy@edit');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
