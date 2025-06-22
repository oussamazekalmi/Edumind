<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index() {
        if(Auth::check()){
            return redirect()->route('index.frais');
        }
        return view('pages.login');
    }

    public function login(Request $request)
    {
        $validation = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ], [
            'email.required' => "L'adresse e-mail est obligatoire.",
            'email.email' => "Veuillez entrer une adresse e-mail valide.",
            'password.required' => "Le mot de passe est obligatoire.",
            'password.min' => "Le mot de passe doit contenir au moins 8 caractères.",
        ]);

        if (Auth::attempt($validation)) {
            session()->regenerate();
            return redirect()->route('index.frais');
        } else {
            return back()->withErrors([
                'email' => "L'adresse e-mail est incorrecte.",
                'password' => "Le mot de passe est incorrect.",
            ]);
        }
    }

    public function logout() {
        Auth::logout();
        return redirect()->route('auth.index');
    }

    public function forgetPassword() {
        return view('pages.forgetPassword');
    }

    public function emailSearch(Request $request)
    {
        $validation = $request->validate([
            'email'=>'required|email'
        ]);

        $user = User::where('email',$validation['email'])->first();

        if($user){
            return redirect()->route('email.forgetPassword',['user'=>$user->id]);
        }else{
            return back()->with(['danger'=>'Cet e-mail est introuvable.']);
        }
    }

    public function restPassword(Request $request, User $user)
    {
        return view('pages.restPassword',compact('user'));
    }

    public function updatePassword(Request $request,User $user)
    {
        $validated = $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'password.required' => 'Le champ mot de passe est obligatoire.',
            'password.string' => 'Le mot de passe doit être une chaîne de caractères.',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
        ]);

        $user->password = $validated['password'];

        $user->save();

        return redirect()->route('auth.index')->with(['success' => 'Votre mot de passe a été réinitialisé.']);
    }

    public function profile() {
        return view('pages.profile');
    }

    public function editProfile(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $validated = $request->validate([
            'nom' => ['required', 'string'],
            'prenom' => ['required', 'string'],
            'email' => ['required', 'email'],
            'cin' => [
                'required',
                'regex:/^[A-Za-z][0-9]{3,6}$/'
            ],
            'genre' => ['required', 'in:male,female'],
        ], [
            'nom.required' => 'Le champ nom est obligatoire.',
            'nom.string' => 'Le nom doit être une chaîne de caractères.',
            'prenom.required' => 'Le champ prénom est obligatoire.',
            'prenom.string' => 'Le prénom doit être une chaîne de caractères.',
            'email.required' => 'Le champ e-mail est obligatoire.',
            'email.email' => 'Le champ e-mail doit être une adresse email valide.',
            'cin.required' => 'Le champ CIN est obligatoire.',
            'cin.regex' => 'La CIN doit commencer par une lettre suivie de 3 à 6 chiffres.',
            'genre.required' => 'Le genre est obligatoire.',
            'genre.in' => 'Le genre sélectionné est invalide.',
        ]);

        $user->update($validated);

        return back();
    }

    public function editPassword() {
        return view('pages.passwordPages');
    }

    public function updatePasswordProfile(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $validated = $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'password.required' => 'Le champ mot de passe est obligatoire.',
            'password.string' => 'Le mot de passe doit être une chaîne de caractères.',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
        ]);

        if (Hash::check($validated['password'], $user->password)) {
            return back()->withErrors(['password' => 'Ce mot de passe est déjà utilisé.'])->withInput();
        } else {
            $user->password = Hash::make($validated['password']);
            $user->save();

            Auth::logout();
            return redirect()->route('auth.index');
        }
    }
}
