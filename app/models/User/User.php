<?php namespace HMIF\Model\User;

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
use Qwildz\Ardent\Ardent;

class User extends Ardent implements UserInterface, RemindableInterface {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';
    protected $primaryKey = 'id_user';

    public $autoHydrateEntityFromInput = true;    // hydrates on new entries' validation
    public $forceEntityHydrationFromInput = true; // hydrates whenever validation is called
    public $autoPurgeRedundantAttributes = true;
    
    public static $passwordAttributes  = array('password');
    public $autoHashPasswordAttributes = true;

    protected $fillable = array('username', 'email', 'password_confirmation');
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

    public static $relationsData = array(
        'identitas' => array(self::HAS_ONE, 'HMIF\Model\IFCenter\UserUmum', 'foreignKey' => 'id_user_umum'),
        'anggota'   => array(self::HAS_ONE, 'HMIF\Model\Keanggotaan\Anggota', 'foreignKey' => 'id_anggota'),
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

    /**
     * Authority
    */

    public function roles() {
        return $this->belongsToMany('HMIF\Model\User\Role');
    }

    public function permissions() {
        return $this->hasMany('HMIF\Model\User\Permission');
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
}