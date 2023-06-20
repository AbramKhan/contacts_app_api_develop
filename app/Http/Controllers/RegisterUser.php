<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterUser extends Controller
{
    function register (Request $request){ 
        $request->validate([
            'name' => 'required',
            'email' => 'email|required',
            'password' => 'required|min:6|max:12'

        ]);
      $userData =  User::create([
         'name'     => $request->name,
         'email'    => $request->email,
         'password' => Hash::make($request->password),
         ]);

         return response()->json([
           'msg' => "Thank you for your registeration",
           "user" =>  $userData
         ]);
    }

    function login(Request $request){
        $userEmail = $request->email;
        $userPassword = $request->password;
        
       
        $userData = User::where('email', $userEmail )->firstOrFail();
    
        if($userData){
          
         if (Hash::check($userPassword, $userData->password )){
                $token = $userData->createToken("API TOKEN")->plainTextToken;
                 return response()->json([
                    "token"=>$token,
                    "user" => $userData
                 ]);
         }
         else{
      
            return "password is wrong";
         }
         
        }
        else{
           return "wrong info";
        }
    }
}

//{
   // bisnu:"Abram"
//}