<?php

namespace App\Repositories;



    interface DepartmentRepositoryInterface
{
    public function create(array $data);
    
    public function delete($id);

    public function update(array $data, $id);

    public function all();

    public function find($id);
}
    

