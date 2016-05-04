<?php

return array(
    'site_name' => 'Marketplace',
    'currentURL' => URL::current(),
    'fullURL' => URL::full(),
    'siteUrl' => URL::to("/"),
    'apiURL' => URL::to("api"),
    'assetURL' => URL::to("assets"),
    'csrf_token' => csrf_token(),
    'user' => Confide::user()
);