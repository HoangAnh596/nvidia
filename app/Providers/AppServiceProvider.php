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
            return CateMenu::select('id', 'name', 'location', 'url', 'stt_menu')
                ->where('parent_menu', 0)
                ->where('is_public', 1)
                ->orderBy('stt_menu', 'ASC')
                ->get();
        });

        $this->app->singleton('footers', function () {
            // Lấy danh mục cha
            $parents = CateFooter::select('id', 'name', 'url', 'is_tab')
                ->where('is_public', 1)
                ->where('parent_menu', 0)
                ->orderBy('stt_menu', 'ASC')
                ->get();

            // Lấy danh mục con trực tiếp của các danh mục cha
            $children = CateFooter::whereIn('parent_menu', $parents->pluck('id'))
                ->select('id', 'name', 'url', 'is_tab', 'parent_menu')
                ->orderBy('stt_menu', 'ASC')
                ->get();

            // Gắn các danh mục con trực tiếp vào danh mục cha tương ứng
            foreach ($parents as $parent) {
                $parent->children = $children->where('parent_menu', $parent->id);
            }

            return $parents;
        });

        $this->app->singleton('searchCate', function () {
            return Category::where('parent_id', 0)->select('id', 'name')->get();
        });

        View::composer('*', function ($view) {
            $menus = $this->app->make('menus');
            $footers = $this->app->make('footers');
            // dd($footers);
            $searchCate = $this->app->make('searchCate');
            
            $view->with('menus', $menus)->with('footers', $footers)->with('searchCate', $searchCate);
        });
    }
}
