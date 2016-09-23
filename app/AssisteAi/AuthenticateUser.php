<?php

namespace App\AssisteAi;

use App\User;
use SammyK\LaravelFacebookSdk\LaravelFacebookSdk;
use Facebook\Exceptions\FacebookSDKException;

class AuthenticateUser
{

    private $user;
    private $fb;

    public function __construct(User $user, LaravelFacebookSdk $fb)
    {
        $this->user = $user;
        $this->fb = $fb;
    }

    public function execute($post_data, $listener)
    {
        if(!$post_data) {
            return $this->getAuthorizationFirst();
        }

        try {
            $user = $this->getSocialUser();
        } catch(\PDOException $e) {
            \Log::error('Erro ao fazer login.');
            \Log::debug('Exception: ', ['exception' => $e]);
            flash()->overlay('Ops!', 'Infelizmente você está banido!', 'error');

            return redirect('auth/login');
        }

        \Auth::login($user, true);
        flash()->success('Bom te ver!', 'Olá, seja bem-vindo de volta.');

        return $listener->userHasLoggedIn();
    }

    private function getAuthorizationFirst()
    {
        return redirect($this->fb->getLoginUrl());
    }

    private function getSocialUser()
    {
        // Obtain an access token.
        try {
            $token = $this->fb->getAccessTokenFromRedirect();
        } catch(FacebookSDKException $e) {
            throw $e;
        }

        // Access token will be null if the user denied the request
        // or if someone just hit this URL outside of the OAuth flow.
        if(!$token) {
            // Get the redirect helper
            $helper = $this->fb->getRedirectLoginHelper();

            if(!$helper->getError()) {
                abort(403, 'Unauthorized action.');
                // @TODO erro 403
            }

            // User denied the request
            flash()->error('Erro!', 'Para acessar o site você deve dar nos dar permissão de usar seus dados do Facebook :(');
        }

        if(!$token->isLongLived()) {
            // OAuth 2.0 client handler
            $oauth_client = $this->fb->getOAuth2Client();

            // Extend the access token.
            try {
                $token = $oauth_client->getLongLivedAccessToken($token);
            } catch(FacebookSDKException $e) {
                throw $e;
            }
        }

        $this->fb->setDefaultAccessToken($token);

        //Save for later
        \Session::put('fb_user_access_token', (string)$token);

        // Get basic info on the user from Facebook.
        try {
            $response = $this->fb->get('/me?fields=id,name,email,gender,picture.width(120).height(120)');
        } catch(FacebookSDKException $e) {
            throw $e;
        }

        // Convert the response to a `Facebook/GraphNodes/GraphUser` collection
        $facebook_user = $response->getGraphUser();

        // Create the user if it does not exist or update the existing entry.
        // This will only work if you've added the SyncableGraphNodeTrait to your User model.
        return $this->user->createOrUpdateGraphNode($facebook_user);
    }
}