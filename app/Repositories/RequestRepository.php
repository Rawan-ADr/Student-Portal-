<?php
namespace App\Repositories;
use App\Models\Request;
use App\Models\FlowStep;
use App\Models\Document_Workflow;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Services\Factories\RequestHandlerFactory;

class RequestRepository implements RequestRepositoryInterface
{

    private RequestHandlerFactory $RequestHandlerFactory;

    public function __construct(RequestHandlerFactory $RequestHandlerFactory){
       $this->RequestHandlerFactory = $RequestHandlerFactory;
    }
    public function getReceivedRequest($id){
        return Request::where('student_id', $id)->where('status', 'done')->get() ;

    }
    public function getRequests($id){
        return Request::where('student_id', $id)->where('status','!=', 'done')->get() ;

    }

    public function getModRequest($id){
        return Request::where('student_id', $id)->where('status', 'required modification')->get() ;

    }

    public function create($studentId,$document_id){

        $check = $this->checkDocumentConditions(
            $document_id,
            $studentId,
            now()
        );
        
        if (!$check['passed']) {
            return [ 'request'=>null,'message' => $check['message'], 'code'=> 422];
        }
        else
        {
            $workflow = Document_Workflow::where('document_id', $document_id)->first();
            $firstStep = FlowStep::where('workflow_id', $workflow->workflow_id)
            ->orderBy('step_order', 'asc')
            ->first();
            $request = Request::create([
                'date'=> Carbon::now(),
                'status'=>'under review',
                'point'=>$firstStep->id,
                'student_id'=>$studentId,
                'document_id'=>$document_id
            ]);

            $request->save();
            return [ 'request'=>$request,'message' => 'done', 'code'=> 200];
        }
        
    }

    

    public function getToUpdate($studentId,$request_id){
        $studentRequest=Request::where('student_id', $studentId)->where('id', $request_id)->first() ;
       if (!$studentRequest) {
        return null;
        }
        $studentRequest->update([
            'status' => 'under review',
            'modifications' =>null,
        ]);

        $studentRequest->save();

        return $studentRequest;

    }



    public function getRequest($id){
        $request=Request::find($id);
        if(!$request){
            return null; 
        }
        $Request = Request::with(['fieldValues.field', 'attachmentValues.attachment'])->find($id);


    
        if (!$Request) {
            return null;
        }

        return $Request;

    }

    public function getExamRequests(){

        $roleId = auth()->user()->roles->first()->id;

        $flowStepIds = FlowStep::where('role_id', $roleId )
        ->pluck('id')
        ->toArray();

        $requests = Request::whereIn('point', $flowStepIds)
        ->where('status', '!=', 'rejected')
        ->with(['document', 'student'])
        ->get();

        return $requests ;

    }


    public function getRequestData($id){

        $request = Request::where('id', $id)->with([
            'document.fields',
            'document.attachments',
            'fieldValues.field',
            'attachmentValues.attachment',
            'document.condition',
        ])->get();

        return $request ;
    }

    public function passingRequests($requestId){

        $studentRequest = Request::find($requestId);
        $currentStep = FlowStep::find($studentRequest->point);
        $nextStep = FlowStep::where('workflow_id', $currentStep->workflow_id)
        ->where('step_order', '>', $currentStep->step_order)
        ->orderBy('step_order', 'asc')
        ->first();

        if ($nextStep) {
           if($nextStep->is_final)
           {
            $studentRequest->update([
                'point' => "end",
                'status'=>"done"
            ]);
           }
           else
           {
            $studentRequest->update([
                'point' => $nextStep->id
                ]);
            }
            return $nextStep->step_name ;
        }
       return null;

    }

    public function confirmReview($id){
     $studentRequest = Request::find($id);
     if($studentRequest){
        $studentRequest->update([
            'status'=>"in process"
        ]);

            $handler =$this->RequestHandlerFactory->make($studentRequest->document);
            $result = $handler->handle($studentRequest);
                return $studentRequest;
     }
        return null;

    }

    public function rejecteRequest($id){
        $studentRequest = Request::find($id);
        if($studentRequest){
           $studentRequest->update([
               'status'=>"rejected"
           ]);
           return $studentRequest;
        }
           return null;
   
       }

    public function requestModification($request,$id){
        $studentRequest = Request::find($id);
        if($studentRequest){
           $studentRequest->update([
               'status'=>"required modification",
               'modifications'=>$request['modifications']
           ]);
           return $studentRequest;
        }
           return null;
   
    }
    



    public function checkDocumentConditions($documentId, $studentId, $requestDate = null) {
            $requestDate = $requestDate ?? Carbon::today();

            // جلب الشروط المرتبطة بالوثيقة
            $conditions = DB::table('document__conditions')
                ->join('conditions', 'document__conditions.condition_id', '=', 'conditions.id')
                ->where('document__conditions.document_id', $documentId)
                ->select('conditions.validation_query', 'conditions.variables', 'conditions.error_message')
                ->get();

            foreach ($conditions as $condition) {
                // تحويل المتغيرات من JSON إلى مصفوفة PHP
                $variables = json_decode($condition->variables, true);

                // جمع القيم المطلوبة لتنفيذ تعليمة SQL
                $values = [];
                foreach ($variables as $var) {
                    switch ($var) {
                        case 'student_id':
                            $values[] = $studentId;
                            break;

                        case 'document_id':
                            $values[] = $documentId;
                            break;

                        case 'year':
                            $values[] = $requestDate->year;
                            break;

                        case 'semester_id':
                            $values[] = $this->getSemesterIdFromDate($requestDate);
                            break;

                        case 'date':
                            $values[] = $requestDate->toDateString();
                            break;

                            case 'start_date|end_date':
                                $semester = DB::table('semesters')
                                ->whereDate('start_date', '<=', $requestDate)
                                ->whereDate('end_date', '>=', $requestDate)
                                ->first();
        
                                if (!$semester) {
                                    throw new \Exception('لا يوجد فصل دراسي مناسب لتاريخ الطلب.');
                                }
                
                                $values[] = $semester->start_date;
                                $values[] = $semester->end_date;
                                break;


                        default:
                            throw new \Exception("Unknown variable in condition: $var");
                    }
                }

                // تنفيذ الشرط
                $result = DB::selectOne($condition->validation_query, $values);

                if (isset($result->result) && $result->result > 0) {
                    return [
                        'passed' => false,
                        'message' => $condition->error_message
                    ];
                }
               
            }

            return ['passed' => true];
    }

}