<?php

use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\RegistrationController;
use Illuminate\Support\Facades\Route;

Route::post('/registration', [RegistrationController::class, 'store']);
Route::get('/profile', [ProfileController::class, 'show']);