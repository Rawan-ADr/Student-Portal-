<?php
namespace App\Repositories;
use App\Models\Document;

class DocumentRepository implements DocumentRepositoryInterface
{


    public function create(array $data)
    {
          $existing = Document::where('name', trim($data['name']))->first();

    if ($existing) {
        return [
            'document' => $existing->name,
            'message' => 'Document already exists',
        ];
    }

   
    $document = Document::create([
        'name' => $data['name'],
        'content' => $data['content'],
    ]);

    $document->fields()->syncWithoutDetaching($data['field_ids']);
    $document->attachments()->syncWithoutDetaching($data['attachment_ids']);
    $document->condition()->syncWithoutDetaching($data['condition_ids']);

    return [
        'document' => $document->name,
        'message' => 'Document created successfully',
    ];
    }


   public function findWithRelations($id)
  {
    $document = Document::with(['fields', 'attachments', 'condition'=> function
     ($query) {
            $query->select('conditions.id', 'conditions.name', 'conditions.error_message',
            'conditions.created_at','conditions.updated_at'); 
        }
    ])->findOrFail($id);

    return $document;
   }

   public function find($id){
    
     $document = Document::findOrFail($id);
     return $document;
   }

    public function update(array $data, $id)
    {
        $document = Document::findOrFail($id);
        if ($document) {
            $document->update([
                  'name' => $data['name'],
                 'content' => $data['content'],

            ]);
            $document->fields()->syncWithoutDetaching($data['field_ids']);
            $document->attachments()->syncWithoutDetaching($data['attachment_ids']);
            $document->condition()->syncWithoutDetaching($data['condition_ids']);
        return $document->name;
        }
        return null;
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


    public function all(){
        $document= Document::all()->select('id','name');
        return $document;


    }

    public function getall(){
        $document= Document::all();
        return $document;


    }

    public function findall($id)
    {
        return Document::with(['fields' => function ($query) {
            $query->select('fields.id', 'fields.name', 'fields.field_type_id') 
                ->with([
                    'fieldType:id,type', 
                    'validation:id,validation_rule'
                ]);
        }, 'attachments:id,name,description'])
        ->select('documents.id', 'documents.name') 
        ->find($id);
    }

    

    

    
}