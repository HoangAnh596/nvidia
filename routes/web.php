<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\NewController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CateFooterController;
use App\Http\Controllers\CategoryNewController;
use App\Http\Controllers\CateMenuController;
use App\Http\Controllers\FilterCateController;
use App\Http\Controllers\FilterProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MakerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductImagesController;
use App\Http\Controllers\ProductTagController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;

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
    Route::resource('categories', CategoryController::class);
    Route::post('/categories/check-name', [CategoryController::class, 'checkName'])->name('categories.checkName');
    Route::post('/categories/checkbox', [CategoryController::class, 'isCheckbox'])->name('categories.isCheckbox');
    Route::post('/categories/checkStt', [CategoryController::class, 'checkStt'])->name('categories.checkStt');

    // Quản lý Sản phẩm
    Route::get('/products', [ProductController::class, 'index'])->name('product.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('product.create');
    Route::post('/products', [ProductController::class, 'store'])->name('product.store');
    Route::get('/products/{id}', [ProductController::class, 'show'])->name('product.show');
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('product.edit');
    Route::put('products/{id}', [ProductController::class, 'update'])->name('product.update');
    Route::delete('products/{id}', [ProductController::class, 'destroy'])->name('product.destroy');
    Route::post('/products/check-name', [ProductController::class, 'checkName'])->name('products.checkName');
    Route::post('/products/tim-kiem', [ProductController::class, 'search'])->name('products.tim-kiem');
    Route::post('/products/search-tags', [ProductController::class, 'searchTags'])->name('products.searchTags');
    Route::post('/products/checkbox', [ProductController::class, 'isCheckbox'])->name('products.isCheckbox');
    
    Route::resource('product-tags', ProductTagController::class);
    Route::post('/product-images/checkStt', [ProductImagesController::class, 'checkStt'])->name('product-images.checkStt');
    Route::delete('product-images/{id}', [ProductImagesController::class, 'destroy'])->name('product-images.destroy');

    // Quản lý bộ lọc danh mục
    Route::get('/filters', [FilterCateController::class, 'index'])->name('filter.index');
    Route::get('/filters/create', [FilterCateController::class, 'create'])->name('filter.create');
    Route::post('/filters', [FilterCateController::class, 'store'])->name('filter.store');
    Route::get('/filters/{id}/edit', [FilterCateController::class, 'edit'])->name('filter.edit');
    Route::put('filters/{id}', [FilterCateController::class, 'update'])->name('filter.update');

    // Quản lý bộ lọc của từng sản phẩm thuộc danh mục
    Route::get('/filter-pro/create', [FilterProductController::class, 'create'])->name('filterPro.create');
    Route::post('/filter-pro', [FilterProductController::class, 'store'])->name('filterPro.store');
    Route::get('/filter-pro/{id}/edit', [FilterProductController::class, 'edit'])->name('filterPro.edit');
    Route::put('filter-pro/{id}', [FilterProductController::class, 'update'])->name('filterPro.update');

    // Quản lý Tin tức
    Route::resource('news', NewController::class)->middleware('authorization:Admin');
    Route::post('/news/check-name', [NewController::class, 'checkName'])->name('news.checkName');
    Route::post('/news/checkbox', [NewController::class, 'isCheckbox'])->name('news.isCheckbox');

    // Quản lý danh mục tin tức
    Route::resource('cateNews', CategoryNewController::class);
    Route::post('/cateNews/check-name', [CategoryNewController::class, 'checkName'])->name('cateNews.checkName');
    Route::post('/cateNews/tim-kiem', [CategoryNewController::class, 'search'])->name('cateNews.tim-kiem');
    Route::post('/cateNews/checkStt', [CategoryNewController::class, 'checkStt'])->name('cateNews.checkStt');

    // Quản lý tài khoản đăng nhập
    Route::resource('users', UserController::class)->middleware('authorization:Admin');

    // Quản lý danh mục menu
    Route::resource('cateMenu', CateMenuController::class);
    Route::post('cateMenu/checkStt', [CateMenuController::class, 'checkStt'])->name('cateMenu.checkStt');
    Route::post('cateMenu/checkbox', [CateMenuController::class, 'isCheckbox'])->name('cateMenu.isCheckbox');

    // Quản lý footer
    Route::resource('cateFooter', CateFooterController::class);
    Route::post('cateFooter/checkStt', [cateFooterController::class, 'checkStt'])->name('cateFooter.checkStt');
    Route::post('cateFooter/checkbox', [cateFooterController::class, 'isCheckbox'])->name('cateFooter.isCheckbox');

    Route::post('upload', [ContentController::class, 'upload'])->name('upload.image');

    Route::get('logout', [LoginController::class, 'logout'])->name('logoutUser');
});

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});

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
    Route::get('/dich-vu', [ServiceController::class, 'service'])->name('home.service');

    Route::get('/', [HomeController::class, 'index'])->name('home.index');
    Route::get('/{slug}', [HomeController::class, 'category'])
        ->name('home.category')->where('slug', '[a-zA-Z0-9-_]+');
    Route::get('/contact', [HomeController::class, 'contact'])->name('home.contact');
});
