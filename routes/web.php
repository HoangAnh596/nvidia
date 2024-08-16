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
use App\Http\Controllers\FilterCateController;
use App\Http\Controllers\FilterProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IconController;
use App\Http\Controllers\InforController;
use App\Http\Controllers\ManageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductImagesController;
use App\Http\Controllers\ProductTagController;
use App\Http\Controllers\ServiceController;
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
    Route::resource('categories', CategoryController::class)->middleware('authorization:Admin');
    Route::post('/categories/check-name', [CategoryController::class, 'checkName'])->name('categories.checkName');
    Route::post('/categories/checkbox', [CategoryController::class, 'isCheckbox'])->name('categories.isCheckbox');
    Route::post('/categories/checkStt', [CategoryController::class, 'checkStt'])->name('categories.checkStt');
    Route::get('/categories/slugs', [CategoryController::class, 'getSlugs'])->name('categories.getSlugs');

    // Quản lý Sản phẩm
    Route::get('/products', [ProductController::class, 'index'])->name('product.index')->middleware('authorization:Admin');
    Route::get('/products/create', [ProductController::class, 'create'])->name('product.create')->middleware('authorization:Admin');
    Route::post('/products', [ProductController::class, 'store'])->name('product.store')->middleware('authorization:Admin');
    Route::get('/products/{id}', [ProductController::class, 'show'])->name('product.show')->middleware('authorization:Admin');
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('product.edit')->middleware('authorization:Admin');
    Route::put('products/{id}', [ProductController::class, 'update'])->name('product.update')->middleware('authorization:Admin');
    Route::delete('products/{id}', [ProductController::class, 'destroy'])->name('product.destroy')->middleware('authorization:Admin');
    Route::post('/products/check-name', [ProductController::class, 'checkName'])->name('products.checkName');
    Route::post('/products/tim-kiem', [ProductController::class, 'search'])->name('products.tim-kiem');
    Route::post('/products/search-tags', [ProductController::class, 'searchTags'])->name('products.searchTags');
    Route::post('/products/checkbox', [ProductController::class, 'isCheckbox'])->name('products.isCheckbox');
    
    Route::resource('product-tags', ProductTagController::class)->only(['store'])->middleware('authorization:Admin');
    Route::post('/product-images/checkStt', [ProductImagesController::class, 'checkStt'])->name('product-images.checkStt');
    Route::delete('product-images/{id}', [ProductImagesController::class, 'destroy'])->name('product-images.destroy');
    Route::post('/product-images/checkImg', [ProductImagesController::class, 'isCheckImg'])->name('products.isCheckImg');

    // Quản lý bộ lọc danh mục
    Route::get('/filters', [FilterCateController::class, 'index'])->name('filter.index')->middleware('authorization:Admin');
    Route::get('/filters/create', [FilterCateController::class, 'create'])->name('filter.create')->middleware('authorization:Admin');
    Route::post('/filters', [FilterCateController::class, 'store'])->name('filter.store')->middleware('authorization:Admin');
    Route::get('/filters/{id}/edit', [FilterCateController::class, 'edit'])->name('filter.edit')->middleware('authorization:Admin');
    Route::put('filters/{id}', [FilterCateController::class, 'update'])->name('filter.update')->middleware('authorization:Admin');
    Route::post('/filters/check-name', [FilterCateController::class, 'checkName'])->name('filters.checkName');
    Route::post('/filters/checkbox', [FilterCateController::class, 'isCheckbox'])->name('filters.isCheckbox');
    Route::post('/filters/checkStt', [FilterCateController::class, 'checkStt'])->name('filters.checkStt');
    Route::delete('/filters/{id}', [FilterCateController::class, 'destroy'])->name('filters.destroy')->middleware('authorization:Admin');
    
    Route::post('/detailFilter/checkStt', [FilterCateController::class, 'sttDetail'])->name('detailFilter.checkStt')->middleware('authorization:Admin');
    // Quản lý bộ lọc của từng sản phẩm thuộc danh mục
    Route::get('/filter-pro/create', [FilterProductController::class, 'create'])->name('filterPro.create')->middleware('authorization:Admin');
    Route::post('/filter-pro', [FilterProductController::class, 'store'])->name('filterPro.store')->middleware('authorization:Admin');
    Route::get('/filter-pro/{id}/edit', [FilterProductController::class, 'edit'])->name('filterPro.edit')->middleware('authorization:Admin');
    Route::put('filter-pro/{id}', [FilterProductController::class, 'update'])->name('filterPro.update')->middleware('authorization:Admin');

    // Quản lý Tin tức
    Route::resource('news', NewController::class)->except(['show'])->middleware('authorization:Admin');
    Route::post('/news/check-name', [NewController::class, 'checkName'])->name('news.checkName');
    Route::post('/news/checkbox', [NewController::class, 'isCheckbox'])->name('news.isCheckbox');

    // Quản lý danh mục tin tức
    Route::resource('cateNews', CategoryNewController::class)->except(['show'])->middleware('authorization:Admin');
    Route::post('/cateNews/check-name', [CategoryNewController::class, 'checkName'])->name('cateNews.checkName');
    Route::post('/cateNews/tim-kiem', [CategoryNewController::class, 'search'])->name('cateNews.tim-kiem');
    Route::post('/cateNews/checkbox', [CategoryNewController::class, 'isCheckbox'])->name('cateNews.isCheckbox');
    Route::post('/cateNews/checkStt', [CategoryNewController::class, 'checkStt'])->name('cateNews.checkStt');

    // Quản lý tài khoản đăng nhập
    Route::resource('users', UserController::class)->except(['show'])->middleware('authorization:Admin');
    // Quản lý thông tin hotline nhân viên, icon, favicon
    Route::resource('infors', InforController::class)->except(['show'])->middleware('authorization:Admin');
    Route::post('/infors/checkStt', [InforController::class, 'checkStt'])->name('infors.checkStt');
    Route::post('/infors/checkbox', [InforController::class, 'isCheckbox'])->name('infors.isCheckbox');
    
    Route::resource('icons', IconController::class)->except(['show'])->middleware('authorization:Admin');
    Route::post('/icons/checkStt', [IconController::class, 'checkStt'])->name('icons.checkStt');
    Route::post('/icons/checkbox', [IconController::class, 'isCheckbox'])->name('icons.isCheckbox');

    Route::resource('favicon', ManageController::class)->only([
        'edit', 'update'
    ])->middleware('authorization:Admin');

    // Quản lý 
    Route::resource('bottoms', BottomController::class)->except(['show'])->middleware('authorization:Admin');
    Route::post('/bottoms/checkStt', [BottomController::class, 'checkStt'])->name('bottoms.checkStt');
    Route::post('/bottoms/checkbox', [BottomController::class, 'isCheckbox'])->name('bottoms.isCheckbox');
    

    // Quản lý danh mục menu
    Route::resource('cateMenu', CateMenuController::class)->except(['show'])->middleware('authorization:Admin');
    Route::post('cateMenu/checkStt', [CateMenuController::class, 'checkStt'])->name('cateMenu.checkStt');
    Route::post('cateMenu/checkbox', [CateMenuController::class, 'isCheckbox'])->name('cateMenu.isCheckbox');

    // Quản lý footer
    Route::resource('cateFooter', CateFooterController::class)->except(['show'])->middleware('authorization:Admin');
    Route::post('cateFooter/checkStt', [cateFooterController::class, 'checkStt'])->name('cateFooter.checkStt');
    Route::post('cateFooter/checkbox', [cateFooterController::class, 'isCheckbox'])->name('cateFooter.isCheckbox');

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