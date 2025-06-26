<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Schema\Builder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Response; // Добавлен этот импорт

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
        // Для совместимости с MariaDB
        Schema::defaultStringLength(191);
        
        // Альтернативная настройка (можно использовать вместо предыдущей)
        Builder::defaultStringLength(191);
    }
}