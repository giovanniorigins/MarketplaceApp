<?php

use LaravelBook\Ardent\Ardent;
use Nicolaslopezj\Searchable\SearchableTrait;

class Weekly extends Ardent {

    use SearchableTrait;
    protected $table = 'weeklys';
    //protected $fillable = [];
}