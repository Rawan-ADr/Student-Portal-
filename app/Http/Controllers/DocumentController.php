<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\documentRequest;
use App\Http\Requests\FieldRequest;
use App\Http\Requests\FieldUpdateRequest;
use App\Http\Requests\DocumentFieldRequest;
use App\Http\Requests\AttachmentRequest;
use App\Services\DocumentService;
use App\Http\Responses\Response;
use PHPUnit\Event\Code\Throwable;

class DocumentController extends Controller
{
    private DocumentService $documentService;

    public function __construct(DocumentService $documentService){
       $this->documentService = $documentService;
    }


    public function create(documentRequest $request){
        
        $data=[];
        try{
            
            $data=$this->documentService->create($request->validated());
            return Response::Success($data['document'],$data['message']) ;}
            
    
        catch (Throwable $th){
            $message=$th->getmessage();
            return Response::Error($data,$message);

        }
       
}
    public function update(documentRequest $request,$document_id){
        $data=[];
          try{
        
            $data=$this->documentService->update($request->validated(),$document_id);
             return Response::Success($data['document'],$data['message']) ;}
        

          catch (Throwable $th){
              $message=$th->getmessage();
              return Response::Error($data,$message);

    }

}

    public function delete($document_id){
        $data=[];
        try{
    
           $data=$this->documentService->delete($document_id);
           return Response::Success($data['document'],$data['message']) ;}
    

        catch (Throwable $th){
            $message=$th->getmessage();
            return Response::Error($data,$message);

        }

    }

    public function createField(FieldRequest $request){
        $data=[];
        try{
            $request->validated();
    
           $data=$this->documentService->createField($request->input('fields'));
           return Response::Success($data['field'],$data['message']) ;}
    

        catch (Throwable $th){
            $message=$th->getmessage();
            return Response::Error($data,$message);

        }

    }

    public function indexType(){
        $data=[];
        try{
    
           $data=$this->documentService->indexType();
           return Response::Success($data['type'],$data['message']) ;}
    

        catch (Throwable $th){
            $message=$th->getmessage();
            return Response::Error($data,$message);

        }

    }

    public function indexValidation(){
        $data=[];
        try{
    
           $data=$this->documentService->indexValidation();
           return Response::Success($data['validation'],$data['message']) ;}
    

        catch (Throwable $th){
            $message=$th->getmessage();
            return Response::Error($data,$message);

        }

    }

    public function deleteField($field_id){
        $data=[];
        try{
            
            $data=$this->documentService->deleteField($field_id);
            return Response::Success($data['field'],$data['message']) ;}
            
    
        catch (Throwable $th){
            $message=$th->getmessage();
            return Response::Error($data,$message);

        }

    }

    public function updateField(FieldUpdateRequest $request, $field_id){
        $data=[];
        try{
            
           $data=$this->documentService->updateField($request->validated(),$field_id);
           return Response::Success($data['field'],$data['message']) ;}
    

        catch (Throwable $th){
            $message=$th->getmessage();
            return Response::Error($data,$message);

        }

    }


    public function indexField(){
        $data=[];
        try{
    
           $data=$this->documentService->indexField();
           return Response::Success($data['field'],$data['message']) ;}
    

        catch (Throwable $th){
            $message=$th->getmessage();
            return Response::Error($data,$message);

        }

    }

    public function indexFieldById($field_id){
        $data=[];
        try{
    
           $data=$this->documentService->indexFieldById($field_id);
           return Response::Success($data['field'],$data['message']) ;}
    

        catch (Throwable $th){
            $message=$th->getmessage();
            return Response::Error($data,$message);

        }
    }

    public function createAttachment(AttachmentRequest $request){
          $data=[];
        try{
    
           $data=$this->documentService->createAttachment($request->validated());
           return Response::Success($data['attachment'],$data['message']) ;}
    

        catch (Throwable $th){
            $message=$th->getmessage();
            return Response::Error($data,$message);

        }

    }

    public function indexAttachment(){

        $data=[];
        try{
    
           $data=$this->documentService->indexAttachment();
           return Response::Success($data['attachment'],$data['message']) ;}
    

        catch (Throwable $th){
            $message=$th->getmessage();
            return Response::Error($data,$message);

        }


    }

    public function updateAttachment(AttachmentRequest $request,$attachment_id){
        $data=[];
        try{
    
           $data=$this->documentService->updateAttachment($request->validated(),$attachment_id);
           return Response::Success($data['attachment'],$data['message']) ;}
    

        catch (Throwable $th){
            $message=$th->getmessage();
            return Response::Error($data,$message);

        }
    }

    public function deleteAttachment($attachment_id){

        $data=[];
        try{
    
           $data=$this->documentService->deleteAttachment($attachment_id);
           return Response::Success($data['attachment'],$data['message']) ;}
    

        catch (Throwable $th){
            $message=$th->getmessage();
            return Response::Error($data,$message);

        }
    }

    public function indexCondition(){

        $data=[];
        try{
    
           $data=$this->documentService->indexCondition();
           return Response::Success($data['condition'],$data['message']) ;}
    

        catch (Throwable $th){
            $message=$th->getmessage();
            return Response::Error($data,$message);

        }


    }

     public function ShowAllDocuments(){
        $data=[];
        try{
    
           $data=$this->documentService->ShowAllDocuments();
           return Response::Success($data['documents'],$data['message']) ;}
    

        catch (Throwable $th){
            $message=$th->getmessage();
            return Response::Error($data,$message);

        }
    }

    public function indexDocument($document_id){

        $data=[];
        try{
    
           $data=$this->documentService->indexDocument($document_id);
           return Response::Success($data['document'],$data['message']) ;}
    

        catch (Throwable $th){
            $message=$th->getmessage();
            return Response::Error($data,$message);

        }

    }
}