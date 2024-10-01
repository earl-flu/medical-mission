<?php

use App\Http\Controllers\BarangayController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DiagnosisController;
use App\Http\Controllers\EncounterController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\GuestPageController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});
Route::get('/view/items', [GuestPageController::class, 'viewItems'])->name('view.items');
// Route::get('/view/low-stock-items', [GuestPageController::class, 'viewLowStockItems'])->name('view.lowStockItems');

//ADD GROUP FOR AUTH MIDDLEWARE


Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profile routes
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
    });

    // Patient routes
    Route::resource('patients', PatientController::class)->except(['destroy']);
    Route::controller(EncounterController::class)->group(function () {
        Route::get('patients/{patient}/encounter/create', 'create')->name('encounter.create');
        Route::resource('encounter', EncounterController::class)->except('create');
    });

    // Order item routes
    Route::controller(OrderItemController::class)->group(function () {
        Route::get('patients/{encounter}/order-items', 'create')->name('order-items.create');
        Route::post('patients/{encounter}/order-items', 'store')->name('order-items.store');
        Route::resource('/orderItems', OrderItemController::class)->only(['update', 'destroy']);
    });

    // Diagnosis routes
    Route::controller(DiagnosisController::class)->group(function () {
        Route::get('/diagnoses/create', 'create')->name('diagnoses.create');
        Route::post('/diagnoses', 'store')->name('diagnoses.store');
    });

    // Item routes
    Route::controller(ItemController::class)->group(function () {
        Route::get('/items/lowStock', 'lowStockIndex')->name('items.lowstock');
        Route::get('/items/import', 'import')->name('items.import');
        Route::resource('items', ItemController::class)->except(['destroy']);
    });

    // API routes
    Route::prefix('api')->group(function () {
        Route::get('/barangays/{municipalityId}', [BarangayController::class, 'getBarangays'])->name('barangays');
        Route::controller(DashboardController::class)->group(function () {
            Route::get('/statistics/{eventId}', 'getStatistics')->name('event.statistics');
            Route::get('/dispensedMeds/{eventId}', 'getDispensedMedsData')->name('event.dispensedMeds');
            Route::get('/encounterServiceData/{eventId}', 'getEncounterServiceData')->name('event.encounterServiceData');
            Route::get('/municipalityData/{eventId}', 'getMunicipalityData')->name('event.municipalityData');
            Route::get('/barangayData/{eventId}/{municipalityName}', 'getBarangayData')->name('event.barangayData');
            Route::get('/availableStocks', 'getAvailableStocks')->name('availableStocks');
            Route::get('/encountersByProgram/{eventId}', 'getEncountersByProgram')->name('event.encountersByProgram');
        });
    });

    // Export routes
    Route::controller(ExportController::class)->group(function () {
        Route::get('/orderItems/export', 'exportOrderedItems');
        Route::get('/disposedItemsTotal/export', 'exportDisposedItemsTotal');
        Route::get('/inventory/export', 'exportInventory');
    });
});


require __DIR__ . '/auth.php';
