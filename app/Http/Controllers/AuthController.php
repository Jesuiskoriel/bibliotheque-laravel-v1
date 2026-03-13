<?php
/* METAL-EXPLAIN: Ce fichier fait une partie du boulot de l'app bibliothèque. 
 * Version simple: ce fichier sert à éviter que tout parte en spaghetti 😄.
 * Lisez les fonctions une par une: chacune fait un mini boulot précis.
 */

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * EXPLAIN-FUNC: Cette fonction 'showLogin' fait une étape précise du flux applicatif.
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * EXPLAIN-FUNC: Vérifie email/mot de passe puis ouvre la session utilisateur.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (!Auth::attempt($credentials)) {
            return back()->withErrors(['email' => 'Identifiants invalides'])->onlyInput('email');
        }

        $request->session()->regenerate();

        return Auth::user()->role === 'admin'
            ? redirect('admin/dashboard')
            : redirect('utilisateur');
    }

    /**
     * EXPLAIN-FUNC: Cette fonction 'showRegister' fait une étape précise du flux applicatif.
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * EXPLAIN-FUNC: Crée un nouveau compte utilisateur avec validation.
     */
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $data['role'] = 'user';
        $user = User::create($data);

        Auth::login($user);

        return redirect('utilisateur');
    }

    /**
     * EXPLAIN-FUNC: Ferme la session en cours pour déconnecter l'utilisateur.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}

