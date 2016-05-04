<?php

use LaravelBook\Ardent\Facades\Ardent;

class Photo extends Eloquent {
    protected $table = 'photos';
	//protected $fillable = [];

    public function imageable() {
        return $this->morphTo();
    }
}