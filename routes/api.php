<?php

use Dnwjn\NovaButton\Http\Controllers\ButtonController;
use Illuminate\Support\Facades\Route;

Route::post('/{resource}/{buttonKey}/{resourceId?}', [ButtonController::class, 'handle']);
