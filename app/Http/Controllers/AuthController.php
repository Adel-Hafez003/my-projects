<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Hash;
use Auth;

class AuthController extends Controller
{
    public function login_admin()
    {
        if(!empty (Auth::check()) && Auth::user()->is_admin == 1)
        {
            return redirect('admin/category/list');
        }
         
        return view('admin.auth.login');
    }

    public function auth_login_admin(Request $request)
    {
    
       $credentials = [
           'email' => $request['email'],
           'password' => $request['password'], // Don't hash the password here
           'is_admin' => 1,
       ];

       if (Auth::attempt($credentials)) {
        // تم تسجيل الدخول بنجاح
        return redirect('admin/category/list');
       } else {
        // فشل تسجيل الدخول، يتم إعادة التوجيه مع رسالة خطأ
        return redirect()->back()->with("error", "Please enter correct email and password");
       }
    }
    public function logout_admin()
    {
        
        Auth::logout(); 
        return redirect(url(''));
    }

    public function auth_login(Request $request)
    {
        // تحديد ما إذا كان سيتم تذكر المستخدم أم لا
        $remember = !empty($request->is_remember) ? true : false;
    
        // تهيئة متغير $json
        $json = [];
    
        // محاولة تسجيل الدخول
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'status' => 0, 'is_delete' => 0], $remember)) {
            $json['status'] = true;
            $json['message'] = 'Login successful';
        } else {
            $json['status'] = false;
            $json['message'] = 'Please enter correct email and password';
        }
    
        return response()->json($json);
    }


    public function auth_register(Request $request)
    {
        // Check if the email already exists
             $checkEmail = User::checkEmail($request->email);
             if (empty($checkEmail))
            {
                 // If email does not exist, create a new user
                 $save = new User;
                 $save->name = trim($request->name);
                 $save->email = trim($request->email);
                 $save->password = Hash::make($request->password);
                 $save->save();
            
                 // Prepare JSON response for successful registration
                 $json['status'] = true;
                 $json['message'] = "Your account successfully created";
            } else
               {
                 // Prepare JSON response for email already registered
                  $json['status'] = false;
                  $json['message'] = "This email is already registered, please choose another";
               }
    
             // Return the JSON response
             echo json_encode($json);
    }


}

/*if (Auth::attempt(['email' => $request['email'], 'password' => $request['password'], 'is_admin' => 1], $remember)) {
    // تم تسجيل الدخول بنجاح
    return redirect('admin/dashboard');
} else {
    
    // فشل تسجيل الدخول، يتم إعادة التوجيه مع رسالة خطأ
    return redirect()->back()->with("error", "Please enter correct email and password");
}
}*/
///


