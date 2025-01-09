<?php

namespace App\Providers;

use App\Models\equipos;
use Illuminate\Support\ServiceProvider;

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
        //
        $menu = config('adminlte.menu');
    foreach ($menu as $key => $item) {
        if (isset($item['text']) && $item['text'] === 'Equipos') {
            $menu[$key]['label'] = equipos::count();
            break;
        }
    }
    config(['adminlte.menu' => $menu]);
    }
}
