<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Schema\Builder;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}


    public function boot(): void
    {
        Schema::defaultStringLength(191);

        Builder::defaultStringLength(191);
    }
}
