<?php

namespace App\Repositories;
use App\Models\Employee;



    interface EmployeeRepositoryInterface
{
    public function create(array $data);
    
    public function delete(Employee $employee);

    public function update(array $data, Employee $employee);

    public function all();

    public function findWithUser($id);
}
    

