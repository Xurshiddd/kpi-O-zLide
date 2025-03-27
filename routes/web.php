<?php

use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CriterionController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Models\Department;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});
Route::get('/admin/users/export', [DocumentController::class, 'exportUsersDocx'])->name('users.export.docx');

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
    Route::get('/users-by-department/{departmentId}', [DocumentController::class, 'getUsersByDepartment']);
    Route::get('/departments-by-category/{category}', function ($category) {
        return Department::where('category_id', $category)->get();
    });
    Route::get('documents-show/{user}', [DocumentController::class, 'show'])->name('user-documents.show');
    Route::post('/document-score', [DocumentController::class, 'score'])->name('document.score');
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::get('/departments/{id}/users', function ($id){
        $users = User::where('department_id', $id)->get(['id', 'first_name', 'last_name']);
        return response()->json($users);
    });
});

require __DIR__.'/auth.php';
