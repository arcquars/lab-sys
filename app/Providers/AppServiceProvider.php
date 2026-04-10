<?php

namespace App\Providers;

use App\Analisis;
use App\Observers\AnalisisObserver;
use App\TextoPredefinido;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Analisis::observe(AnalisisObserver::class);
        view()->composer('textopredefinido.includes.texto-list', function($view){
            $view->with('tlist', TextoPredefinido::where('user_id', Auth::id())->get());
        });
    }
}
