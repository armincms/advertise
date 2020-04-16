<?php

namespace Armincms\Advertise;

 
use Illuminate\Support\ServiceProvider; 
use Laravel\Nova\Nova as LaravelNova;   

class ToolServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {  
        LaravelNova::serving([$this, 'servingNova']);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    { 
    }

    public function servingNova()
    { 
        LaravelNova::resources([ 
            Nova\Advertise::class,
            Nova\Category::class,  
            Nova\Tag::class,  
        ]);
    } 
}
