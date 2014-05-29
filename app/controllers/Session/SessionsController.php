<?php

class SessionsController extends BaseController {

    private $auth;

    public function __construct()
    {
        $redirect_to = Session::get('redirect_to');
    
        switch($redirect_to)
        {
            case 'panel':
                $this->auth = Auth::panel();
                break;

            case 'ifgames':
                $this->auth = Auth::ifgames();
                break;

            default:
                $this->auth = Auth::panel();
                break;
        }
    }

    /**
    * Show the form for creating a new session.
    *
    * @return Response
    */
    public function create()
    {
        // Check if we already logged in
        if ($this->auth->check())
        {
            // Redirect to homepage
            return Redirect::intended('/')->with('success', 'Anda sudah masuk sebelumnya.');
        }

        // Show the login page
        return View::make('pages.sessions.create');
    }

    /**
    * Store a newly created resource in session.
    *
    * @return Response
    */
    public function store()
    {
        // Get all the inputs
        // email is used for login and for validation to return correct error-strings
        $userdata = array(
            'username' => Input::get('username'),
            'password' => Input::get('password')
        );

        // Declare the rules for the form validation.
        $rules = array(
            'username'  => 'Required',
            'password'  => 'Required'
        );

        // Validate the inputs.
        $validator = Validator::make($userdata, $rules);

        // Check if the form validates with success.
        if ($validator->passes())
        {
            // Try to log the user in.
            if ($this->auth->attempt($userdata))
            {
                // Redirect to homepage
                return Redirect::intended('/')->with('success', 'Anda berhasil masuk!');
            }
            else
            {
                // Redirect to the login page.
                return Redirect::route('sessions.create')->withErrors(array('password' => 'Password salah'))->withInput(Input::except('password'));
            }
        }

        // Something went wrong.
        return Redirect::route('sessions.create')->withErrors($validator)->withInput(Input::except('password'));
    }

    /**
    * Remove the specified resource from session.
    *
    * @param  int  $id
    * @return Response
    */
    public function destroy()
    {
        // Log out
        Auth::panel()->logout();
        Auth::ifgames()->logout();

        // Redirect to homepage
        return Redirect::to('/')->with('success', 'Anda telah keluar!');
    }

    private function getRedirect()
    {

    }

}