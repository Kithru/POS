<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Category;

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
    public function boot(): void{
        View::composer(['layouts.header', 'layouts.footer', 'layouts.headernavi'], function ($view) {
            $categories = Category::whereHas('items', function ($query) {
                $query->where('status', 1); // only categories with active items
            })->get();

            $view->with('categories', $categories);
        });
    }
}