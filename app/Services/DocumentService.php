<?php


namespace App\Services;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Repositories\DocumentRepositoryInterface;
use App\Repositories\FieldRepositoryInterface;
use App\Repositories\TypeRepositoryInterface;
use App\Repositories\AttachmentRepositoryInterface;
use App\Repositories\ValidationRepositoryInterface;
use App\Repositories\ConditionRepositoryInterface;


class DocumentService
{
    private  $documentRepository;
    private  $fieldRepository;
    private  $typeRepository;
    private  $validationRepository;
    private  $attachmentRepository;
    private  $conditionRepository;

     public function __construct(DocumentRepositoryInterface $documentRepository,
     FieldRepositoryInterface $fieldRepository,TypeRepositoryInterface $typeRepository,
     ValidationRepositoryInterface $validationRepository,AttachmentRepositoryInterface $attachmentRepository,
     ConditionRepositoryInterface $conditionRepository){
        $this->documentRepository = $documentRepository;
        $this->fieldRepository = $fieldRepository;
        $this->typeRepository = $typeRepository;
        $this->validationRepository = $validationRepository;
        $this->attachmentRepository = $attachmentRepository;
        $this->conditionRepository = $conditionRepository;
        
     }
     

     public function create(array $data){
       
        if ( Auth::user()->hasRole('admin')) {
        return $this->documentRepository->create($data);}
    
         $message="you can not create document ";
    
            return ["document"=>null,"message"=>$message];
        }

        public function update($request,$document_id){

            $document = $this->documentRepository->find($document_id);
            
            if (is_null($document)) {
                return ["document" => null, "message" => "document not found."];
            }
        
            if ( Auth::user()->hasRole('admin')) {
              $document= $this->documentRepository->update($request, $document_id);

              return ["document" => $document, "message" => "document updated."];
            }

            else{
                return ["document" => null, "message" => "you cant update document"];

            }
        
           
        }

        public function delete($document_id){

            $document = $this->documentRepository->find($document_id);
            
            if (is_null($document)) {
                return ["document" => null, "message" => "document not found."];
            }
        
            if ( Auth::user()->hasRole('admin')) {
              $document= $this->documentRepository->delete( $document_id);

              return ["document" => $document, "message" => "document deleted"];
            }

            else{
                return ["document" => null, "message" => "you cant delete document"];

            }
        
           
        }

        public function createField(array $fields): array
        {
            if (Auth::user()->hasRole('admin')) {
                $createdFields = [];
        
                foreach ($fields as $fieldData) {
                    
                    $existingField = $this->fieldRepository->findByNameAndType(
                        $fieldData['name'],
                        $fieldData['field_type_id']
                    );
        
                    if ($existingField) {
                       
                        $createdFields[] = $this->fieldRepository->loadRelations($existingField);
                        continue;
                    }
        
                
                    $field = $this->fieldRepository->create($fieldData);
                    $this->fieldRepository->attachValidations($field, $fieldData['validation_ids'] ?? []);
                    $createdFields[] = $this->fieldRepository->loadRelations($field);
                }
        
                return [
                    'field' => $createdFields,
                    'message' => 'Fields processed successfully (created/skipped existing)'
                ];
            }
        
            return [
                'fields' => [],
                'message' => 'Unauthorized'
            ];
        }

        public function indexType(){

            if ( Auth::user()->hasRole('admin')) {

            $type = $this->typeRepository->all();
            if (is_null($type)) {
                return ["type" => null, "message" => " not found any type."];
            }
            else{
                return ["type" => $type, "message" => " types indexed successfully."];
            }
        }
        }

        public function indexValidation(){

            if ( Auth::user()->hasRole('admin')) {

            $type = $this->validationRepository->all();
            if (is_null($type)) {
                return ["validation" => null, "message" => " not found any validation."];
            }
            else{
                return ["validation" => $type, "message" => " validations indexed successfully."];
            }
        }
        }

        public function deleteField(int $field_id): array
        {
          if (!Auth::user()->hasRole('admin')) {
            return ['field'=>null,'message' => 'you cant delete field'];
          }

          $field = $this->fieldRepository->findById($field_id);

          if (!$field) {
            return ['field'=>null,'message' => 'Field not found'];
          }

          $this->fieldRepository->delete($field);

         return ['field'=>null,'message' => 'Field deleted successfully'];
        }

        

