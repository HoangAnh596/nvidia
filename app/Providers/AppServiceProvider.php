<?php

namespace App\Providers;

use App\Models\Bottom;
use App\Models\CateFooter;
use App\Models\Category;
use App\Models\CategoryNew;
use App\Models\CateMenu;
use App\Models\CmtNew;
use App\Models\Comment;
use App\Models\ContactIcon;
use App\Models\HeaderTag;
use App\Models\Icon;
use App\Models\Quote;
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
                ->where('is_public', 1)
                ->orderBy('stt_menu', 'ASC')
                ->get();

            // Gắn các danh mục con trực tiếp vào danh mục cha tương ứng
            foreach ($parents as $parent) {
                $parent->children = $children->where('parent_menu', $parent->id);
            }

            return $parents;
        });

        $this->app->singleton('searchCate', function () {
            // Lấy dữ liệu từ cả hai bảng và hợp lại
            $categories = Category::where('parent_id', 0)
                ->select('id', 'name')
                ->get()
                ->map(function ($item) {
                    $item->source = 'prod'; // Gán giá trị 'source' cho Category
                    return $item;
                });

            // Lấy dữ liệu từ bảng CategoryNew và thêm trường 'source' để phân biệt
            $cateNews = CategoryNew::where('parent_id', 0)
                ->select('id', 'name')
                ->get()
                ->map(function ($item) {
                    $item->source = 'news'; // Gán giá trị 'source' cho CategoryNew
                    return $item;
                });

            return $categories->concat($cateNews);
        });

        // Thẻ tiếp thị
        $this->app->singleton('headerTags', function () {
            return HeaderTag::where('is_public', 1)->select('id', 'content')->get();
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
        // Cấu hình SEO
        $this->app->singleton('seoWeb', function () {
            return Setting::where('id', 1)->select('title_seo', 'keyword_seo', 'des_seo')->first();
        });
        // Cấu hình icon liên hệ
        $this->app->singleton('contact-icons', function () {
            return ContactIcon::where('is_public', 1)->orderBy('stt', 'ASC')->select('id', 'url', 'name', 'image', 'animation')->get();
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

        // Cấu hình thông báo website
        $this->app->singleton('comments', function () {
            return Comment::where('parent_id', 0)
                  ->whereDoesntHave('replies') // Lấy các comment không có replies
                  ->with('replies') // Để có thể lấy các replies nếu cần
                  ->get();
        });
        $this->app->singleton('cmtNew', function () {
            return CmtNew::where('parent_id', 0)
                  ->whereDoesntHave('replies') // Lấy các comment không có replies
                  ->with('replies') // Để có thể lấy các replies nếu cần
                  ->get();
        });
        $this->app->singleton('quotes', function () {
            return Quote::where('status', 0)->orderBy('created_at', 'DESC')->select('id', 'name', 'product', 'created_at')->get();
        });
        
        View::composer('*', function ($view) {
            $globalMenus = $this->app->make('menus');
            $globalFooters = $this->app->make('footers');
            $searchCate = $this->app->make('searchCate');
            $globalFavi = $this->app->make('favicon');
            $globalHeaderTags = $this->app->make('headerTags');
            $iconGlobal = $this->app->make('icon');
            $ft_bottom = $this->app->make('bottom');
            $globalSeo = $this->app->make('seoWeb');
            $contactIconGlobal = $this->app->make('contact-icons');
            $quoteGlobal = $this->app->make('quotes');
            $commentGlobal = $this->app->make('comments');
            $cmtNewGlobal = $this->app->make('cmtNew');
            // dd($quoteGlobal);
            $view->with('globalMenus', $globalMenus)->with('globalFooters', $globalFooters)
                ->with('searchCate', $searchCate)->with('globalFavi', $globalFavi)
                ->with('globalHeaderTags', $globalHeaderTags)
                ->with('iconGlobal', $iconGlobal)
                ->with('ft_bottom', $ft_bottom)
                ->with('globalSeo', $globalSeo)
                ->with('contactIconGlobal', $contactIconGlobal)
                ->with('commentGlobal', $commentGlobal)
                ->with('cmtNewGlobal', $cmtNewGlobal)
                ->with('quoteGlobal', $quoteGlobal);
        });
    }
}
