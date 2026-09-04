<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Category;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
        View::composer('storefront.partials.navbar', function ($view) {
            $view->with('navCategories', Category::orderBy('name')->get());
        });
    }
}
