<?php

namespace App\Providers;

use App\Models\CateFooter;
use App\Models\Category;
use App\Models\CateMenu;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
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
        $this->app->singleton(\App\Services\CategoryNewSrc::class, function ($app) {
            return new \App\Services\CategoryNewSrc();
        });
        $this->app->singleton(\App\Services\CategorySrc::class, function ($app) {
            return new \App\Services\CategorySrc();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
        Schema::defaultStringLength(191);
        // đảm bảo sql chỉ chạy 1 lần
        $this->app->singleton('menus', function () {
            return CateMenu::where('parent_menu', 0)
                ->with('children')
                ->orderBy('stt_menu', 'ASC')
                ->take(10)
                ->get();
        });

        $this->app->singleton('footers', function () {
            return CateFooter::where('parent_menu', 0)
                ->with('children')
                ->orderBy('stt_menu', 'ASC')
                ->take(3)
                ->get();
        });

        $this->app->singleton('searchCate', function () {
            return Category::where('parent_id', 0)->get();
        });

        View::composer('*', function ($view) {
            $menus = $this->app->make('menus');
            $footers = $this->app->make('footers');
            $searchCate = $this->app->make('searchCate');
            
            $view->with('menus', $menus)->with('footers', $footers)->with('searchCate', $searchCate);
        });
    }
}
