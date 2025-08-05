<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ExaminationController;
use App\Http\Controllers\AffairsController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\ReportController;
use App\Models\Request as DocumentRequest;
use Illuminate\Http\Request as HttpRequest;

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

Route::get('/payment/success', function () {
    return response()->json(['message' => 'Thank you! Payment successful.']);
});

Route::get('/payment/cancel', function () {
    return response()->json(['message' => 'Payment cancelled.']);
});

Route::post('/payment/confirm', [PaymentController::class, 'confirm']);


Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::get('logout', [UserController::class, 'logout']);
    Route::get('logout', [StudentController::class, 'logout']);
    Route::get('index/role', [UserController::class, 'indexRole']);
    Route::get('index/permission', [UserController::class, 'indexPermissions']);
    Route::post('assignPermissions/toRole', [UserController::class, 'assignPermissions']);
    Route::post('assignRole/toUser', [UserController::class, 'assignRole']);
    Route::get('index/users', [UserController::class, 'indexUsers']);
    Route::get('index/user/by/token', [UserController::class, 'indexUserByToken']);
   
Route::prefix('admin')->group(function () {
    Route::get('show/logs',[RequestController::class,'indexLogs']); 
    Route::get('reports/top-employees', [ReportController::class, 'topEmployeesByActions']);
    Route::get('reports/request-count-documents', [ReportController::class, 'requestCountPerDocument']);
    Route::get('reports/processing-time', [ReportController::class, 'averageProcessingTimePerDocument']);
    Route::get('reports/status-count', [ReportController::class, 'requestCountByStatus']);
    
});

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
   Route::get('index/Workflow/{document_id}',[DocumentController::class,'indexWorkflow']);
   Route::get('delete/Workflow/{workflow_id}',[DocumentController::class,'deleteWorkflow']);
   Route::post('assign/workflow/to/document',[DocumentController::class,'assignWorkflowToDocument']);

});

Route::prefix('student')->group(function () {
    Route::get('ShowDocuments',[DocumentController::class,'ShowDocuments']);
    Route::get('getStudent/{id}',[StudentController::class,'getStudent']);
    Route::get('getAllStudent',[StudentController::class,'getAllStudent']);
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
    Route::get('getAnnouncement',[StudentController::class,'getAnnouncement']);
    Route::post('getSchedule',[StudentController::class,'getSchedule']);
    Route::get('getStudentCourses',[ExaminationController::class,'getStudentCourses']);
    Route::get('getStudentMark/{id}',[ExaminationController::class,'getStudentMark']);
    
    

});

Route::prefix('exam')->group(function () {
    Route::post('importMarks',[ExaminationController::class,'importMarks'])
    ->middleware('permission:import marks');
    Route::get('getRequests',[ExaminationController::class,'getExamRequests'])
    ->middleware('permission:view requests');
    Route::get('passingRequests/{id}',[ExaminationController::class,'passingRequests'])
    ->middleware('permission:approve requests');
    Route::get('getRequestData/{id}',[ExaminationController::class,'getRequestData'])
    ->middleware('permission:view requests data');
});


Route::prefix('else')->group(function () {
    Route::post('addSchedule',[StudentController::class,'addSchedule']); 
    Route::post('addLecture',[StudentController::class,'addLecture']);
    Route::post('addAnnouncement',[StudentController::class,'addAnnouncement'])
     ->middleware('permission:add announcement');
    Route::post('updateAnnouncement/{id}',[StudentController::class,'updateAnnouncement'])
     ->middleware('permission:update announcement');
    Route::get('deleteAnnouncement/{id}',[StudentController::class,'deleteAnnouncement'])
     ->middleware('permission:delete announcement');
});
Route::prefix('prof')->group(function () {
    Route::post('add/result/practical/exam/objection',[RequestController::class,'updatePracticalMark']); 
    
});
Route::prefix('request')->group(function () {
    Route::get('indexContent/{request_id}',[RequestController::class,'indexContent']); 
    
});

Route::prefix('committee')->group(function () {
    Route::post('add/result/theoretical/exam/objection',[RequestController::class,'updateTheoreticalMark']); 
    
});

Route::prefix('Affairs')->group(function () {
    Route::post('addStudent',[AffairsController::class,'addStudent'])
    ->middleware('permission:add student');
    Route::post('addStudentRecord',[AffairsController::class,'addStudentRecord'])
    ->middleware('permission:add student record');
    Route::post('addNotes/{id}',[AffairsController::class,'addNotes'])
    ->middleware('permission:add notes');
    Route::get('indexNotes',[AffairsController::class,'indexNotes'])
    ->middleware('permission:index notes');
    Route::get('getStudentRecords/{id}',[AffairsController::class,'getStudentRecords'])
    ->middleware('permission:get student records');
    Route::get('indexStudentRecords',[AffairsController::class,'indexStudentRecords'])
    ->middleware('permission:index all records');
    Route::get('getStudent/{id}',[StudentController::class,'getStudent'])
    ->middleware('permission:get student');

});

Route::prefix('Review')->group(function () {
    Route::get('confirmReview/{id}',[ReviewController::class,'confirmReview'])
    ->middleware('permission:confirm review');
    Route::get('rejecteRequest/{id}',[ReviewController::class,'rejecteRequest'])
    ->middleware('permission:reject requests');
    Route::post('requestModification/{id}',[ReviewController::class,'requestModification'])
    ->middleware('permission:request modification');

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


