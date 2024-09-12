<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\NewController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BottomController;
use App\Http\Controllers\CateFooterController;
use App\Http\Controllers\CategoryNewController;
use App\Http\Controllers\CateMenuController;
use App\Http\Controllers\CmtNewsController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FilterCateController;
use App\Http\Controllers\FilterProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IconController;
use App\Http\Controllers\InforController;
use App\Http\Controllers\ManageController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductImagesController;
use App\Http\Controllers\ProductTagController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SliderController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes(['verify' => true]);

// Đăng ký tài khoản đăng nhập
Route::post('/register', [RegisterController::class, 'register']);

// Trang quản trị admin
Route::prefix('/admin')->middleware('verified')->group(function () {

    Route::get('/', [AdminController::class, 'index'])->name('admin.index');
    // Quản lý Danh mục 
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create')->middleware('can:category-add');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit')->middleware('can:category-edit');
    Route::put('categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy')->middleware('can:category-delete');
    Route::post('/categories/check-name', [CategoryController::class, 'checkName'])->name('categories.checkName');
    Route::post('/categories/checkbox', [CategoryController::class, 'isCheckbox'])->name('categories.isCheckbox')->middleware('can:category-checkbox');
    Route::post('/categories/checkStt', [CategoryController::class, 'checkStt'])->name('categories.checkStt')->middleware('can:category-checkStt');
    Route::get('/categories/slugs', [CategoryController::class, 'getSlugs'])->name('categories.getSlugs');

    // Quản lý Sản phẩm
    Route::get('/products', [ProductController::class, 'index'])->name('product.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('product.create')->middleware('can:product-add');
    Route::post('/products', [ProductController::class, 'store'])->name('product.store');
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('product.edit')->middleware('can:product-edit');
    Route::put('products/{id}', [ProductController::class, 'update'])->name('product.update');
    Route::delete('products/{id}', [ProductController::class, 'destroy'])->name('product.destroy')->middleware('can:product-delete');
    Route::post('/products/check-name', [ProductController::class, 'checkName'])->name('products.checkName');
    Route::post('/products/check-code', [ProductController::class, 'checkCode'])->name('products.checkCode');
    Route::post('/products/tim-kiem', [ProductController::class, 'search'])->name('products.tim-kiem');
    Route::post('/products/search-tags', [ProductController::class, 'searchTags'])->name('products.searchTags');
    Route::post('/products/checkbox', [ProductController::class, 'isCheckbox'])->name('products.isCheckbox')->middleware('can:product-checkbox');
    
    Route::resource('product-tags', ProductTagController::class)->only(['store']);
    Route::post('/product-images/checkStt', [ProductImagesController::class, 'checkStt'])->name('product-images.checkStt');
    Route::delete('product-images/{id}', [ProductImagesController::class, 'destroy'])->name('product-images.destroy');
    Route::post('/product-images/checkImg', [ProductImagesController::class, 'isCheckImg'])->name('products.isCheckImg');

    // Quản lý bộ lọc danh mục
    Route::get('/filters', [FilterCateController::class, 'index'])->name('filter.index');
    Route::get('/filters/create', [FilterCateController::class, 'create'])->name('filter.create')->middleware('can:filter-add');
    Route::post('/filters', [FilterCateController::class, 'store'])->name('filter.store');
    Route::get('/filters/{id}/edit', [FilterCateController::class, 'edit'])->name('filter.edit')->middleware('can:filter-edit');
    Route::put('filters/{id}', [FilterCateController::class, 'update'])->name('filter.update');
    Route::delete('/filters/{id}', [FilterCateController::class, 'destroy'])->name('filters.destroy')->middleware('can:filter-delete');
    Route::post('/filters/check-name', [FilterCateController::class, 'checkName'])->name('filters.checkName');
    Route::post('/filters/checkbox', [FilterCateController::class, 'isCheckbox'])->name('filters.isCheckbox')->middleware('can:filter-checkbox');
    Route::post('/filters/checkStt', [FilterCateController::class, 'checkStt'])->name('filters.checkStt')->middleware('can:filter-checkStt');
    
    Route::post('/detailFilter/checkStt', [FilterCateController::class, 'sttDetail'])->name('detailFilter.checkStt');
    // Quản lý bộ lọc của từng sản phẩm thuộc danh mục
    Route::get('/filter-pro/create', [FilterProductController::class, 'create'])->name('filterPro.create')->middleware('can:filterPro-add');
    Route::post('/filter-pro', [FilterProductController::class, 'store'])->name('filterPro.store');
    Route::get('/filter-pro/{id}/edit', [FilterProductController::class, 'edit'])->name('filterPro.edit')->middleware('can:filterPro-edit');
    Route::put('filter-pro/{id}', [FilterProductController::class, 'update'])->name('filterPro.update');

    // Quản lý danh mục bài viết
    Route::get('/cateNews', [CategoryNewController::class, 'index'])->name('cateNews.index');
    Route::get('/cateNews/create', [CategoryNewController::class, 'create'])->name('cateNews.create')->middleware('can:cateNew-add');
    Route::post('/cateNews', [CategoryNewController::class, 'store'])->name('cateNews.store');
    Route::get('/cateNews/{id}/edit', [CategoryNewController::class, 'edit'])->name('cateNews.edit')->middleware('can:cateNew-edit');
    Route::put('cateNews/{id}', [CategoryNewController::class, 'update'])->name('cateNews.update');
    Route::delete('cateNews/{id}', [CategoryNewController::class, 'destroy'])->name('cateNews.destroy')->middleware('can:cateNew-delete');
    Route::post('/cateNews/check-name', [CategoryNewController::class, 'checkName'])->name('cateNews.checkName');
    Route::post('/cateNews/tim-kiem', [CategoryNewController::class, 'search'])->name('cateNews.tim-kiem');
    Route::post('/cateNews/checkbox', [CategoryNewController::class, 'isCheckbox'])->name('cateNews.isCheckbox')->middleware('can:cateNew-checkbox');
    Route::post('/cateNews/checkStt', [CategoryNewController::class, 'checkStt'])->name('cateNews.checkStt')->middleware('can:cateNew-checkStt');
    // Quản lý bài viết
    Route::get('/news', [NewController::class, 'index'])->name('news.index');
    Route::get('/news/create', [NewController::class, 'create'])->name('news.create')->middleware('can:new-add');
    Route::post('/news', [NewController::class, 'store'])->name('news.store');
    Route::get('/news/{id}/edit', [NewController::class, 'edit'])->name('news.edit')->middleware('can:new-edit');
    Route::put('news/{id}', [NewController::class, 'update'])->name('news.update');
    Route::delete('news/{id}', [NewController::class, 'destroy'])->name('news.destroy')->middleware('can:new-delete');
    Route::post('/news/check-name', [NewController::class, 'checkName'])->name('news.checkName');
    Route::post('/news/checkbox', [NewController::class, 'isCheckbox'])->name('news.isCheckbox')->middleware('can:new-checkbox');

    // Quản lý thông tin hotline nhân viên,
    Route::get('/infors', [InforController::class, 'index'])->name('infors.index');
    Route::get('/infors/create', [InforController::class, 'create'])->name('infors.create')->middleware('can:hotline-add');
    Route::post('/infors', [InforController::class, 'store'])->name('infors.store');
    Route::get('/infors/{id}/edit', [InforController::class, 'edit'])->name('infors.edit')->middleware('can:hotline-edit');
    Route::put('infors/{id}', [InforController::class, 'update'])->name('infors.update');
    Route::delete('infors/{id}', [InforController::class, 'destroy'])->name('infors.destroy')->middleware('can:hotline-delete');
    Route::post('/infors/checkStt', [InforController::class, 'checkStt'])->name('infors.checkStt')->middleware('can:hotline-checkStt');
    Route::post('/infors/checkbox', [InforController::class, 'isCheckbox'])->name('infors.isCheckbox')->middleware('can:hotline-checkbox');
    // Báo giá
    Route::get('/quotes', [QuoteController::class, 'index'])->name('quotes.index');
    Route::post('/quotes/checkbox', [QuoteController::class, 'isCheckbox'])->name('quotes.isCheckbox');

    // Quản lý comment sản phẩm
    Route::get('/comments', [CommentController::class, 'index'])->name('comments.index');
    Route::get('/comments/{id}/edit', [CommentController::class, 'edit'])->name('comments.edit')->middleware('can:comment-edit');
    Route::put('comments/{id}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('comments/{id}', [CommentController::class, 'destroy'])->name('comments.destroy')->middleware('can:comment-delete');
    Route::post('/comments/tim-kiem', [CommentController::class, 'search'])->name('comments.tim-kiem');
    Route::post('/comments/sendCmt', [CommentController::class, 'sendCmt'])->name('comments.sendCmt');
    Route::post('/comments/parent', [CommentController::class, 'parent'])->name('comments.parent');
    Route::post('/comments/checkbox', [CommentController::class, 'isCheckbox'])->name('comments.isCheckbox')->middleware('can:comment-checkbox');
    Route::post('/comments/checkStar', [CommentController::class, 'checkStar'])->name('comments.star')->middleware('can:comment-checkStar');
    Route::get('/comments/{id}/replay', [CommentController::class, 'replay'])->name('comments.replay')->middleware('can:comment-replay');
    Route::put('cmtRep/{id}', [CommentController::class, 'repUpdate'])->name('comments.repUpdate');

    // Quản lý comment bình luận
    Route::get('/cmtNews', [CmtNewsController::class, 'index'])->name('cmtNews.index');
    Route::get('/cmtNews/{id}/edit', [CmtNewsController::class, 'edit'])->name('cmtNews.edit')->middleware('can:cmtNew-edit');
    Route::put('cmtNews/{id}', [CmtNewsController::class, 'update'])->name('cmtNews.update');
    Route::delete('cmtNews/{id}', [CmtNewsController::class, 'destroy'])->name('cmtNews.destroy')->middleware('can:cmtNew-delete');
    Route::post('/cmtNews/tim-kiem', [CmtNewsController::class, 'search'])->name('cmtNews.tim-kiem');
    Route::post('/cmtNews/sendCmt', [CmtNewsController::class, 'sendCmt'])->name('cmtNews.sendCmt');
    Route::post('/cmtNews/parent', [CmtNewsController::class, 'parent'])->name('cmtNews.parent');
    Route::post('/cmtNews/checkbox', [CmtNewsController::class, 'isCheckbox'])->name('cmtNews.isCheckbox')->middleware('can:cmtNew-checkbox');
    Route::post('/cmtNews/checkStar', [CmtNewsController::class, 'checkStar'])->name('cmtNews.star')->middleware('can:cmtNew-checkStar');
    Route::get('/cmtNews/{id}/replay', [CmtNewsController::class, 'replay'])->name('cmtNews.replay')->middleware('can:cmtNew-replay');
    Route::put('cmtNewsRep/{id}', [CmtNewsController::class, 'repUpdate'])->name('cmtNews.repUpdate');

    // Quản lý Slider
    Route::get('/sliders', [SliderController::class, 'index'])->name('sliders.index');
    Route::get('/sliders/create', [SliderController::class, 'create'])->name('sliders.create')->middleware('can:slider-add');
    Route::post('/sliders', [SliderController::class, 'store'])->name('sliders.store');
    Route::get('/sliders/{id}/edit', [SliderController::class, 'edit'])->name('sliders.edit')->middleware('can:slider-edit');
    Route::put('sliders/{id}', [SliderController::class, 'update'])->name('sliders.update');
    Route::delete('sliders/{id}', [SliderController::class, 'destroy'])->name('sliders.destroy')->middleware('can:slider-delete');
    Route::post('sliders/checkStt', [SliderController::class, 'checkStt'])->name('sliders.checkStt')->middleware('can:slider-checkStt');
    Route::post('sliders/checkbox', [SliderController::class, 'isCheckbox'])->name('sliders.isCheckbox')->middleware('can:slider-checkbox');

    // Quản lý danh mục menu
    Route::get('/cateMenu', [CateMenuController::class, 'index'])->name('cateMenu.index');
    Route::get('/cateMenu/create', [CateMenuController::class, 'create'])->name('cateMenu.create')->middleware('can:menu-add');
    Route::post('/cateMenu', [CateMenuController::class, 'store'])->name('cateMenu.store');
    Route::get('/cateMenu/{id}/edit', [CateMenuController::class, 'edit'])->name('cateMenu.edit')->middleware('can:menu-edit');
    Route::put('cateMenu/{id}', [CateMenuController::class, 'update'])->name('cateMenu.update');
    Route::delete('cateMenu/{id}', [CateMenuController::class, 'destroy'])->name('cateMenu.destroy')->middleware('can:menu-delete');
    Route::post('cateMenu/checkStt', [CateMenuController::class, 'checkStt'])->name('cateMenu.checkStt')->middleware('can:menu-checkStt');
    Route::post('cateMenu/checkbox', [CateMenuController::class, 'isCheckbox'])->name('cateMenu.isCheckbox')->middleware('can:menu-checkbox');

    // Quản lý footer
    Route::get('/cateFooter', [CateFooterController::class, 'index'])->name('cateFooter.index');
    Route::get('/cateFooter/create', [CateFooterController::class, 'create'])->name('cateFooter.create')->middleware('can:footer-add');
    Route::post('/cateFooter', [CateFooterController::class, 'store'])->name('cateFooter.store');
    Route::get('/cateFooter/{id}/edit', [CateFooterController::class, 'edit'])->name('cateFooter.edit')->middleware('can:footer-edit');
    Route::put('cateFooter/{id}', [CateFooterController::class, 'update'])->name('cateFooter.update');
    Route::delete('cateFooter/{id}', [CateFooterController::class, 'destroy'])->name('cateFooter.destroy')->middleware('can:footer-delete');
    Route::post('cateFooter/checkStt', [cateFooterController::class, 'checkStt'])->name('cateFooter.checkStt')->middleware('can:footer-checkStt');
    Route::post('cateFooter/checkbox', [cateFooterController::class, 'isCheckbox'])->name('cateFooter.isCheckbox')->middleware('can:footer-checkbox');

    // Quản lý icon phía dưới chân trang
    Route::get('/icons', [IconController::class, 'index'])->name('icons.index');
    Route::get('/icons/create', [IconController::class, 'create'])->name('icons.create')->middleware('can:icon-add');
    Route::post('/icons', [IconController::class, 'store'])->name('icons.store');
    Route::get('/icons/{id}/edit', [IconController::class, 'edit'])->name('icons.edit')->middleware('can:icon-edit');
    Route::put('icons/{id}', [IconController::class, 'update'])->name('icons.update');
    Route::delete('icons/{id}', [IconController::class, 'destroy'])->name('icons.destroy')->middleware('can:icon-delete');
    Route::post('/icons/checkStt', [IconController::class, 'checkStt'])->name('icons.checkStt')->middleware('can:icon-checkStt');
    Route::post('/icons/checkbox', [IconController::class, 'isCheckbox'])->name('icons.isCheckbox')->middleware('can:icon-checkbox');

    // Quản lý chân trang bottom
    Route::get('/bottoms', [BottomController::class, 'index'])->name('bottoms.index');
    Route::get('/bottoms/create', [BottomController::class, 'create'])->name('bottoms.create')->middleware('can:bottom-add');
    Route::post('/bottoms', [BottomController::class, 'store'])->name('bottoms.store');
    Route::get('/bottoms/{id}/edit', [BottomController::class, 'edit'])->name('bottoms.edit')->middleware('can:bottom-edit');
    Route::put('bottoms/{id}', [BottomController::class, 'update'])->name('bottoms.update');
    Route::delete('bottoms/{id}', [BottomController::class, 'destroy'])->name('bottoms.destroy')->middleware('can:bottom-delete');
    Route::post('/bottoms/checkStt', [BottomController::class, 'checkStt'])->name('bottoms.checkStt')->middleware('can:bottom-checkStt');
    Route::post('/bottoms/checkbox', [BottomController::class, 'isCheckbox'])->name('bottoms.isCheckbox')->middleware('can:bottom-checkbox');
    
    // Quản lý tài khoản đăng nhập
    Route::get('/users', [UserController::class, 'index'])->name('users.index')->middleware('can:user-list');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create')->middleware('can:user-add');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit')->middleware('can:user-edit');
    Route::put('users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('users/{id}', [UserController::class, 'destroy'])->name('users.destroy')->middleware('can:user-delete');

    // Quản lý vai trò
    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
    Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create')->middleware('can:role-add');
    Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
    Route::get('/roles/{id}/edit', [RoleController::class, 'edit'])->name('roles.edit')->middleware('can:role-edit');
    Route::put('roles/{id}', [RoleController::class, 'update'])->name('roles.update');
    Route::delete('roles/{id}', [RoleController::class, 'destroy'])->name('roles.destroy')->middleware('can:role-delete');

    // Quản lý Permission
    Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index');
    Route::get('/permissions/create', [PermissionController::class, 'create'])->name('permissions.create')->middleware('can:permission-add');
    Route::post('/permissions', [PermissionController::class, 'store'])->name('permissions.store');
    Route::get('/permissions/{id}/edit', [PermissionController::class, 'edit'])->name('permissions.edit')->middleware('can:permission-edit');
    Route::put('permissions/{id}', [PermissionController::class, 'update'])->name('permissions.update');
    Route::delete('permissions/{id}', [PermissionController::class, 'destroy'])->name('permissions.destroy')->middleware('can:permission-delete');

    // Quản lý email admin, favicon và setting của website
    Route::get('/setting/{id}/edit', [SettingController::class, 'edit'])->name('setting.edit');
    Route::put('setting/{id}', [SettingController::class, 'update'])->name('setting.update');

    Route::post('upload', [ContentController::class, 'upload'])->name('upload.image');
    Route::post('/delete-image', [ContentController::class, 'deleteImage'])->name('delete.image');

    Route::get('logout', [LoginController::class, 'logout'])->name('logoutUser');
});

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});

