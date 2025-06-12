<?php

namespace App\Repositories;

interface RequestRepositoryInterface{

    public function getReceivedRequest($id);
    public function getRequest($id);
    public function create($studentId,$documentId);

}
