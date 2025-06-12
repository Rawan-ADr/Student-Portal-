<?php

namespace App\Repositories;
use App\Models\Field;


    interface FieldRepositoryInterface
{
    public function create(array $data): Field;

    public function attachValidations(Field $field, ?array $validationIds): void;

    public function loadRelations(Field $field): Field;
    
    public function findByNameAndType(string $name, int $typeId): ?Field;

    public function findById(int $id): ?Field;
    
    public function delete(Field $field): bool;

    public function update(Field $field, array $data): Field;
    
    public function syncValidations(Field $field, array $validationIds): void;

    public function all();

    public function addFieldValue($request,$Request);
}
    

