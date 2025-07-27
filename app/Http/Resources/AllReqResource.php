<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AllReqResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
         return [
            'id'=>$this->id,
            'document_name' => $this->document->name,
            'date' => $this->date,
            'status'=>$this->status,
            'payment_status'=>$this->payment_status,
            
           
          
        ];
    }
}
