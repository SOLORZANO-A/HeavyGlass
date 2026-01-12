<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\IntakeSheetController;
use App\Http\Controllers\ProformaController;
use App\Http\Controllers\WorkOrderController;
use App\Http\Controllers\WorkTypeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PublicVehicleStatusController;
use App\Http\Controllers\IntakeInspectionController;
use App\Http\Controllers\IntakeInspectionItemController;
use App\Http\Controllers\IntakeInspectionPhotoController;
/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// Landing page
Route::get('/', function () {
    return view('landing');
})->name('landing');

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\IntakePhotoController;

// Login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/home', function () {
    return view('home');
})->middleware('auth')->name('dashboard');


Route::resource('intake_sheets', IntakeSheetController::class);

// 🔥 RUTA SEPARADA PARA FOTOS (MUY IMPORTANTE)

Route::delete('/intake-photos/{intakePhoto}', 
    [IntakePhotoController::class, 'destroy']
)->name('intake_photos.destroy');











// Login AdminLTE (ya existe en tu proyecto)
// /login

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard', [HomeController::class, 'index'])
        ->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | CLIENTES
    |--------------------------------------------------------------------------
    */
    Route::resource('clients', ClientController::class)
        ->middleware('permission:manage clients');

    /*
    |--------------------------------------------------------------------------
    | VEHÍCULOS
    |--------------------------------------------------------------------------
    */
    Route::resource('vehicles', VehicleController::class)
        ->middleware('permission:manage vehicles');

    /*
    |--------------------------------------------------------------------------
    | HOJAS DE INGRESO
    |--------------------------------------------------------------------------
    */
    Route::resource('intake_sheets', IntakeSheetController::class)
        ->middleware('permission:manage intake sheets');

    /*
    |--------------------------------------------------------------------------
    | ÓRDENES DE TRABAJO
    |--------------------------------------------------------------------------
    */
    Route::resource('work_orders', WorkOrderController::class)
        ->middleware('permission:manage work orders');

    /*
    |--------------------------------------------------------------------------
    | PROFORMAS
    |--------------------------------------------------------------------------
    */
    Route::resource('proformas', ProformaController::class)
        ->middleware('permission:manage proformas');

   Route::post('/proformas/{proforma}/sign', [ProformaController::class, 'sign'])
    ->name('proformas.sign')
    ->middleware('auth');


    /*
    |--------------------------------------------------------------------------
    | PAGOS
    |--------------------------------------------------------------------------
    */
    Route::resource('payments', PaymentController::class)
        ->middleware('permission:manage payments');

    Route::get('payments/{payment}/receipt', [PaymentController::class, 'receipt'])
        ->name('payments.receipt')
        ->middleware(['auth', 'permission:manage payments']);

    Route::patch(
        'payments/{payment}/cancel',
        [PaymentController::class, 'cancel']
    )->name('payments.cancel');

    Route::middleware(['role:admin'])->group(function () {
        Route::get('payments-history', [PaymentController::class, 'history'])
            ->name('payments.history');
    });



    /*
|--------------------------------------------------------------------------
| PERFILES (STAFF / TECHNICIANS)
|--------------------------------------------------------------------------
*/
    Route::resource('profiles', ProfileController::class)
        ->middleware('auth');


    /*
    |--------------------------------------------------------------------------
    | TIPOS DE TRABAJO
    |--------------------------------------------------------------------------
    */
    Route::resource('work_types', WorkTypeController::class)
        ->middleware('permission:manage work types');
});

Route::middleware(['auth'])->group(function () {

    Route::resource('payments', PaymentController::class);

    // 👉 Exportaciones (SOLO ADMIN)
    Route::get('payments-export/pdf', [PaymentController::class, 'exportPdf'])
        ->name('payments.export.pdf');

    // 👉 Cancelar pago
    Route::patch('payments/{payment}/cancel', [PaymentController::class, 'cancel'])
        ->name('payments.cancel');

    Route::get('payments/export/csv', [PaymentController::class, 'exportCsv'])
        ->name('payments.export.csv')
        ->middleware('permission:manage payments');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/reports/proformas', [ReportController::class, 'proformas'])
        ->name('reports.proformas');
});
Route::get('/reportes/proformas/pdf', [ReportController::class, 'proformasIngresosPdf'])
    ->name('reports.proformas.pdf')
    ->middleware(['auth', 'role:admin']);





/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS - CONSULTA DE VEHÍCULO
|--------------------------------------------------------------------------
*/

Route::get('/consulta-vehiculo', function () {
    return view('public.consult');
})->name('public.consult');

Route::get('/consulta-vehiculo/buscar', 
    [PublicVehicleStatusController::class, 'search']
)->name('public.search');



Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | INSPECCIÓN DE INGRESO DE VEHÍCULO
    |--------------------------------------------------------------------------
    */
    Route::get(
        'intake-sheets/{intakeSheet}/inspection',
        [IntakeInspectionController::class, 'create']
    )->name('intake_inspections.create');

    // Crear / obtener inspección (cabecera)
    Route::post(
        '/intake-inspections',
        [IntakeInspectionController::class, 'store']
    )->name('intake_inspections.store');

    // Actualizar inspección (observaciones / estado)
    Route::put(
        '/intake-inspections/{intakeInspection}',
        [IntakeInspectionController::class, 'update']
    )->name('intake_inspections.update');

    /*
    |--------------------------------------------------------------------------
    | CHECKLIST POR PIEZA
    |--------------------------------------------------------------------------
    */

    Route::post(
        '/intake-inspection-items',
        [IntakeInspectionItemController::class, 'store']
    )->name('intake_inspection_items.store');

    /*
    |--------------------------------------------------------------------------
    | FOTOS POR ZONA
    |--------------------------------------------------------------------------
    */

    Route::post(
        '/intake-inspection-photos',
        [IntakeInspectionPhotoController::class, 'store']
    )->name('intake_inspection_photos.store');

});
Route::get(
    '/work-orders/{workOrder}/inspection-data',
    [\App\Http\Controllers\ProformaController::class, 'inspectionData']
)->name('work_orders.inspection_data');



