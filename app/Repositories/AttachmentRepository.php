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
        
    }

    public function delete($id)
    {
        $document = Document::find($id);
        if ($document) {
            $document->delete();
            return true;
        }
        return false;
    }

     public function all()
    {
        return Attachment::all();
    }

    

    
}