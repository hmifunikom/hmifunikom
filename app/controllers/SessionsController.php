<?php

class SessionsController extends BaseController {

  /**
   * Show the form for creating a new session.
   *
   * @return Response
   */
  public function create()
  {
      // Check if we already logged in
      if (Auth::panel()->check())
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
          if (Auth::panel()->attempt($userdata))
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

      // Redirect to homepage
      return Redirect::to('/')->with('success', 'Anda telah keluar');
  }

}