<?php

namespace App\Repositories;

interface RolePermissionsRepositoryInterface
{
     public function getAllRoles();
     public function getAllPermissions();
     public function getPermissionsForRole($roleId);
     public function assignPermissions(array $data);
    
    

}