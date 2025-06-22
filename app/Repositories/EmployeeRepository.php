<?php
namespace App\Repositories;
use App\Models\Employee;
use App\Models\User;
use App\Models\Professor;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class EmployeeRepository implements EmployeeRepositoryInterface
{


    public function create(array $data)
    {
            
            $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        
        $employee= Employee::create([
            'user_id' => $user->id,
            'phone' => $data['phone'],
            'dateCreatedAt' => Carbon::now(),
            'department_id' => $data['department_id'],
        ]);

        if ($data['type'] === 'practical') {
             Professor::create([
              'employee_id' => $employee->id,
              'is_practical' => $data['is_practical'] ??false ,
            ]);
         }
         return $employee;
    }

    


    public function update(array $data, Employee $employee)
    {
         $user = $employee->user;

    if (isset($data['name'])) {
        $user->name = $data['name'];
    }
    if (isset($data['email'])) {
        $user->email = $data['email'];
    }
    if (!empty($data['password'])) {
        $user->password = Hash::make($data['password']);
    }

    $user->save();

    if (isset($data['phone'])) {
        $employee->phone = $data['phone'];
    }
    if (isset($data['department_id'])) {
        $employee->department_id = $data['department_id'];
    }

    $employee->save();

    if (isset($data['type'])) {
        if ($data['type'] === 'practical') {
            Professor::updateOrCreate(
                ['employee_id' => $employee->id],
                ['is_practical' => $data['is_practical'] ?? false]
            );
        } else {
          
            Professor::where('employee_id', $employee->id)->delete();
        }
    }

    return $employee;
        
      }   
        
    

    public function delete(Employee $employee)
    {
       if ($employee->user) {
        $employee->user->delete();
    }

     $employee->delete();
    }

     public function all()
    {
       $employees = Employee::with(['user', 'professor'])->get()->map(function ($employee) {
    return [
        'name' => $employee->user->name,
        'email' => $employee->user->email,
        'phone' => $employee->phone,
        'department_id' => $employee->department_id,
        'is_practical' => optional($employee->professor)->is_practical, 
    ];
});
     return $employees;
    }

    public function findWithUser($id)
    {
        return Employee::with('user')->findOrFail($id);
    }

    

    
}