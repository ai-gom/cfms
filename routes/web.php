<?php
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Middleware\Admin;

route::get('/',[HomeController::class,'home']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

route::get('admin/dashboard',[AdminController::class,'index'])->middleware(['auth','admin']);

Route::get('/form', [HomeController::class, 'showForm']);

route::get('reports',[AdminController::class,'reports'])->middleware(['auth','admin']);

Route::get('account', [AdminController::class, 'Account'])->middleware(['auth', 'admin'])->name('account');

Route::post('/register', [RegisteredUserController::class, 'store'])->name('register');

route::get('rankings',[AdminController::class,'rankings'])->middleware(['auth','admin']);

route::get('view_services',[AdminController::class,'view_services'])->middleware(['auth','admin']);

route::post('add_services',[AdminController::class,'add_services'])->middleware(['auth','admin']);

route::get('delete_services/{id}',[AdminController::class,'delete_services'])->middleware(['auth','admin']);

Route::post('submit_form', [HomeController::class, 'submit_form']);

route::get('reports_bi_quarterly',[AdminController::class,'reports_bi_quarterly'])->middleware(['auth','admin']);
