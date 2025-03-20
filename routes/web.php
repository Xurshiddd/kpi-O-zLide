<?php

use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CriterionController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ProfileController;
use App\Models\Department;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::middleware(['role:Admin'])->group(function () {
        Route::resources([
            'roles' => RoleController::class,
            'permissions' => PermissionController::class,
            'users' => UserController::class,
        ]);
    });
    Route::resources([
        'categories' => CategoryController::class,
        'departments' => DepartmentController::class,
        'documents' => DocumentController::class,
        'criterion' => CriterionController::class,
    ]);
    Route::get('profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/departments-by-category/{categoryId}', [DocumentController::class, 'getDepartmentsByCategory']);
    Route::get('/users-by-department/{departmentId}', [DocumentController::class, 'getUsersByDepartment']);
    Route::get('/departments-by-category/{category}', function ($category) {
        return Department::where('category_id', $category)->get();
    });
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');

});

require __DIR__.'/auth.php';
