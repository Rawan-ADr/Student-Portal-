<?php
namespace App\Repositories;
use App\Models\Attachment;
use App\Models\AttchmentValue;
use Illuminate\Support\Facades\Storage;

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


    public function addAttachmentValue($request,$Request){
        if ($request->has('attachments')) {
            foreach ($request->attachments as $attachment_id => $file) {

                $path = $file->store('attachments', 'public');
                AttchmentValue::create([
                    'request_id' => $Request->id,
                    'attachment_id' => $attachment_id,
                    'value' => $path,
                ]);
            }
        }

        return "done";


    }

    

    
}