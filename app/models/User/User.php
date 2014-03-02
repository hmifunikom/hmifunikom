<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
use LaravelBook\Ardent\Ardent;

class User extends Ardent implements UserInterface, RemindableInterface {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'tb_user';
	protected $primaryKey = 'id_user';

    public $autoHydrateEntityFromInput = true;    // hydrates on new entries' validation
    public $forceEntityHydrationFromInput = true; // hydrates whenever validation is called

    protected $guarded = array('id_user', 'password');

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password');


	public static $rules = array(
		'username'              => 'required|between:4,16',
		'email'                 => 'required|email',
		'password'              => 'required|min:8|confirmed',
		'password_confirmation' => 'required|min:8',
	);

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail()
	{
		return $this->email;
	}

	/**
	 * Authority
	*/

	public function roles() {
        return $this->belongsToMany('Role');
    }

    public function permissions() {
        return $this->hasMany('Permission');
    }

    public function hasRole($key) {
        foreach($this->roles as $role){
            if($role->name === $key)
            {
                return true;
            }
        }
        return false;
    }

    public function identitas()
    {
    	return $this->belongsTo('UserUmum', 'id_user_umum');
    }

    public function anggota()
    {
        return $this->belongsTo('Anggota', 'id_anggota');
    }

}