<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SubcategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductImageController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/catalogo', [HomeController::class, 'catalogo'])->name('catalogo');
Route::get('/producto/{slug}', [HomeController::class, 'detalleProducto'])->name('producto.detalle');
Route::get('/como-comprar', [HomeController::class, 'comoComprar'])->name('como-comprar');
Route::get('/metodos-de-pago', [HomeController::class, 'metodosPago'])->name('metodos-pago');
Route::get('/contacto', [HomeController::class, 'contacto'])->name('contacto');

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('categories', CategoryController::class);
    Route::resource('subcategories', SubcategoryController::class);
    Route::resource('products', ProductController::class);
    Route::delete('products/images/{image}', [ProductImageController::class, 'destroy'])->name('products.images.destroy');
    Route::delete('products/{product}/main-image', [ProductController::class, 'destroyMainImage'])->name('products.main-image.destroy');
});

require __DIR__.'/auth.php';