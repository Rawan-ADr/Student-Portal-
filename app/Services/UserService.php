<?php


namespace App\Services;


use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Repositories\UserRepositoryInterface;
use App\Repositories\RolePermissionsRepositoryInterface;


class UserService
{
    private  $userRepository;
    private  $rolepermRepository;
    

     public function __construct(UserRepositoryInterface $userRepository,
     RolePermissionsRepositoryInterface $rolepermRepository ){
        $this->userRepository = $userRepository;
        $this-> rolepermRepository= $rolepermRepository;
     }
     


    public function login($request){
        $user = $this->userRepository->findByEmail($request['email']);
        if(!is_null($user)){
            if(!Auth::attempt($request->only(['email','password']))){
                $message=" email or password is wrong ";
                $code=401;
            }
            else{
                
                $user['token']=$user->createToken("token")->plainTextToken;
                     $role = $user->roles()->first(); 

            if ($role) {
                $user['role'] = [
                    'id' => $role->id,
                    'name' => $role->name
                ];
            } else {
                $user['role'] = null; 
            }

                $message=" logged in successfully ";
                $code=200;
            }
        }
        else{
               $message=" user not found ";
               $code=404;
        }
        return ['user'=>$user,'message'=>$message,'code'=>$code];
    }

    public function logout(){
        $user=$this->userRepository->find(Auth::id());
        if(!is_null($user)){
            Auth::user()->currentAccessToken()->delete();
            $message=" logged out successfully ";
            $code=200;
        }
        else{
            $message=" invalid token ";
            $code=404;
        }
        return ['user'=>$user,'message'=>$message,'code'=>$code];
    }

    public function indexRole(){

        if ( Auth::user()->hasRole('admin')) {

            $role = $this->rolepermRepository->getAllRoles();

            if(is_null($role)){
                return ['role'=>null,'message'=>'not found any role'];
            }
            return ['role'=>$role,'message'=>'role indexed successflly'];
        }
        return ['role'=>null,'message'=>'you can not see role'];


    }

    public function indexPermissions(){

        if ( Auth::user()->hasRole('admin')) {

            $permission = $this->rolepermRepository->getAllPermissions();

            if(is_null($permission)){
                return ['permission'=>null,'message'=>'not found any permission'];
            }
            return ['permission'=>$permission,'message'=>'permission indexed successflly'];
        }
        return ['permission'=>null,'message'=>'you can not see permisssion'];

    }

    public function assignRole($request){

        if ( Auth::user()->hasRole('admin')) {

            $result = $this->userRepository->assignRoleToUser($request);
            if($result){
                return ['result'=> null,'message'=>'role added to user successfully'];
            }
            return ['result'=> null,'message'=>'user or role not found'];

        }
        return ['result'=> null,'message'=>'you can not do this!'];

    }


    public function assignPermissions($request){
        if ( Auth::user()->hasRole('admin')) {

            $result = $this->rolepermRepository->assignPermissions($request);
            if($result){
                return ['result'=> null,'message'=>'permisssion added to role successfully'];
            }
            return ['result'=> null,'message'=>'permisssion or role not found'];

        }
        return ['result'=> null,'message'=>'you can not do this!'];

    }

    public function indexUsers(){
        if ( Auth::user()->hasRole('admin')) {

            $result = $this->userRepository->all();
            if(!is_null($result)){
                return ['users'=> $result,'message'=>'users indexed successfully'];
            }
            return ['users'=> null,'message'=>'users not found'];

        }
        return ['users'=> null,'message'=>'you can not do this!'];
    }

    public function indexUserByToken(){
         $user = $this->userRepository->getAuthenticatedUser();

    if ($user) {
        $role = $user->roles()->first(); 

        $userData = $user->toArray();
        $userData['role'] = $role ? [
            'id' => $role->id,
            'name' => $role->name
        ] : null;

        return [
            'user' => $userData,
            'message' => 'User retrieved successfully'
        ];
    }

    return [
        'user' => null,
        'message' => 'User not authenticated'
    ];
    }
    }

