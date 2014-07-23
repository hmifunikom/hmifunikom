<?php

class CakrawalaSessionsController extends BaseController {

  /**
   * Show the form for creating a new session.
   *
   * @return Response
   */
  public function create()
  {
      // Check if we already logged in
      if (Auth::cakrawala()->check())
      {
        // Redirect to homepage
        return Redirect::route('cakrawala.anggota.index')->with('success', 'Anda sudah masuk sebelumnya.');
      }

      // Show the login page
      return View::make('pages.cakrawala.sessions.create')->with(array('pagetitle' => 'Login Peserta'));
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
          if (Auth::cakrawala()->attempt($userdata))
          {
              return Redirect::route('cakrawala.anggota.index')->with('success', 'Anda berhasil masuk!');
          }
          else
          {
              // Redirect to the login page.
              return Redirect::route('cakrawala.sessions.create')->withErrors(array('password' => 'Username atau Password salah'));
          }
      }

      // Something went wrong.
      return Redirect::route('cakrawala.sessions.create')->withErrors($validator);
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
      Auth::cakrawala()->logout();

      // Redirect to homepage
      return Redirect::route('cakrawala.sessions.create')->with('success', 'Anda telah keluar!');
  }

}