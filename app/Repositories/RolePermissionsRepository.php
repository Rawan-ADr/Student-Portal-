<?php
namespace App\Repositories;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionsRepository implements RolePermissionsRepositoryInterface
{


     public function getAllRoles()
    {
        return Role::where('name','!=','admin')->select('id','name')->get();
    }

    
    public function getAllPermissions()
    {
        return Permission::select('id','name')->get(); 
    }

    
    public function getPermissionsForRole($roleId)
    {
        $role = Role::with('permissions')->findOrFail($roleId);
        return $role->permissions;
    }

    public function assignPermissions(array $data){

    $role = Role::find($data['role_id']);
        if (!$role) {
            return false;
        }

        $permissions = Permission::whereIn('id', $data['permissions'])->pluck('id')->toArray();

        if (count($permissions) !== count($data['permissions'])) {
            return false;
        }
   
        $role->syncPermissions($permissions);
        return true;
    
    }

   

    
}