<?php
namespace App\Repositories;
use App\Models\Attachment;

class AttachmentRepository implements AttachmentRepositoryInterface
{


    public function create(array $data)
    {
        return Attachment::create($data);

    }

    public function find($id)
    {
        return Attachment::find($id);
    }

    public function update(array $data, $id)
    {
        $attachment = Attachment::find($id);
        $attachment->update([
           'name' => $data['name'],
           'description' => $data['description'],
           'type' => $data['type'],
        ]);

        return $attachment;
      }   
        
    

    public function delete($id)
    {
        $attachment = Attachment::find($id);
        if ($attachment) {
            $attachment->delete();
            return true;
        }
        return false;
    }

     public function all()
    {
        return Attachment::all();
    }

    

    
}