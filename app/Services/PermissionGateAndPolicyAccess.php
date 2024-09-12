<?php

namespace App\Services;

use App\Policies\BottomPolicy;
use Illuminate\Support\Facades\Gate;
use App\Policies\CategoryNewPolicy;
use App\Policies\CategoryPolicy;
use App\Policies\CommentNewPolicy;
use App\Policies\CommentPolicy;
use App\Policies\FilterPolicy;
use App\Policies\FilterProductPolicy;
use App\Policies\FooterPolicy;
use App\Policies\IconPolicy;
use App\Policies\InforPolicy;
use App\Policies\MenuPolicy;
use App\Policies\NewPolicy;
use App\Policies\PermissionPolicy;
use App\Policies\ProductPolicy;
use App\Policies\RolePolicy;
use App\Policies\SliderPolicy;
use App\Policies\UserPolicy;

class PermissionGateAndPolicyAccess {

    public function setGateAndPolicyAccess()
    {
        $this->defineCategory();
        $this->defineProduct();
        $this->defineCategoryNew();
        $this->defineNew();
        $this->defineHotline();
        $this->defineMenu();
        $this->defineSlider();
        $this->defineFooter();
        $this->defineBottom();
        $this->defineComment();
        $this->defineCommentNew();
        $this->defineIcon();
        $this->defineFilter();
        $this->defineFilterProduct();

        $this->defineUser();
        $this->defineRole();
        $this->definePermission();
    }

    public function defineCategory()
    {
        // Gate::define('category-list', [CategoryPolicy::class, 'view']);
        Gate::define('category-add', [CategoryPolicy::class, 'create']);
        Gate::define('category-edit', [CategoryPolicy::class, 'update']);
        Gate::define('category-delete', [CategoryPolicy::class, 'delete']);
        Gate::define('category-checkbox', [CategoryPolicy::class, 'checkbox']);
        Gate::define('category-checkStt', [CategoryPolicy::class, 'checkStt']);
    }

    public function defineProduct()
    {
        // Gate::define('product-list', [ProductPolicy::class, 'view']);
        Gate::define('product-add', [ProductPolicy::class, 'create']);
        Gate::define('product-edit', [ProductPolicy::class, 'update']);
        Gate::define('product-delete', [ProductPolicy::class, 'delete']);
        Gate::define('product-checkbox', [ProductPolicy::class, 'checkbox']);
    }

    public function defineCategoryNew()
    {
        // Gate::define('cateNew-list', [CategoryNewPolicy::class, 'view']);
        Gate::define('cateNew-add', [CategoryNewPolicy::class, 'create']);
        Gate::define('cateNew-edit', [CategoryNewPolicy::class, 'update']);
        Gate::define('cateNew-delete', [CategoryNewPolicy::class, 'delete']);
        Gate::define('cateNew-checkbox', [CategoryNewPolicy::class, 'checkbox']);
        Gate::define('cateNew-checkStt', [CategoryNewPolicy::class, 'checkStt']);
    }

    public function defineNew()
    {
        // Gate::define('new-list', [NewPolicy::class, 'view']);
        Gate::define('new-add', [NewPolicy::class, 'create']);
        Gate::define('new-edit', [NewPolicy::class, 'update']);
        Gate::define('new-delete', [NewPolicy::class, 'delete']);
        Gate::define('new-checkbox', [NewPolicy::class, 'checkbox']);
    }

    public function defineHotline()
    {
        // Gate::define('hotline-list', [InforPolicy::class, 'view']);
        Gate::define('hotline-add', [InforPolicy::class, 'create']);
        Gate::define('hotline-edit', [InforPolicy::class, 'update']);
        Gate::define('hotline-delete', [InforPolicy::class, 'delete']);
        Gate::define('hotline-checkbox', [InforPolicy::class, 'checkbox']);
        Gate::define('hotline-checkStt', [InforPolicy::class, 'checkStt']);
    }

    public function defineMenu()
    {
        // Gate::define('menu-list', [MenuPolicy::class, 'view']);
        Gate::define('menu-add', [MenuPolicy::class, 'create']);
        Gate::define('menu-edit', [MenuPolicy::class, 'update']);
        Gate::define('menu-delete', [MenuPolicy::class, 'delete']);
        Gate::define('menu-checkbox', [MenuPolicy::class, 'checkbox']);
        Gate::define('menu-checkStt', [MenuPolicy::class, 'checkStt']);
    }

