<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Validator::extend('float', function ($attribute, $value, $parameters, $validator) {
            return filter_var($value, FILTER_VALIDATE_FLOAT) !== false;
        }, 'The :attribute must be a valid float.');
    }
}
