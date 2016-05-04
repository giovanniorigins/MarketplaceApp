<?php namespace Acme\Helpers;
use Config;

class JSHelper {
    public function __toString()
    {
        return json_encode( Config::get('site-conf', array()) );
    }
}