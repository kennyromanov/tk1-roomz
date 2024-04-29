<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebController;

Route::get('/', [WebController::class, 'home']);

Route::get('/estate/{estateID}', [WebController::class, 'home']);
