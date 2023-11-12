<?php

use App\Http\Controllers\LogsController;
use Illuminate\Support\Facades\Route;

Route::any('/login', [LogsController::class, 'login']);
