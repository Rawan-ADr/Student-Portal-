<?php
namespace App\Repositories;
use App\Models\Field;
use App\Models\FieldValue;

class FieldRepository implements FieldRepositoryInterface
{
    public function create(array $data): Field
    {
        return Field::create([
            'name' => $data['name'],
            'field_type_id' => $data['field_type_id'],
            'processing_by'=> $data['processing_by'],
        ]);
    }

    public function attachValidations(Field $field, ?array $validationIds): void
    {
        if (!empty($validationIds)) {
            $field->validation()->attach($validationIds);
        }
    }

    public function loadRelations(Field $field): Field
    {
        return $field->load(['validation', 'fieldType']);
    }

    public function findByNameAndType(string $name, int $typeId): ?Field
{
    return Field::where('name', $name)
                ->where('field_type_id', $typeId)
                ->first();
}

    public function findById(int $id): ?Field
    {
        return Field::find($id);
    }

     public function delete(Field $field): bool
     {
        return $field->delete();
      }

      public function update(Field $field, array $data): Field
      {
        $field->update([
           'name' => $data['name'],
           'field_type_id' => $data['field_type_id'],
           'processing_by'=> $data['processing_by'],
        ]);

        return $field;
      }   

    public function syncValidations(Field $field, array $validationIds): void
    {
       $field->validation()->sync($validationIds);
    }

    public function all()
    {
        return Field::all();
    }


    public function addFieldValue($request,$Request){
        if ($request->has('fields')) {
            foreach ($request->input('fields') as $fieldId => $value) {
                FieldValue::create([
                    'request_id' => $Request->id,
                    'field_id' => $fieldId,
                    'value' => $value,
                ]);
            }
        }
        return "done";


    }

    
    public function updateFieldValue($request,$Request){
        if ($request->has('fields')) {
            foreach ($request->input('fields') as $fieldId => $value) {
                $fieldvalue=FieldValue::where('request_id', $Request)->where('field_id', $fieldId)->first();
                $fieldvalue->update([
                    'value' => $value,
                ]);
            }
        }

        return "done";


    }

     public function getByName(string $name)
    {
        return Field::where('name', $name)->firstOrFail();
    }

     public function updateOrCreate($requestId, $fieldId, $value)
    {
        return FieldValue::updateOrCreate(
            ['request_id' => $requestId, 'field_id' => $fieldId],
            ['value' => $value]
        );
    }
}