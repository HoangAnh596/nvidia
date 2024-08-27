<?php

namespace App\Providers;

use App\Models\Bottom;
use App\Models\CateFooter;
use App\Models\Category;
use App\Models\CateMenu;
use App\Models\Icon;
use App\Models\Setting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;

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
        \App\Models\Category::observe(\App\Observers\CategoryObserver::class);
        \App\Models\Product::observe(\App\Observers\ProductObserver::class);
        \App\Models\News::observe(\App\Observers\NewObserver::class);

        Paginator::useBootstrap();
        Schema::defaultStringLength(191);
        // đảm bảo sql chỉ chạy 1 lần
        $this->app->singleton('menus', function () {
            return CateMenu::select('id', 'name', 'url', 'stt_menu', 'is_click', 'is_tab')
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
        // favicon
        $this->app->singleton('favicon', function () {
            return Setting::where('id', 1)->select('id', 'image')->get();
        });
        // Icon footer
        $this->app->singleton('icon', function () {
            return Icon::where('is_public', 1)->orderBy('stt', 'ASC')->select('id', 'url', 'name', 'icon')->get();
        });
        // Chân trang dưới footer
        $this->app->singleton('bottom', function () {
            return Bottom::where('is_public', 1)->orderBy('stt', 'ASC')->select('id', 'name', 'url')->get();
        });

        // Cấu hình gửi mail báo
        $settings = Setting::where('id', 1)->select('id', 'mail_name', 'mail_pass', 'mail_text')->first();
        if ($settings) {
            // Cập nhật config với các giá trị từ bản ghi settings
            Config::set('mail.mailers.smtp.username', $settings->mail_name);
            Config::set('mail.mailers.smtp.password', $settings->mail_pass);
            Config::set('mail.from.address', $settings->mail_name);
            Config::set('mail.from.name', $settings->mail_text);
            // Cập nhật các giá trị khác tương tự
        }
        
        View::composer('*', function ($view) {
            $menus = $this->app->make('menus');
            $footers = $this->app->make('footers');
            $searchCate = $this->app->make('searchCate');
            $favi = $this->app->make('favicon');
            $iconGlobal = $this->app->make('icon');
            $ft_bottom = $this->app->make('bottom');

            $view->with('menus', $menus)->with('footers', $footers)
                ->with('searchCate', $searchCate)->with('favi', $favi)
                ->with('iconGlobal', $iconGlobal)
                ->with('ft_bottom', $ft_bottom);
        });
    }
}