        public function updateField(array $data, $field_id): array
        {
           if (!Auth::user()->hasRole('admin')) {
            return ['field'=>null,'message' => 'you cant update field'];
            }

            $field = $this->fieldRepository->findById($field_id);
           if (!$field) {
            return ['field'=>null,'message' => 'Field not found'];
           }

           $updatedField = $this->fieldRepository->update($field, $data);

           
           if (array_key_exists('validation_ids', $data)) {
               $this->fieldRepository->syncValidations($updatedField, $data['validation_ids']);
           }
       
       
           $fieldWithRelations = $this->fieldRepository->loadRelations($updatedField);
       
           return [
               'field' => $fieldWithRelations,
               'message' => 'Field updated successfully'
           ];
        }


    public function indexField(){

        if ( Auth::user()->hasRole('admin')) {

            $field = $this->fieldRepository->all();
            if (is_null($field)) {
                return ["field" => null, "message" => " not found any field."];
            }
            else{
                return ["field" => $field, "message" => " fields indexed successfully."];
            }
        }
    }

    public function indexFieldById($field_id){

        if ( Auth::user()->hasRole('admin')) {

            $field = $this->fieldRepository->findById($field_id);
            if (is_null($field)) {
                return ["field" => null, "message" => " not found field."];
            }
            else{
                return ["field" => $field, "message" => " field indexed successfully."];
            }
        }

    }

    public function createAttachment($request){

        if ( Auth::user()->hasRole('admin')) {
             $attachment= $this->attachmentRepository->create($request);
    
             $message="attachment created successfully ";
    
            return ["attachment"=>$attachment,"message"=>$message];
        }
         return ["attachment"=>null,"message"=>"you can not create attachment"];
    }

    public function indexAttachment(){

        if ( Auth::user()->hasRole('admin')) {
             $attachment= $this->attachmentRepository->all();
    
             $message="attachment indexed successfully ";
    
            return ["attachment"=>$attachment,"message"=>$message];
        }
         return ["attachment"=>null,"message"=>"you can not index attachment"];
    }

    public function updateAttachment($request,$attachment_id){

        if (!Auth::user()->hasRole('admin')) {
            return ['attachment'=>null,'message' => 'you cant update attachment'];
            }

            $attachment = $this->attachmentRepository->find($attachment_id);
           if (!$attachment) {
            return ['attachment'=>null,'message' => 'attachment not found'];
           }

           $updatedAttachment = $this->attachmentRepository->update($request,$attachment_id);
            return ['attachment'=>$updatedAttachment,'message' => 'attachment updated successsfully'];

    }

    public function deleteAttachment($attachment_id){

        if (!Auth::user()->hasRole('admin')) {
            return ['attachment'=>null,'message' => 'you cant delete attachment'];
          }

          $attachment = $this->attachmentRepository->find($attachment_id);

          if (!$attachment) {
            return ['attachment'=>null,'message' => 'attachment not found'];
          }

          $this->attachmentRepository->delete($attachment_id);

         return ['attachment'=>null,'message' => 'attachment deleted successfully'];

    }

    public function indexCondition(){

         if ( Auth::user()->hasRole('admin')) {
             $condition= $this->conditionRepository->all();
    
             $message=" condition indexed successfully ";
    
            return ["condition"=>$condition,"message"=>$message];
        }
         return ["condition"=>null,"message"=>"you can not index conditions"];
    }


    
     public function ShowAllDocuments(){


        $documents=$this->documentRepository->getall();
        if (is_null($documents)) {
            
            return ["documents" => null, "message" => " no documents."];
        }
        else{
            return ["documents" => $documents, "message" => " this is all documents."];
        }


        
    }

    public function indexDocument($document_id){

        $document=$this->documentRepository->find($document_id);
        if (is_null($document)) {
            
            return ["document" => null, "message" => " no document."];
        }
        else{
            return ["document" => $document, "message" => " document indexed successfully."];
        }

    }
    }
    
           
    
      

   