    public function defineSlider()
    {
        Gate::define('slider-add', [SliderPolicy::class, 'create']);
        Gate::define('slider-edit', [SliderPolicy::class, 'update']);
        Gate::define('slider-delete', [SliderPolicy::class, 'delete']);
        Gate::define('slider-checkbox', [SliderPolicy::class, 'checkbox']);
        Gate::define('slider-checkStt', [SliderPolicy::class, 'checkStt']);
    }

    public function defineFooter()
    {
        // Gate::define('footer-list', [FooterPolicy::class, 'view']);
        Gate::define('footer-add', [FooterPolicy::class, 'create']);
        Gate::define('footer-edit', [FooterPolicy::class, 'update']);
        Gate::define('footer-delete', [FooterPolicy::class, 'delete']);
        Gate::define('footer-checkbox', [FooterPolicy::class, 'checkbox']);
        Gate::define('footer-checkStt', [FooterPolicy::class, 'checkStt']);
    }

    public function defineBottom()
    {
        // Gate::define('bottom-list', [BottomPolicy::class, 'view']);
        Gate::define('bottom-add', [BottomPolicy::class, 'create']);
        Gate::define('bottom-edit', [BottomPolicy::class, 'update']);
        Gate::define('bottom-delete', [BottomPolicy::class, 'delete']);
        Gate::define('bottom-checkbox', [BottomPolicy::class, 'checkbox']);
        Gate::define('bottom-checkStt', [BottomPolicy::class, 'checkStt']);
    }

    public function defineIcon()
    {
        // Gate::define('icon-list', [IconPolicy::class, 'view']);
        Gate::define('icon-add', [IconPolicy::class, 'create']);
        Gate::define('icon-edit', [IconPolicy::class, 'update']);
        Gate::define('icon-delete', [IconPolicy::class, 'delete']);
        Gate::define('icon-checkbox', [IconPolicy::class, 'checkbox']);
        Gate::define('icon-checkStt', [IconPolicy::class, 'checkStt']);
    }

    public function defineComment()
    {
        Gate::define('comment-edit', [CommentPolicy::class, 'update']);
        Gate::define('comment-delete', [CommentPolicy::class, 'delete']);
        Gate::define('comment-checkbox', [CommentPolicy::class, 'checkbox']);
        Gate::define('comment-checkStar', [CommentPolicy::class, 'checkStar']);
        Gate::define('comment-replay', [CommentPolicy::class, 'replay']);
    }

    public function defineCommentNew()
    {
        Gate::define('commentNew-edit', [CommentNewPolicy::class, 'update']);
        Gate::define('commentNew-delete', [CommentNewPolicy::class, 'delete']);
        Gate::define('commentNew-checkbox', [CommentNewPolicy::class, 'checkbox']);
        Gate::define('commentNew-checkStar', [CommentNewPolicy::class, 'checkStar']);
        Gate::define('commentNew-replay', [CommentNewPolicy::class, 'replay']);
    }

    public function defineFilter()
    {
        // Gate::define('filter-list', [FilterPolicy::class, 'view']);
        Gate::define('filter-add', [FilterPolicy::class, 'create']);
        Gate::define('filter-edit', [FilterPolicy::class, 'update']);
        Gate::define('filter-delete', [FilterPolicy::class, 'delete']);
        Gate::define('filter-checkbox', [FilterPolicy::class, 'checkbox']);
        Gate::define('filter-checkStt', [FilterPolicy::class, 'checkStt']);
    }

    public function defineFilterProduct()
    {
        Gate::define('filterPro-add', [FilterProductPolicy::class, 'create']);
        Gate::define('filterPro-edit', [FilterProductPolicy::class, 'update']);
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

    public function definePermission()
    {
        Gate::define('permission-list', [PermissionPolicy::class, 'view']);
        Gate::define('permission-add', [PermissionPolicy::class, 'create']);
        Gate::define('permission-edit', [PermissionPolicy::class, 'update']);
        Gate::define('permission-delete', [PermissionPolicy::class, 'delete']);
    }
}