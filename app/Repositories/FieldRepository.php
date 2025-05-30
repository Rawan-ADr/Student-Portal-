<?php
namespace App\Repositories;
use App\Models\Field;

class FieldRepository implements FieldRepositoryInterface
{
    public function create(array $data): Field
    {
        return Field::create([
            'name' => $data['name'],
            'field_type_id' => $data['field_type_id'],
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
        return $field->load(['validation', 'type']);
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
}