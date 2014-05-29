<?php

class IFGamesSessionsController extends BaseController {

  /**
   * Show the form for creating a new session.
   *
   * @return Response
   */
  public function create()
  {
      // Check if we already logged in
      if (Auth::ifgames()->check())
      {
        // Redirect to homepage
        return Redirect::intended('ifgames/anggota')->with('success', 'Anda sudah masuk sebelumnya.');
      }

      // Show the login page
      return View::make('pages.ifgames.sessions.create')->with(array('pagetitle' => 'Login Peserta - IF Games'));
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
          'password'  => 'Required',
          'recaptcha_response_field' => 'required|recaptcha',
      );

      // Validate the inputs.
      $validator = Validator::make(Input::all(), $rules);

      // Check if the form validates with success.
      if ($validator->passes())
      {
          // Try to log the user in.
          if (Auth::ifgames()->attempt($userdata))
          {
              return Redirect::intended('ifgames/anggota')->with('success', 'Anda berhasil masuk!');
          }
          else
          {
              // Redirect to the login page.
              return Redirect::route('ifgames.sessions.create')->withErrors(array('password' => 'Password salah'))->withInput(Input::except('password'));
          }
      }

      // Something went wrong.
      return Redirect::route('ifgames.sessions.create')->withErrors($validator)->withInput(Input::except('password'));
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
      Auth::ifgames()->logout();

      // Redirect to homepage
      return Redirect::to('ifgames')->with('success', 'Anda telah keluar!');
  }

}