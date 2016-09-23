<?php

namespace App\Http\Controllers\Auth;

use App\AssisteAi\AuthenticateUser;
use App\Http\Controllers\Controller;
use App\Movie;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest', ['except' => ['logout']]);
    }

    /**
     * @param AuthenticateUser $authenticateUser
     * @param Request $request
     * @return mixed
     */
    public function login(AuthenticateUser $authenticateUser, Request $request)
    {
        try {
            return $authenticateUser->execute($request->all(), $this);
        } catch (\Exception $e) {
            \Log::alert('Erro ao fazer login.');
            \Log::debug('Error message: ', ['Exception' => $e]);
            flash()->error('Ops!', 'Ocorreu um erro ao fazer o login, por favor tente novamente mais tarde.');
            return redirect('auth/login');
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function userHasLoggedIn()
    {
        return redirect()->intended('home');
    }

    /**
     * Logout user.
     */
    public function logout()
    {
        \Auth::logout();
        flash()->success('Até logo!', 'Você fez logout com sucesso!');
        return redirect('auth/login');
    }

    /**
     * Show login form.
     */
    public function showLogin()
    {
        $movies = Movie::all();

        return view('auth.login')->with(['movies' => $movies]);
    }

}
