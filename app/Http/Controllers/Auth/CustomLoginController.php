<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Session;
use Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Device\RestAPIController;
use App\Entities\User;
use Carbon\Carbon;
use Illuminate\Support\MessageBag;
//use Illuminate\Support\Facades\Session;


class CustomLoginController extends Controller
{


  public function __construct()
      {

        //  $this->middleware('web');

        //  $this->API = new RestAPIController();
      }



   public function login(Request $request)
   {

     $input = $request->get('username');
     $pass = $request->get('password');

     $validator = Validator::make($request->all(), [
         'username' => 'required',
         'password'=>'required'
     ]);
     if($validator->fails()) {

      return  redirect('/login')->withErrors($validator)->withInput($request->all());
    }


     if(filter_var($input, FILTER_VALIDATE_EMAIL)) {

       $auth_attempt = Auth::attempt(['email' => $input, 'password' => request('password')]);

       if($auth_attempt==true)
       {
           $user = Auth::user();
           $url = $user->type == User::$TYPE_CUSTOMER ? '/car/tracking' : '/home';

         return redirect($url);
       }

      else{
         $errors = new MessageBag(['password' => ['Username or password is invalid.']]);

         return redirect()->back()->withErrors($errors)->withInput($request->all());

      }
  
     }

    else {
        // other input
        if(is_numeric($input))
        {
        $auth_attempt =   Auth::attempt(['phone' => $input, 'password' => request('password')]);
        if($auth_attempt==true)
          {
              $user = Auth::user();
              $url = $user->type == User::$TYPE_CUSTOMER ? '/car/tracking' : '/home';

            return redirect($url);
          }
        }

        $errors = new MessageBag(['password' => ['Username or password is invalid.']]);
        return redirect()->back()->withErrors($errors)->withInput($request->all());

    }



   }

   public function getUserName(Request $request)
   {

     return view('auth.forget');

   }


   public function setNewPassword(Request $request)
   {

     return view('auth.newPassword');

   }

   public function newPassword(Request $request)
   {

     $password = $request->get('password');
     $code = $request->get('code');
     $messages = [];

     $validator = Validator::make($request->all(), [
       'code' => 'required',
       'password' => 'required|string|min:6|confirmed'
     ]);
     if ($validator->fails()) {
       $messages = $validator->errors();
      return redirect('/password/setNewPassword')->withErrors($messages);
     }

      $User = User::where('verification_code',$code)->first();

     if(!is_null($User))
     {
       if($User->verification_code_expires->gt(Carbon::now()) && $User->is_verification_code_valid==true)
        {

          if(isset($password)) //change password
           {
             $User->password = bcrypt($password);
             $User->is_verification_code_valid = false;
             if($User->save())
             {
               $loginURL = route('login');
               $msg = 'Password Updated ! Please Login';

              \Session::flash('password_reset_success',$msg);

                //print_r(Session::get('password_reset_success'))
               return redirect('/login');

             }

             \Session::flash('flash','Changing password failed');
             return redirect('/password/setNewPassword');
           }

        }
        else{

          if($User->is_verification_code_valid==false)
          {

          $messages['code'][] = "Verification Code Already Used Once .Please Request for another one";
          return redirect('/password/setNewPassword')->withErrors($messages);
          }

          $messages['code'][] = "Verification Code Expired .Please Request for another one";
          return redirect('/password/setNewPassword')->withErrors($messages);
        }

     }
     else{
     $messages['code'][] = "Wrong verification code";
    return redirect('/password/setNewPassword')->withErrors($messages);
   }

   }



}
