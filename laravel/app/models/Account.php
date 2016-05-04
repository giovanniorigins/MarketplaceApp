<?php

class Account extends Eloquent {
	protected $table = 'accounts';
	//protected $fillable = [];

    public function user() {
        return $this->hasOne('User');
    }
}