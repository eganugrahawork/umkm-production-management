<?php

use App\Http\Controllers\Admin\Dashboard\DashboardController;
use App\Http\Controllers\Admin\Configuration\MenuAccessController;
use App\Http\Controllers\Admin\Configuration\MenuController;
use App\Http\Controllers\Admin\Configuration\RoleController;
use App\Http\Controllers\Admin\Masterdata\Item\ItemController;
use App\Http\Controllers\Admin\Masterdata\Partner\PartnerController;
use App\Http\Controllers\Admin\Masterdata\Partner\TypePartnerController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->get('/settings', function () {
    return view('admin.settings.index');
});




Route::middleware('auth')->controller(DashboardController::class)->group(function () {
    Route::get('/admin/dashboard', 'index');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::middleware('auth')->controller(MenuController::class)->group(function () {
    Route::get('/admin/menu/index', 'index');
    Route::get('/admin/menu/list', 'list');
    Route::get('/admin/menu/create', 'create');
    Route::get('/admin/menu/edit/{id}', 'edit');
    Route::post('/admin/menu/store', 'store');
    Route::post('/admin/menu/update', 'update');
    Route::get('/admin/menu/delete/{id}', 'destroy');
    Route::get('/admin/menu/loadmenu/{parent}/{role_id}', 'loadmenu');
    Route::get('/admin/darkmode', 'darkmode');
});

Route::middleware('auth')->controller(RoleController::class)->group(function () {
    Route::get('/admin/role/index', 'index');
    Route::get('/admin/role/list', 'list');
    Route::get('/admin/role/create', 'create');
    Route::get('/admin/role/edit/{id}', 'edit');
    Route::post('/admin/role/store', 'store');
    Route::post('/admin/role/update', 'update');
    Route::get('/admin/role/delete/{id}', 'destroy');
});

Route::middleware('auth')->controller(MenuAccessController::class)->group(function () {
    Route::get('/admin/menuaccess/index', 'index');
    Route::get('/admin/menuaccess/list', 'list');
    Route::get('/admin/menuaccess/access/{id}', 'access');
    Route::get('/admin/menuaccess/listaccess/{id}', 'listaccess');
    Route::post('/admin/menuaccess/changeaccess', 'changeaccess');
    Route::get('/admin/menuaccess/permission/{id}', 'permission');
    Route::get('/admin/menuaccess/listpermission/{id}', 'listpermission');
    Route::post('/admin/menuaccess/changepermission', 'changepermission');
});

Route::middleware('auth')->controller(PartnerController::class)->group(function () {
    Route::get('admin/masterdata/partner', 'index');
    Route::get('admin/masterdata/partner/list', 'list');
    Route::get('admin/masterdata/partner/info', 'info');
    Route::get('admin/masterdata/partner/create', 'create');
    Route::post('admin/masterdata/partner/store', 'store');
    Route::post('admin/masterdata/partner/update', 'update');
    Route::get('admin/masterdata/partner/edit/{id}', 'edit');
    Route::get('admin/masterdata/partner/delete/{id}', 'delete');
    Route::get('admin/masterdata/partner/getcode/{id}', 'getcode');
});

Route::middleware('auth')->controller(TypePartnerController::class)->group(function () {
    Route::get('admin/masterdata/partner/typepartner', 'index');
    Route::get('admin/masterdata/partner/typepartner/list', 'list');
    Route::get('admin/masterdata/partner/typepartner/create', 'create');
    Route::post('admin/masterdata/partner/typepartner/store', 'store');
    Route::post('admin/masterdata/partner/typepartner/update', 'update');
    Route::get('admin/masterdata/partner/typepartner/edit/{id}', 'edit');
    Route::get('admin/masterdata/partner/typepartner/delete/{id}', 'delete');
});

Route::middleware('auth')->controller(ItemController::class)->group(function () {
    Route::get('admin/masterdata/item', 'index');
    Route::get('admin/masterdata/item/list', 'list');
    Route::get('admin/masterdata/item/create', 'create');
    Route::post('admin/masterdata/item/store', 'store');
    Route::post('admin/masterdata/item/update', 'update');
    Route::get('admin/masterdata/item/edit/{id}', 'edit');
    Route::get('admin/masterdata/item/delete/{id}', 'delete');
});

