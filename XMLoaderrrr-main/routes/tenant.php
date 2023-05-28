<?php

 

declare(strict_types=1);

 

use Illuminate\Support\Facades\Route;

use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;

use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

 

use Illuminate\Foundation\Application;

use Inertia\Inertia;
use App\Http\Controllers\AltatenatController;
use App\Http\Controllers\FacturaController;
use App\Http\Controllers\DescargaController;
use App\Http\Controllers\LogincfdiController;
use App\Http\Controllers\SolicitarcfdiController;
use App\Http\Controllers\VerificarcfdiController;
use App\Http\Controllers\DescargarcfdiController;
use App\Http\Controllers\ComplementocfdiController;

/*

|--------------------------------------------------------------------------

| Tenant Routes

|--------------------------------------------------------------------------

|

| Here you can register the tenant routes for your application.

| These routes are loaded by the TenantRouteServiceProvider.

|

| Feel free to customize them however you want. Good luck!

|

*/

 

Route::group(['prefix' => config('sanctum.prefix', 'sanctum')], static function () {

    Route::get('/csrf-cookie',[\Laravel\Sanctum\Http\Controllers\CsrfCookieController::class, 'show'])

        // Use tenancy initialization middleware of your choice

        ->middleware(['universal', 'web', \Stancl\Tenancy\Middleware\InitializeTenancyByDomain::class])

        ->name('sanctum.csrf-cookie');

});

 

Route::middleware([

    'web',

    //InitializeTenancyByDomain::class,

    //PreventAccessFromCentralDomains::class,

])->group(function () {

 

    Route::get('/', function () {

        return Inertia::render('Welcome', [

            'canLogin' => Route::has('login'),

            'canRegister' => Route::has('register'),

            'laravelVersion' => Application::VERSION,

            'phpVersion' => PHP_VERSION,

        ]);

    });

    //Secciones de navlink

    Route::middleware(['auth:sanctum', 'verified'])->get('/iniciodescarga', function () {
        return Inertia::render('InicioDescargaMasiva');
    })->name('iniciodescarga');

    Route::middleware(['auth:sanctum', 'verified'])->get('/inicioreportes', function () {
        return Inertia::render('InicioReportes');
    })->name('inicioreportes');

    Route::middleware(['auth:sanctum', 'verified'])->get('/inicioconfig', function () {
        return Inertia::render('InicioConfig');
    })->name('inicioconfig');

    Route::middleware(['auth:sanctum', 'verified'])->get('/iniciogenerarfactura', function () {
        return Inertia::render('InicioGenerarFactura');
    })->name('iniciogenerarfactura');

    Route::post('/agregartenant', [AltatenatController::class, 'altaTenant'])->middleware((['auth:sanctum', 'verified']));
 
    Route::post('/generarfactura', [FacturaController::class, 'generarFactura'])->middleware((['auth:sanctum', 'verified']));

    Route::post('/descargafactura', [DescargaController::class, 'manejarDescarga'])->middleware((['auth:sanctum', 'verified']));

    Route::post('/logincfdi', [LogincfdiController::class, 'soapRequest'])->middleware((['auth:sanctum', 'verified']));

    Route::post('/solicitarcfdi', [SolicitarcfdiController::class, 'soapRequest'])->middleware((['auth:sanctum', 'verified']));

    Route::post('/verificarcfdi', [VerificarcfdiController::class, 'soapRequest'])->middleware((['auth:sanctum', 'verified']));

    Route::post('/descargarcfdi', [DescargarcfdiController::class, 'soapRequest'])->middleware((['auth:sanctum', 'verified']));

    Route::post('/complementocfdi', [ComplementocfdiController::class, 'saveBase64File'])->middleware((['auth:sanctum', 'verified']));
    //Route::get('/', function () {

    //    config(['database.default' => 'tenant'.tenant('id')]);

    //    return 'This is your multi-tenant application. The id of the current tenant is ' . tenant('id');

    //});

 

    Route::middleware([

        'auth:sanctum',

        config('jetstream.auth_session'),

        'verified',

    ])->group(function () {

        Route::get('/dashboard', function () {

            return Inertia::render('Dashboard');

        })->name('dashboard');

 

    });

});