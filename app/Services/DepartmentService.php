<?php


namespace App\Services;


use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Repositories\DepartmentRepositoryInterface;


class DepartmentService
{
    
    private  $departmentRepository;
    

     public function __construct(DepartmentRepositoryInterface $departmentRepository ){
        $this->departmentRepository = $departmentRepository;

     }
     


    public function create($request){

        if ( Auth::user()->hasRole('admin')) {
        $department= $this->departmentRepository->create($request);

         $message="department created successfuly ";
    
            return ["department"=>$department,"message"=>$message];
    }
    
         $message="you can not create department ";
    
            return ["department"=>null,"message"=>$message];
    }

     public function update($department_id,$request){

        if ( Auth::user()->hasRole('admin')) {
        $department= $this->departmentRepository->update($request,$department_id);

         $message="department updated successfuly ";
    
            return ["department"=>$department,"message"=>$message];
    }
    
         $message="you can not update department ";
    
            return ["department"=>null,"message"=>$message];
    }

    public function delete($department_id){

            $department = $this->departmentRepository->find($department_id);
            
            if (is_null($department)) {
                return ["department" => null, "message" => "department not found."];
            }
        
            if ( Auth::user()->hasRole('admin')) {
              $department= $this->departmentRepository->delete( $department_id);

              return ["department" => $department, "message" => "department deleted"];
            }

            else{
                return ["department" => null, "message" => "you cant delete department"];

            }
        
           
        }

        public function index(){

        if ( Auth::user()->hasRole('admin')) {
        $department= $this->departmentRepository->all();

         $message="department indexed successfuly ";
    
            return ["department"=>$department,"message"=>$message];
    }
    
         $message="you can not index department ";
    
            return ["department"=>null,"message"=>$message];
    }


}