<?php

namespace App\Repositories;

interface StudentRepositoryInterface{
    public function findByNationalNumber(string $nationalNumber);
    public function find($id);
}