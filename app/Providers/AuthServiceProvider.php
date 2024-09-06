<?php

namespace App\Providers;

use App\Policies\CategoryNewPolicy;
use App\Policies\CategoryPolicy;
use App\Policies\FooterPolicy;
use App\Policies\InforPolicy;
use App\Policies\MenuPolicy;
use App\Policies\NewPolicy;
use App\Policies\ProductPolicy;
use App\Policies\RolePolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Gate::define('category-list', function ($user) {
        //     return $user->checkPermissionAccess(config('permissions.access.list-category'));
        // });

        $this->defineCategory();
        $this->defineProduct();
        $this->defineCategoryNew();
        $this->defineNew();
        $this->defineHotline();
        $this->defineMenu();
        $this->defineFooter();
        $this->defineUser();
        $this->defineRole();
    }

    public function defineCategory()
    {
        Gate::define('category-list', [CategoryPolicy::class, 'view']);
        Gate::define('category-add', [CategoryPolicy::class, 'create']);
        Gate::define('category-edit', [CategoryPolicy::class, 'update']);
        Gate::define('category-delete', [CategoryPolicy::class, 'delete']);
    }

    public function defineProduct()
    {
        Gate::define('product-list', [ProductPolicy::class, 'view']);
        Gate::define('product-add', [ProductPolicy::class, 'create']);
        Gate::define('product-edit', [ProductPolicy::class, 'update']);
        Gate::define('product-delete', [ProductPolicy::class, 'delete']);
    }

    public function defineCategoryNew()
    {
        Gate::define('cateNew-list', [CategoryNewPolicy::class, 'view']);
        Gate::define('cateNew-add', [CategoryNewPolicy::class, 'create']);
        Gate::define('cateNew-edit', [CategoryNewPolicy::class, 'update']);
        Gate::define('cateNew-delete', [CategoryNewPolicy::class, 'delete']);
    }

    public function defineNew()
    {
        Gate::define('new-list', [NewPolicy::class, 'view']);
        Gate::define('new-add', [NewPolicy::class, 'create']);
        Gate::define('new-edit', [NewPolicy::class, 'update']);
        Gate::define('new-delete', [NewPolicy::class, 'delete']);
    }

    public function defineHotline()
    {
        Gate::define('hotline-list', [InforPolicy::class, 'view']);
        Gate::define('hotline-add', [InforPolicy::class, 'create']);
        Gate::define('hotline-edit', [InforPolicy::class, 'update']);
        Gate::define('hotline-delete', [InforPolicy::class, 'delete']);
    }

    public function defineMenu()
    {
        Gate::define('menu-list', [MenuPolicy::class, 'view']);
        Gate::define('menu-add', [MenuPolicy::class, 'create']);
        Gate::define('menu-edit', [MenuPolicy::class, 'update']);
        Gate::define('menu-delete', [MenuPolicy::class, 'delete']);
    }

    public function defineFooter()
    {
        Gate::define('footer-list', [FooterPolicy::class, 'view']);
        Gate::define('footer-add', [FooterPolicy::class, 'create']);
        Gate::define('footer-edit', [FooterPolicy::class, 'update']);
        Gate::define('footer-delete', [FooterPolicy::class, 'delete']);
    }

    public function defineUser()
    {
        Gate::define('user-list', [UserPolicy::class, 'view']);
        Gate::define('user-add', [UserPolicy::class, 'create']);
        Gate::define('user-edit', [UserPolicy::class, 'update']);
        Gate::define('user-delete', [UserPolicy::class, 'delete']);
    }

    public function defineRole()
    {
        Gate::define('role-list', [RolePolicy::class, 'view']);
        Gate::define('role-add', [RolePolicy::class, 'create']);
        Gate::define('role-edit', [RolePolicy::class, 'update']);
        Gate::define('role-delete', [RolePolicy::class, 'delete']);
    }
}
