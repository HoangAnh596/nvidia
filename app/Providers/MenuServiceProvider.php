<?php
namespace App\Providers;

use App\Models\CateFooter;
use App\Models\CateMenu;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class MenuServiceProvider extends ServiceProvider
{
    public function boot()
    {
        View::composer('*', function ($view) {
            $menus = CateMenu::where('parent_menu', 0)
            ->with('children')
            ->orderBy('stt_menu', 'ASC')->take(10)
            ->get();

            $footers = CateFooter::where('parent_menu', 0)
            ->with('children')
            ->orderBy('stt_menu', 'ASC')->take(3)
            ->get();
            
            $view->with('menus', $menus)->with('footers', $footers);
        });
    }

    public function register()
    {
        //
    }
}
