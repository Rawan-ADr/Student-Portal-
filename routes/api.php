<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StudentController;

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

Route::post('login',[UserController::class,'login']);
Route::post('Login',[StudentController::class,'login']);

Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::get('logout', [UserController::class, 'logout']);
    Route::get('logout', [StudentController::class, 'logout']);

Route::prefix('document')->group(function () {
    Route::post('create',[DocumentController::class,'create']);
    Route::post('update/{document_id}',[DocumentController::class,'update']);
   // ->middleware('can:group.update');
    Route::get('delete/{document_id}',[DocumentController::class,'delete']);
   // ->middleware('can:group.delete');
   Route::post('create/field',[DocumentController::class,'createField']);
   // ->middleware('can:doc.create');
   Route::get('index/field/type',[DocumentController::class,'indexType']);
   Route::get('index/validation',[DocumentController::class,'indexValidation']);
   Route::get('delete/field/{field_id}',[DocumentController::class,'deleteField']);
   Route::post('update/field/{field_id}',[DocumentController::class,'updateField']);
   Route::get('index/field',[DocumentController::class,'indexField']);
   Route::post('create/attachment',[DocumentController::class,'createAttachment']);
   Route::get('index/attachment',[DocumentController::class,'indexAttachment']);
   Route::get('index/condition',[DocumentController::class,'indexCondition']);
   // Route::get('index',[GroupController::class,'index'])
   // ->middleware('can:group.index');

});

Route::prefix('student')->group(function () {
    Route::get('ShowAllDocuments',[DocumentController::class,'ShowAllDocuments']);
    Route::get('getStudent/{id}',[StudentController::class,'getStudent']);
    Route::get('getReceivedRequest/{id}',[StudentController::class,'getReceivedRequest']);
    Route::get('getRequest/{id}',[StudentController::class,'getRequest']);
    Route::get('getDocument/{id}',[StudentController::class,'getDocument']);
    



});
});


