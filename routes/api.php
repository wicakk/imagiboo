<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageGeneratorController;

Route::post('/generate-image', [ImageGeneratorController::class, 'generate']);