// Tìm kiếm
Route::get('/tim-kiem', [HomeController::class, 'search'])->name('home.search');
Route::get('/filters', [HomeController::class, 'filters'])->name('home.filters');
// Gửi báo giá
Route::post('/send-price', [QuoteController::class, 'sendRequest'])->name('price.request');
// Gửi bình luận
Route::post('/send-comment', [CommentController::class, 'sendCmt'])->name('comments.sendCmt');
Route::post('/send-cmtNews', [CmtNewsController::class, 'sendCmt'])->name('cmtNews.sendCmt');
// Trả lời bình luận
Route::post('replyCmt', [CommentController::class, 'replyCmt'])->name('cmt.replyCmt');
Route::post('reply-cmtNews', [CmtNewsController::class, 'replyCmt'])->name('cmtNews.replyCmt');
// Trang chủ phía người dùng
Route::prefix('/')->group(function () {
    Route::prefix('/blogs')->group(function () {
        Route::get('/', [BlogController::class, 'blog'])->name('home.blog');
        // Route với hai tham số
        Route::get('/{slugParent}/{slug}', [BlogController::class, 'detailBlog'])
            ->where(['slugParent' => '[a-zA-Z0-9-_]+', 'slug' => '[a-zA-Z0-9-_]+']);
        // Route với một tham số
        Route::get('/{slug}', [BlogController::class, 'cateBlog'])
            ->where('slug', '[a-zA-Z0-9-_]+');
    });
    // Trang dịch vụ
    // Route::get('/dich-vu', [ServiceController::class, 'service'])->name('home.service');

    Route::get('/', [HomeController::class, 'index'])->name('home.index');
    Route::get('/{slug}', [HomeController::class, 'category'])
        ->name('home.category')->where('slug', '[a-zA-Z0-9-_]+');
    Route::get('/contact', [HomeController::class, 'contact'])->name('home.contact');
});
Route::get('/create_sitemap', function(){
    return Artisan::call('sitemap:create');
});