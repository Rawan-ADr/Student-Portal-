<?php


namespace App\Services;


use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Repositories\EmployeeRepositoryInterface;



class EmployeeService
{
    
    private  $empolyeeRepository;
    

     public function __construct(EmployeeRepositoryInterface $empolyeeRepository ){
        $this->empolyeeRepository = $empolyeeRepository;

     }
     


    public function create($request){

        if ( Auth::user()->hasRole('admin')) {
        $employee= $this->empolyeeRepository->create($request);

         $message="employee created successfuly ";
    
            return ["employee"=>$employee,"message"=>$message];
    }
    
         $message="you can not create department ";
    
            return ["employee"=>null,"message"=>$message];
    }

     public function update( $request, $employee_id){

        if ( Auth::user()->hasRole('admin')) {

         $employee = $this->empolyeeRepository->findWithUser($employee_id);
         if(is_null($employee)){

            $message="employee not found ";
            return ["employee"=>null,"message"=>$message];

         }
        $employee= $this->empolyeeRepository->update($request,$employee);

         $message="employee updated successfuly ";
    
            return ["employee"=>$employee,"message"=>$message];
    }
    
         $message="you can not update employee ";
    
            return ["employee"=>null,"message"=>$message];
    }

   public function delete($employee_id){

      if ( Auth::user()->hasRole('admin')) {
         $employee = $this->empolyeeRepository->findWithUser($employee_id);

         if(is_null($employee)){
            $message="employee not found ";
            return ["employee"=>null,"message"=>$message];

         }
        $employee= $this->empolyeeRepository->delete($employee);

         $message="employee deleted successfuly ";
    
            return ["employee"=>null,"message"=>$message];
    }
    
         $message="you can not delete employee ";
    
            return ["employee"=>null,"message"=>$message];
   }

        public function index(){

        if ( Auth::user()->hasRole('admin')) {
        $employee= $this->empolyeeRepository->all();

         $message="employees indexed successfuly ";
    
            return ["employee"=>$employee,"message"=>$message];
    }
    
         $message="you can not index employees ";
    
            return ["employee"=>null,"message"=>$message];
    }


}