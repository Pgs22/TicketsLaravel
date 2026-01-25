<?php

use App\Http\Controllers\TicketController;
use App\Http\Middleware\ValidateYear;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Route::get('/debug', function () {
    return response()->json([
        "os" => "win32",
        "arch" => "x64",
        "php_version" => "8.3.28",
        "laravel_version" => "10.33.0",
        "php_command" => "\"C:\\xampp\\php\\php.exe\""
    ]);
});

Route::prefix('tickets')->group(function () {
    Route::get('/', [TicketController::class, 'index'])
        ->middleware('validate.ticket.params');
    Route::get('/status/{status}', [TicketController::class, 'index'])
        ->middleware('validate.ticket.params');
    Route::get('/{id}', [TicketController::class, 'show'])
        ->where('id', '[0-9]+');
    Route::get('/create', function () {
        return view('tickets.create');
    });
    Route::post('/', [TicketController::class, 'store']);
    Route::get('/{id}/edit', [TicketController::class, 'edit'])
        ->where('id', '[0-9]+');
    Route::put('/{id}', [TicketController::class, 'update'])
        ->where('id', '[0-9]+');
    Route::delete('/{id}', [TicketController::class, 'delete'])
        ->where('id', '[0-9]+');

});
