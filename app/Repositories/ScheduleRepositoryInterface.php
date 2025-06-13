<?php

namespace App\Repositories;

interface ScheduleRepositoryInterface{

    public function add($request);
    public function get($request);
}