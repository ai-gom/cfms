<?php
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\QRCodeController;
use Illuminate\Http\Request;
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

// Route::get('/form', [HomeController::class, 'showForm']);

Route::get('/form', [HomeController::class, 'showForm'])->name('home.form');


route::get('reports',[AdminController::class,'reports'])->middleware(['auth','admin']);

// Route::get('account', [AdminController::class, 'Account'])->middleware(['auth', 'admin'])->name('account');

Route::get('/account', [RegisteredUserController::class, 'create'])->name('Account');

Route::post('/register', [RegisteredUserController::class, 'store'])->name('register');
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register.create');

Route::get('rankings', [AdminController::class, 'rankings'])
    ->name('admin.rankings')
    ->middleware(['auth', 'admin']);

route::get('view_services',[AdminController::class,'view_services'])->middleware(['auth','admin']);

route::post('add_services',[AdminController::class,'add_services'])->middleware(['auth','admin']);

route::get('delete_services/{id}',[AdminController::class,'delete_services'])->middleware(['auth','admin']);

Route::put('update_services/{id}', [AdminController::class, 'update_services'])->name('update_services');

Route::post('submit_form', [HomeController::class, 'submit_form']);

route::get('reports_bi_quarterly',[AdminController::class,'reports_bi_quarterly'])->middleware(['auth','admin']);

route::get('reports_quarterly',[AdminController::class,'reports_quarterly'])->middleware(['auth','admin']);

Route::get('/print-report/{quarter}', [AdminController::class, 'printQuarterReport'])->name('print.report');

Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit')->middleware('auth');
Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update')->middleware('auth');

Route::get('/past_reports', [AdminController::class, 'pastReports'])->name('past.reports');

Route::get('dashboard', [UserController::class, 'dashboard'])->name('dashboard');



Route::get('/sorted-services', [AdminController::class, 'sortedServiceTable'])->name('admin.sorted_services');


Route::get('/thank-you', function () {
    return view('home.thank_you');
})->name('thank.you');


Route::get('/field-counts', [AdminController::class, 'showFieldCounts']);













