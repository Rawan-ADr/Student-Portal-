<?php

namespace App\Repositories;
use App\Models\Workflow;

interface WorkflowRepositoryInterface
{
    public function create(array $data);
    public function addSteps(Workflow $workflow, array $steps);
    public function updateWithSteps(int $id, array $data);
    public function all();
    public function find($id);
    public function delete($id);
    public function assignWorkflow(array $data);
    
    

}