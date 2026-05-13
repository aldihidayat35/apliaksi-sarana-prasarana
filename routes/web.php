<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AppSettingController;
use App\Http\Controllers\Admin\ItemController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\Admin\RegistrationController;
use App\Http\Controllers\Admin\BorrowingController;
use App\Http\Controllers\Admin\MonitoringController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\GuruController;

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Authenticated Routes (All roles)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard - accessible by all
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile - accessible by all authenticated users
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Reports - accessible by all
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/inventory', [ReportController::class, 'inventory'])->name('reports.inventory');
    Route::get('/reports/borrowing', [ReportController::class, 'borrowing'])->name('reports.borrowing');
    Route::get('/reports/damage', [ReportController::class, 'damage'])->name('reports.damage');
    Route::get('/reports/damage-location', [ReportController::class, 'damageLocation'])->name('reports.damage-location');
    Route::get('/reports/condition', [ReportController::class, 'condition'])->name('reports.condition');
    Route::get('/reports/priority', [ReportController::class, 'priority'])->name('reports.priority');
    Route::get('/reports/annual', [ReportController::class, 'annual'])->name('reports.annual');
    // PDF Downloads
    Route::get('/reports/inventory/pdf', [ReportController::class, 'inventoryPdf'])->name('reports.inventory.pdf');
    Route::get('/reports/inventory/excel', [ReportController::class, 'inventoryExcel'])->name('reports.inventory.excel');
    Route::get('/reports/borrowing/pdf', [ReportController::class, 'borrowingPdf'])->name('reports.borrowing.pdf');
    Route::get('/reports/borrowing/excel', [ReportController::class, 'borrowingExcel'])->name('reports.borrowing.excel');
    Route::get('/reports/damage/pdf', [ReportController::class, 'damagePdf'])->name('reports.damage.pdf');
    Route::get('/reports/damage/excel', [ReportController::class, 'damageExcel'])->name('reports.damage.excel');
    Route::get('/reports/damage-location/pdf', [ReportController::class, 'damageLocationPdf'])->name('reports.damage-location.pdf');
    Route::get('/reports/damage-location/excel', [ReportController::class, 'damageLocationExcel'])->name('reports.damage-location.excel');
    Route::get('/reports/condition/pdf', [ReportController::class, 'conditionPdf'])->name('reports.condition.pdf');
    Route::get('/reports/condition/excel', [ReportController::class, 'conditionExcel'])->name('reports.condition.excel');
    Route::get('/reports/annual/pdf', [ReportController::class, 'annualPdf'])->name('reports.annual.pdf');
    Route::get('/reports/annual/excel', [ReportController::class, 'annualExcel'])->name('reports.annual.excel');
});

/*
|--------------------------------------------------------------------------
| Admin & Guru Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin:admin,guru'])->prefix('admin')->name('admin.')->group(function () {
    // Borrowings
    Route::get('/borrowings', [BorrowingController::class, 'index'])->name('borrowings.index');
    Route::get('/borrowings/returns', [BorrowingController::class, 'returns'])->name('borrowings.returns');
    Route::get('/borrowings/create', [BorrowingController::class, 'create'])->name('borrowings.create');
    Route::post('/borrowings', [BorrowingController::class, 'store'])->name('borrowings.store');
    Route::get('/borrowings/{borrowing}', [BorrowingController::class, 'show'])->name('borrowings.show');
    Route::put('/borrowings/{borrowing}/return', [BorrowingController::class, 'returnItem'])->name('borrowings.return');
    Route::delete('/borrowings/{borrowing}', [BorrowingController::class, 'destroy'])->name('borrowings.destroy');
});

/*
|--------------------------------------------------------------------------
| Guru Routes (Inventaris Menu)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin:admin,guru'])->prefix('guru')->name('guru.')->group(function () {
    Route::get('/inventaris', [GuruController::class, 'inventaris'])->name('inventaris');
    Route::get('/inventaris/ready', [GuruController::class, 'ready'])->name('inventaris.ready');
    Route::get('/inventaris/dipinjam', [GuruController::class, 'sedangDipinjam'])->name('inventaris.dipinjam');
});

/*
|--------------------------------------------------------------------------
| Admin Only Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Inventory
    Route::get('/items/new', [ItemController::class, 'newItems'])->name('items.new');
    Route::resource('items', ItemController::class);

    // Registration / QR
    Route::get('/registrations', [RegistrationController::class, 'index'])->name('registrations.index');
    Route::get('/registrations/create', [RegistrationController::class, 'create'])->name('registrations.create');
    Route::post('/registrations', [RegistrationController::class, 'store'])->name('registrations.store');
    Route::get('/registrations/scan', [RegistrationController::class, 'scan'])->name('registrations.scan');
    Route::post('/registrations/scan-result', [RegistrationController::class, 'scanResult'])->name('registrations.scan-result');
    Route::get('/registrations/{registration}', [RegistrationController::class, 'show'])->name('registrations.show');
    Route::get('/registrations/{registration}/qr', [RegistrationController::class, 'generateQr'])->name('registrations.qr');
    Route::delete('/registrations/{registration}', [RegistrationController::class, 'destroy'])->name('registrations.destroy');

    // Monitoring
    Route::get('/monitoring', [MonitoringController::class, 'index'])->name('monitoring.index');
    Route::put('/monitoring/{item}/condition', [MonitoringController::class, 'updateCondition'])->name('monitoring.update-condition');
    Route::get('/monitoring/reports', [MonitoringController::class, 'reports'])->name('monitoring.reports');

    // User Management
    Route::resource('users', UserController::class)->except(['show']);

    // Categories & Locations (Settings)
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    Route::get('/locations', [LocationController::class, 'index'])->name('locations.index');
    Route::post('/locations', [LocationController::class, 'store'])->name('locations.store');
    Route::put('/locations/{location}', [LocationController::class, 'update'])->name('locations.update');
    Route::delete('/locations/{location}', [LocationController::class, 'destroy'])->name('locations.destroy');

    // App Settings
    Route::get('/settings', [AppSettingController::class, 'index'])->name('settings.index');
    Route::put('/settings', [AppSettingController::class, 'update'])->name('settings.update');
});
