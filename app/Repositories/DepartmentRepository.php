<?php
namespace App\Repositories;
use App\Models\Department;

class DepartmentRepository implements DepartmentRepositoryInterface
{


    public function create(array $data)
    {
        return Department::create($data);

    }


    public function update(array $data, $id)
    {
        $department = Department::find($id);
        $department->update([
           'name' => $data['name'],
           
        ]);

        return $department;
      }   
        
    

    public function delete($id)
    {
        $department = Department::find($id);
        if ($department) {
            $department->delete();
            return true;
        }
        return false;
    }

     public function all()
    {
        return Department::all();
    }

    public function find($id)
    {
        return Department::find($id);
    }

    

    
}