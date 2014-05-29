<?php

class RemindersController extends Controller {

	/**
	 * Display the password reminder view.
	 *
	 * @return Response
	 */
	public function getRemind()
	{
		return View::make('pages.sessions.password.remind');
	}

	/**
	 * Handle a POST request to remind a user of their password.
	 *
	 * @return Response
	 */
	public function postRemind()
	{
		$response = Password::panel()->remind(Input::only('email'), function($message)
		{
		    $message->subject('[AKUN] Reset Password - HMIF Unikom');
		});

		switch ($response)
		{
			case Password::INVALID_USER:
				return Redirect::back()->with('danger', Lang::get($response));

			case Password::REMINDER_SENT:
				return Redirect::back()->with('info', Lang::get($response));
		}
	}

	/**
	 * Display the password reset view for the given token.
	 *
	 * @param  string  $token
	 * @return Response
	 */
	public function getReset($type = null, $token = null)
	{
		if (is_null($token)) App::abort(404);

		return View::make('pages.sessions.password.reset')->with('token', $token);
	}

	/**
	 * Handle a POST request to reset a user's password.
	 *
	 * @return Response
	 */
	public function postReset()
	{
		$credentials = Input::only(
			'email', 'password', 'password_confirmation', 'token'
		);

		$response = Password::panel()->reset($credentials, function($user, $password)
		{
			$user->password = $password;
			$user->save();
		});

		switch ($response)
		{
			case Password::INVALID_PASSWORD:
			case Password::INVALID_TOKEN:
			case Password::INVALID_USER:
				return Redirect::back()->with('danger', Lang::get($response));

			case Password::PASSWORD_RESET:
				return Redirect::route('sessions.create')->with('info', 'Password berhasil diubah!');
		}
	}

}
