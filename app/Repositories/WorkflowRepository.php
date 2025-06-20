<?php
namespace App\Repositories;
use App\Models\Workflow;
use App\Models\Document;

class WorkflowRepository implements WorkflowRepositoryInterface
{
    public function all()
    {
        $workflow= Workflow::with('flowStep')->get();
        return $workflow;

    }

    public function find($id){

        $workflow= Workflow::find($id);
        return $workflow->load('flowStep');

    }

     public function create(array $data)
    {
        $workflow= Workflow::create([
                'name' => $data['name'],
            ]);

            return $workflow;
    }

      public function addSteps(Workflow $workflow, array $steps): void
    {
        foreach ($steps as $step) {
            $workflow->flowStep()->create($step);
        }


    }

    public function updateWithSteps(int $id, array $data): Workflow
{
    $workflow = Workflow::findOrFail($id);

    
    if (isset($data['name'])) {
    $workflow->name = $data['name'];
    }
    $workflow->save();


    $existingStepIds = $workflow->flowStep()->pluck('id')->toArray();
    $incomingStepIds = [];

    foreach ($data['steps'] as $stepData) {
        if (isset($stepData['id'])) {
           
            $step = $workflow->flowStep()->find($stepData['id']);
            if ($step) {
                $step->update([
                    'step_order' => $stepData['step_order'],
                    'role_id' => $stepData['role_id'],
                    'is_final' => $stepData['is_final'],
                    'step_name'=> $stepData['step_name'],
                ]);
                $incomingStepIds[] = $step->id;
            }
        } else {
           
            $newStep = $workflow->flowStep()->create([
                'step_order' => $stepData['step_order'],
                'role_id' => $stepData['role_id'],
                'is_final' => $stepData['is_final'],
                'step_name'=> $stepData['step_name'],
            ]);
            $incomingStepIds[] = $newStep->id;
        }
    }

   
   // $stepsToDelete = array_diff($existingStepIds, $incomingStepIds);
    //if (!empty($stepsToDelete)) {
      //  $workflow->steps()->whereIn('id', $stepsToDelete)->delete();
   // }

    return $workflow->load('flowStep');
   }

   public function delete($id)
    {
        $workflow = Workflow::find($id);
        if ($workflow) {
            $workflow->delete();
            return true;
        }
        return false;
    }

    public function assignWorkflow(array $data){

         $document = Document::findOrFail($data['document_id']);
         $document->workflow()->syncWithoutDetaching($data['workflow_id']); 
         return true;

    }


    

}