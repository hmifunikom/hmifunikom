<?php namespace HMIF\Model\Cakrawala;

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
use LaravelBook\Ardent\Ardent;

class User extends Ardent implements UserInterface, RemindableInterface {
    protected $table = 'tb_cakrawala_user';
    protected $primaryKey = 'id_user';

    public $autoHydrateEntityFromInput = true;    // hydrates on new entries' validation
    public $forceEntityHydrationFromInput = true; // hydrates whenever validation is called
    public $autoPurgeRedundantAttributes = true;
    
    public static $passwordAttributes  = array('password');
    public $autoHashPasswordAttributes = true;

    protected $fillable = array('username', 'email', 'password_confirmation');
	protected $guarded = array('id_user', 'password');

    protected $hidden = array('password');

	public static $rules = array(
        'username'              => 'required|unique:tb_cakrawala_user',
        'email'                 => 'required|email',
    );

    public function userable()
    {
        return $this->morphTo();
    }

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

    public function getRememberToken()
    {
        return $this->remember_token;
    }

    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }

    public function getRememberTokenName()
    {
        return 'remember_token';
    }
}
