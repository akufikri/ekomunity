<?php

namespace App\Providers;

use App\Models\SettingBranding;
use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if (env('APP_ENV') !== 'local') {
            \URL::forceScheme('https');
        }

         View::composer('*', function ($view) {
            $brand = SettingBranding::first(); // misal ambil brand default
            $view->with('global_brand', $brand);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        config(['app.locale' => 'id']);
        Carbon::setLocale('id');
        date_default_timezone_set('Asia/Jakarta');
    }
}
