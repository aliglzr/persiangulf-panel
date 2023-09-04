<?php

use App\Http\Controllers\Api\Application\V1\LoginController;
use App\Http\Controllers\Api\Application\V1\ServerController;
use App\Http\Controllers\Api\Application\V1\UsageController;
use Illuminate\Support\Facades\Route;

Route::name('api.app.v1.')->prefix('app/v1/')->group(function () {
    Route::any('/', function (\Illuminate\Http\Request $request) {
        return [
            'ok' => true,
            'data' => [
                'version' => '1.0.0',
                'maintenance' => \App\Models\Option::get('application_maintenance_mode') == 1,
                'maintenanceMessage' => \App\Models\Option::get('application_maintenance_message') ?? null,
                'currentVersion' => \App\Models\Option::get('android_application_current_version') ?? 0,
                'minimumVersion' => \App\Models\Option::get('android_application_minimum_version') ?? 0,
            ]
        ];
    });
    Route::post('login', [LoginController::class , 'login'])->name('login');
    Route::middleware('auth:sanctum')->group(function () {
        // Token verify function
        Route::post('verifyToken', [LoginController::class , 'verifyToken'])->name('verifyToken');
        Route::name('servers.')->prefix('servers/')->group(function () {
            Route::get('/', [ServerController::class , 'index'])->name('index');
            Route::get('/{server}', [ServerController::class , 'show'])->name('show');
        });
        Route::put('changePassword', [LoginController::class, 'changePassword'])->name('changePassword');
        Route::get('getUsageDetails',[UsageController::class,'getUsageDetails'])->name('getUsageDetails');
        require_once __DIR__ . '/v2ray.php';
    });
});

Route::name('api.sales.bot')->prefix('bot/sales')->group(function () {
   Route::any('/', [\App\Http\Controllers\Api\Bot\BotController::class, 'index']);
});
