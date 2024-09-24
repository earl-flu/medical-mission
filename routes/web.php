<?php

use App\Http\Controllers\BarangayController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DiagnosisController;
use App\Http\Controllers\EncounterController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\GuestPageController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ProfileController;
use App\Models\Barangay;
use App\Models\MedicalRecord;
use App\Models\OrderItem;
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
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('patients', PatientController::class)->except(['destroy']);

    Route::get('patients/{encounter}/order-items', [OrderItemController::class, 'create'])->name('order-items.create');
    Route::post('patients/{encounter}/order-items', [OrderItemController::class, 'store'])->name('order-items.store');

    Route::get('patients/{patient}/encounter/create', [EncounterController::class, 'create'])->name('encounter.create');
    Route::resource('encounter', EncounterController::class)->except('create');
  

    Route::get('/medical-records/{medicalRecord}/edit', [MedicalRecordController::class, 'edit'])->name('medical-records.edit');
    Route::put('/medical-records/{medicalRecord}/', [MedicalRecordController::class, 'update'])->name('medical-records.update');

    Route::get('/diagnoses/create', [DiagnosisController::class, 'create'])->name('diagnoses.create');
    Route::post('/diagnoses', [DiagnosisController::class, 'store'])->name('diagnoses.store');

    Route::get('/items/lowStock', [ItemController::class, 'lowStockIndex'])->name('items.lowstock');
    // Route::get('/items/createImport', [ItemController::class, 'createImport'])->name('items.createImport');
    Route::get('/items/import', [ItemController::class, 'import'])->name('items.import');
    Route::resource('items', ItemController::class)->except(['destroy']);

    Route::resource('orderItems', OrderItemController::class)->only(['update', 'destroy']);

    Route::get('api/barangays/{municipalityId}', [BarangayController::class, 'getBarangays'])->name('barangays');

    Route::get('orderItems/export/', [ExportController::class, 'exportOrderedItems']);
    Route::get('disposedItemsTotal/export/', [ExportController::class, 'exportDisposedItemsTotal']);
    Route::get('inventory/export/', [ExportController::class, 'exportInventory']);
});


require __DIR__ . '/auth.php';
