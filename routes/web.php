<?php

// use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Models\Stat;
use App\Models\Testimonial;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Home/Index', [
        'stats' => Stat::ordered()->get(['value', 'label', 'icon']),
        // First featured testimonial, only when the Testimonials module is on.
        // Null → the homepage keeps its hard-coded testimonial.
        'featuredTestimonial' => app('modules')->isActive('testimonials')
            ? Testimonial::where('featured', true)->ordered()->first(['author', 'role', 'headline', 'quote'])
            : null,
    ]);
})->name('home');

//  INTERNAL ROUTES
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::name('internal.')->prefix('internal')->middleware(['auth', 'verified', 'module:auth'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('Internal/Dashboard');
    })->name('dashboard');
    // Route::resource('media', \App\Http\Controllers\Internal\MediaController::class)->only(['index', 'store', 'update', 'destroy']);
    // Route::resource('menu-items', \App\Http\Controllers\Internal\MenuItemController::class);
    // Route::resource('competitions', \App\Http\Controllers\Internal\CompetitionController::class);
    // Route::prefix('competitions/{competition}')->name('competitions.')->group(function () {
    //     Route::delete('submissions/{submission}', [\App\Http\Controllers\Internal\CompetitionSubmissionController::class, 'destroy'])->name('submissions.destroy');
    //     Route::post('submissions/{submission}/winner', [\App\Http\Controllers\Internal\CompetitionSubmissionController::class, 'winner'])->name('submissions.winner');
    // });
    // Route::resource('pages', \App\Http\Controllers\Internal\PageController::class);
    // Route::resource('posts', \App\Http\Controllers\Internal\PostController::class);
    // Route::resource('activities', \App\Http\Controllers\Internal\ActivityController::class);
    // Route::resource('meetings', \App\Http\Controllers\Internal\MeetingController::class)->except(['show']);
    Route::get('page-views', [\App\Http\Controllers\Internal\PageViewController::class, 'index'])->name('page-views.index');
    // Route::get('field-changes', [\App\Http\Controllers\Internal\FieldChangeController::class, 'index'])->name('field-changes.index');

    // Module info page — viewable for inactive modules too (not module-gated).
    Route::get('modules/{key}', [\App\Http\Controllers\Internal\ModuleController::class, 'show'])->name('modules.show');

    // Stats management — gated by the Stats module.
    Route::middleware('module:stats')->group(function () {
        Route::resource('stats', \App\Http\Controllers\Internal\StatController::class)->except('show');
    });

    // Testimonials management — gated by the Testimonials module.
    Route::middleware('module:testimonials')->group(function () {
        Route::resource('testimonials', \App\Http\Controllers\Internal\TestimonialController::class)->except('show');
    });
});

//  ADMIN ROUTES
Route::middleware(['auth', 'verified', 'admin'])->name('admin.')->prefix('admin')->group(function () {
    Route::get('/', [\App\Http\Controllers\Admin\AdminController::class, 'dashboard'])->name('dashboard');

    Route::get('modules', [\App\Http\Controllers\Admin\ModuleController::class, 'index'])->name('modules.index');
    Route::put('modules/{key}', [\App\Http\Controllers\Admin\ModuleController::class, 'update'])->name('modules.update');

    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    Route::get('users/{user}/roles', [\App\Http\Controllers\Admin\UserRoleController::class, 'index'])->name('user_roles.index');
    Route::put('users/{user}/roles', [\App\Http\Controllers\Admin\UserRoleController::class, 'update'])->name('user_roles.update');

    Route::resource('roles', \App\Http\Controllers\Admin\RoleController::class);
    Route::get('roles/{role}/rights', [\App\Http\Controllers\Admin\RoleRightController::class, 'index'])->name('role_rights.index');
    Route::post('roles/{role}/rights', [\App\Http\Controllers\Admin\RoleRightController::class, 'store'])->name('role_rights.store');
    Route::put('roles/{role}/rights', [\App\Http\Controllers\Admin\RoleRightController::class, 'update'])->name('role_rights.update');
});




require __DIR__ . '/auth.php';

// Route::get('/{path?}', [PageController::class, 'show'])
//     ->where('path', '.*')
//     ->name('page.show');

