<?php


namespace App\Services;


use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Repositories\UserRepositoryInterface;


class UserService
{
    private  $userRepository;
    

     public function __construct(UserRepositoryInterface $userRepository){
        $this->userRepository = $userRepository;
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


   
    
   
}