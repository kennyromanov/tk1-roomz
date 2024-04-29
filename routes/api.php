<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

Route::get('/v1/estates', [ApiController::class, 'getEstates']);
