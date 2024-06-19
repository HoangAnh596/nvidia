<?php
namespace App\Providers;

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
            ->orderBy('stt_menu', 'ASC')->take(7)
            ->get();
            // dd($menus);
            $view->with('menus', $menus);
        });
    }

    public function register()
    {
        //
    }
}
