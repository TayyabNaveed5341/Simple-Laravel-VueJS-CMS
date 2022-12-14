<?php

use App\Http\Controllers\PageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('/pages/')->group(function(){
    Route::post('', [PageController::class, 'store']);
    Route::get('', [PageController::class, 'index']);
    Route::get('{page:full_slug_path}', [PageController::class, 'show'])->name('page.show')->where('page', '.*');
    Route::put('{page:full_slug_path}', [PageController::class, 'update'])->where('page', '.*');
    Route::delete('{page:full_slug_path}', [PageController::class, 'destroy'])->where('page', '.*');
});
