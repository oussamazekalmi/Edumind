<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\ForgetPassWord;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function forgetPassword(User $user)
    {
        $forgetPassword = route('auth.resetPassword',['user'=>$user->id]);

        Mail::to($user->email)->send(new ForgetPassWord($user->username,null,null,$forgetPassword));

        return redirect()->route('auth.index')->with(['success'=>'Vérifier votre boite e-mail']);
    }
}