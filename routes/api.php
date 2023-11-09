<?php

use App\Http\Controllers\DocumentsController;
use App\Http\Controllers\ProcessController;
use App\Http\Controllers\TypeDocumentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();

});
Route::apiResource('/documents', DocumentsController::class);
Route::apiResource('/type_documents', TypeDocumentController::class);
Route::apiResource('/process', ProcessController::class);
Route::get('/getDataDocument/{id}', [DocumentsController::class, 'getDataDocument']);