<?php


use Zizaco\Confide\ConfideUser;
use Zizaco\Confide\ConfideUserInterface;

use Zizaco\Entrust\HasRole;

use LaravelBook\Ardent\Ardent;

class User extends Eloquent implements ConfideUserInterface {

	use ConfideUser, HasRole;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

    protected $with = ['Account'];

    public function account() {
        return $this->hasOne('Account');
    }

}
