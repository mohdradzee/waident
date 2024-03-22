<?php

use Mohdradzee\Waident\Controllers;
use Illuminate\Support\Facades\Route;
use Mohdradzee\Waident\Controllers\AuthController;
use Mohdradzee\Waident\Controllers\WaidentController;

Route::get('inspire', WaidentController::class);
Route::get('idauthenticate', AuthController::class.'@authenticate')->middleware(['web']);
Route::get('demo-initiateauth', AuthController::class.'@demoInitAuth');
Route::get('/ajax/check-username', AuthController::class.'@checkPlayerUsername')->middleware(['web'])->name('players.ajax.check-username');