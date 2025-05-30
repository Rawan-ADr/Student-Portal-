<?php
namespace App\Repositories;
use App\Models\Document;

class DocumentRepository implements DocumentRepositoryInterface
{


    public function create(array $data)
    {
          $document = Document::create([
            'name' => $data['name'],
            'content' => $data['content'],
        ]);

        $document->field()->syncWithoutDetaching($data['field_ids']);
        $document->attachment()->syncWithoutDetaching($data['attachment_ids']);
        $document->condition()->syncWithoutDetaching($data['condition_ids']);
        return $document->name;
    }


    public function find($id)
    {
        return Document::find($id);
    }

    public function update(array $data, $id)
    {
        $document = Document::findOrFail($id);
        if ($document) {
            $document->update([
                  'name' => $data['name'],
                 'content' => $data['content'],

            ]);
            $document->field()->syncWithoutDetaching($data['field_ids']);
            $document->attachment()->syncWithoutDetaching($data['attachment_ids']);
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
        $document= Document::all();
        return $document->name;


    }

    

    
}