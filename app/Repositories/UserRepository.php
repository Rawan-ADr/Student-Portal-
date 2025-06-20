<?php
namespace App\Repositories;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserRepository implements UserRepositoryInterface
{
    public function all()
    {
        return User::all();
    }

    public function find($id)
    {
        return User::find($id);
    }

    public function create(array $data)
    {
        return User::create($data);
    }

    public function update($id, array $data)
    {
        $user = $this->find($id);
        if ($user) {
            $user->update($data);
            return $user;
        }
        return null;
    }

    public function delete($id)
    {
        $user = $this->find($id);
        if ($user) {
            $user->delete();
            return true;
        }
        return false;
    }

    public function findByEmail(string $email)
    {
        return User::where('email', $email)->first();
    }

    public function assignRoleToUser(array $data){

         $user = User::findOrFail($data['user_id']);
         $role = Role::findOrFail($data['role_id']);

         if(!is_null($user) && !is_null($role) ){

          $user->assignRole($role->name);

          $permissions = $role->permissions->pluck('name')->toArray(); 
          $user->givePermissionTo($permissions);

          return true;
        }
        return false;



    }

    

}