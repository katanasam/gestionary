<?php

namespace App\Http\Controllers\Auth;

use Egulias\EmailValidator\EmailLexer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:admin');
    }

    public function show_login_form()
   {
       // on lui montre juste la vue sur cette page
       return view('auth/admin-login');

   }


   public function login(Request $request)
   {

       // validation du formulaire
        $this->validate($request,[
            'email'=>'required|email',
            'password'=> 'required|min:6'
        ]);


       // tentative de connexion
       // cette method return true or false
       if (Auth::guard('admin')->attempt([
           'email' => $request->email,
           'password' =>$request->password],
           $request->remember)){

           // if  success redirect
           return redirect()->intended(route('admin.dashboard'));
       }

       // if not-success redirect-back
        // on les renvoie sur la page de connection avec les informations qu'il on données
       return redirect()->back()->withInput($request->only('email','remember'));

   }
}
