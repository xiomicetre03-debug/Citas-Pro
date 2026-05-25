<?php

use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Route;

Route::get('/especialistas', [ApiController::class, 'especialistas']);
Route::get('/citas', [ApiController::class, 'citas']);