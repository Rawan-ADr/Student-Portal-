<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;

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
    Route::get('index/role', [UserController::class, 'indexRole']);
    Route::get('index/permission', [UserController::class, 'indexPermissions']);
    Route::post('assignPermissions/toRole', [UserController::class, 'assignPermissions']);
    Route::post('assignRole/toUser', [UserController::class, 'assignRole']);
   


Route::prefix('document')->group(function () {
    Route::post('create',[DocumentController::class,'create']);
    Route::post('update/{document_id}',[DocumentController::class,'update']);
    Route::get('delete/{document_id}',[DocumentController::class,'delete']);
   Route::post('create/field',[DocumentController::class,'createField']);
   Route::get('index/field/type',[DocumentController::class,'indexType']);
   Route::get('index/validation',[DocumentController::class,'indexValidation']);
   Route::get('delete/field/{field_id}',[DocumentController::class,'deleteField']);
   Route::post('update/field/{field_id}',[DocumentController::class,'updateField']);
   Route::get('index/field',[DocumentController::class,'indexField']);
   Route::get('index/fieldById/{field_id}',[DocumentController::class,'indexFieldById']);
   Route::post('create/attachment',[DocumentController::class,'createAttachment']);
   Route::get('index/attachment',[DocumentController::class,'indexAttachment']);
   Route::get('index/attachment/by/id/{attachment_id}',[DocumentController::class,'indexAttachmentById']);
   Route::post('update/attachment/{attachment_id}',[DocumentController::class,'updateAttachment']);
   Route::get('delete/attachment/{attachment_id}',[DocumentController::class,'deleteAttachment']);
   Route::get('index/condition',[DocumentController::class,'indexCondition']);
   Route::get('ShowAllDocuments',[DocumentController::class,'ShowAllDocuments']);
   Route::get('index/document/{document_id}',[DocumentController::class,'indexDocument']);
   Route::post('create/workflow',[DocumentController::class,'createWorkflow']);
   Route::post('update/workflow/{workflow_id}',[DocumentController::class,'updateWorkflow']);
   Route::get('ShowAllWorkflows',[DocumentController::class,'ShowAllWorkflows']);
   Route::get('index/Workflow/{workflow_id}',[DocumentController::class,'indexWorkflow']);
   Route::get('delete/Workflow/{workflow_id}',[DocumentController::class,'deleteWorkflow']);
   Route::post('assign/workflow/to/document',[DocumentController::class,'assignWorkflowToDocument']);
   // Route::get('index',[GroupController::class,'index'])
   // ->middleware('can:group.index');

});

Route::prefix('student')->group(function () {
    Route::get('ShowAllDocuments',[DocumentController::class,'ShowAllDocuments']);
    Route::get('getStudent/{id}',[StudentController::class,'getStudent']);
    Route::get('getReceivedRequest/{id}',[StudentController::class,'getReceivedRequest']);
    Route::get('getModRequest/{id}',[StudentController::class,'getModRequest']);
    Route::get('getRequests/{id}',[StudentController::class,'getRequests']);
    Route::get('getRequest/{id}',[StudentController::class,'getRequest']);
    Route::get('getDocument/{id}',[StudentController::class,'getDocument']);
    Route::post('sendRequest/{document_id}',[StudentController::class,'sendRequest']);
    Route::post('updateRequest/{request_id}',[StudentController::class,'updateRequest']);
    Route::post('getLecture',[StudentController::class,'getLecture']);
    Route::post('getCourse',[StudentController::class,'getCourse']);
    Route::get('getYears',[StudentController::class,'getYears']);
    Route::get('getSemester',[StudentController::class,'getSemester']);
    Route::post('addLecture',[StudentController::class,'addLecture']);
    Route::post('addAnnouncement',[StudentController::class,'addAnnouncement']);
    Route::get('getAnnouncement',[StudentController::class,'getAnnouncement']);
    Route::post('addStudent',[StudentController::class,'addStudent']);
    Route::post('addStudentRecord',[StudentController::class,'addStudentRecord']);
    Route::post('addNotes/{id}',[StudentController::class,'addNotes']);
    Route::post('addSchedule',[StudentController::class,'addSchedule']);
    Route::post('getSchedule',[StudentController::class,'getSchedule']);
    



});

Route::prefix('department')->group(function () {
    Route::post('create',[DepartmentController::class,'create']);
    Route::post('update/{department_id}',[DepartmentController::class,'update']);
    Route::get('delete/{department_id}',[DepartmentController::class,'delete']);
    Route::get('index',[DepartmentController::class,'index']);
});

Route::prefix('employee')->group(function () {
    Route::post('create',[EmployeeController::class,'create']);
    Route::post('update/{employee_id}',[EmployeeController::class,'update']);
    Route::get('delete/{employee_id}',[EmployeeController::class,'delete']);
    Route::get('index',[EmployeeController::class,'index']);
});
});


