<?php

use Illuminate\Support\Facades\Route;
use Dnwjn\NovaButton\Http\Controllers\ButtonController;

Route::post('/{resource}/{resourceId}/{buttonKey}', [ButtonController::class, 'handle']);
