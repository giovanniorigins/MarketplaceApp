<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

if ( !Cache::has('categories') ) {
    Cache::add('categories', Category::with('Deals')->get(), 60);
}

$window = json_encode( Config::get('site-conf', array()) );

Route::group(['prefix' => 'api'], function() use ($window) {
    Route::resource('categories', 'CategoryController');
    Route::resource('shops', 'ShopController');
    Route::resource('deals', 'DealController');
    Route::resource('coupons', 'CouponController');
    Route::resource('requests', 'RequestController');
});

Route::get('/', function() use ($window) {
    $categories = Cache::get('categories');
    $deals = Deal::with('Category')->get();
    return View::make('index', ['deals' => $deals, 'categories' => $categories, 'page' => 'homepage', 'window' => $window]);
});

Route::get('/categories', function() use ($window) {
    $categories = Cache::get('categories');
    return View::make('categories', ['categories' => $categories, 'page' => 'shops', 'window' => $window]);
});

Route::get('/category/{title_alias}', function($title_alias) use ($window)
{
    $categories = Cache::get('categories');
    $category = Category::with('Deals')->where('title_alias', $title_alias)->first();
    return View::make('category', ['category' => $category, 'categories' => $categories, 'window' => $window]);
});

Route::get('/shops', function() use ($window) {
    $categories = Cache::get('categories');
    $shops = Shop::with('Deals')->get();
    return View::make('shops', ['shops' => $shops, 'categories' => $categories, 'page' => 'shops', 'window' => $window]);
});

Route::get('/shops/{title_alias}', function($title_alias) use ($window) {
    $categories = Cache::get('categories');
    $shop = Shop::with('Deals.Photos')->where('title_alias', $title_alias)->first();
    return View::make('shop', ['shop' => $shop, 'categories' => $categories, 'window' => $window]);
});

/*Route::get('/api/{title_alias}', function($title_alias) {
    $DSP_DB = 'https://dsp-gorigins.cloud.dreamfactory.com/rest/db';

    $category = cURL::get($DSP_DB . '/categories/'.$title_alias.'?app_name=Marketplace&id_field=title_alias&related=deals_by_category_id%2Cshops_by_deal');
    $shop = cURL::get($DSP_DB . '/shop/'.$title_alias.'?app_name=Marketplace&id_field=title_alias&fields=*&related=deals_by_shop_id%2Cissues_by_shop_id');
    $response = cURL::get($DSP_DB . '/deal?app_name=Marketplace&fields=*&related=shop_by_shop_id%2Ccategories_by_category_id%2Cissues_by_issue_id');
    dd($category->body);
    //print_r(json_decode($response->body)->record);
});*/

Route::get('/404', function() use ($window) {
    $categories = Cache::get('categories');
    return View::make('404', ['window' => $window, 'categories' => $categories]);
});

Route::get('/about-us', function() use ($window) {
    $categories = Cache::get('categories');
    return View::make('about', ['window' => $window, 'categories' => $categories]);

});

Route::get('/contact-us', function() use ($window) {
    $categories = Cache::get('categories');
    return View::make('contact', ['window' => $window, 'categories' => $categories]);

});

Route::group(['prefix' => 'business'], function() use ($window) {

    Route::get('/', function() use ($window) {
        return View::make('business.index', [ 'page' => 'home', 'window' => $window]);
    });

});

Route::post('/search', function() use ($window) {
    $categories = Cache::get('categories');
    //Input::get('search')
    $deals = Deal::search(Input::get('search'))->with('Shop')->get();
    $results = [
        'deals' => $deals,
        //'shops' => $shops
    ];

    return View::make('search', ['window' => $window, 'categories' => $categories, 'results' => $results]);
});

// Add to Mailing List
Route::post('newsletter', function() {
    $member = array(
        'address'     => Input::get('email'),
    );
    return Mailgun::lists()->addMember('newsletter@marketplace.gorigins.com', $member)
        ? Redirect::to('/')->with('message', 'Subscribed')
        : Redirect::to('/')->with('message', 'Subscription Failed');
});

// Item Ratings
Route::get('ratings', function(){
    $rating = Jraty::get(Input::get('item_id'), Input::get('item_type'));
    return json_encode($rating);
});
Route::post('ratings', function(){
    $data = array(
        'item_id'    => Input::get('item_id'),
        'item_type'  => Input::get('item_type'),
        'score'      => Input::get('score'),
        'added_on'   => DB::raw('NOW()'),
        'ip_address' => Request::getClientIp()
    );
    Jraty::add($data);

    return json_encode(Jraty::get(Input::get('item_id'), Input::get('item_type')));
});

// Admin Panel
//Entrust::routeNeedsRole( 'admin*', ['Shop Owner','Administrator'], Response::view('404', ['window' => $window, 'categories' => Cache::get('categories')], 404) );
Route::group(['prefix' => 'admin'], function() use ($window) {

    Route::group(['prefix' => 'api'], function() use ($window) {
        Route::resource('categories', 'CategoryController');
        Route::resource('shops', 'ShopController');
        Route::resource('deals', 'DealController');
        Route::resource('coupons', 'CouponController');

        Route::post('/itemmaster', function () use ($window) {
            $queryStr = str_replace(' ', '+', Input::get('query'));
            $query = 'https://api.itemmaster.com/v2/item?idx=0&limit=50&q=' . $queryStr. '&ef=jpg&epl=600';

            // Get cURL resource
            $curl = curl_init($query);
            // Set some options - we are passing in a useragent too here
            curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                'username: ' . 'jbain',
                'password: ' . 'Chillin31'
            ));
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLINFO_HEADER_OUT, 1);
            curl_setopt_array($curl, array(
                CURLOPT_SSL_VERIFYPEER => true
            ));
            // Send the request & save response to $resp
            $resp = curl_exec($curl);
            // Close request to clear up some resources
            curl_close($curl);

            // Convert XML it JSON Object
            $xml = simplexml_load_string($resp);
            $json = json_encode($xml);
            $array = json_decode($json,TRUE);

            return json_encode($array);
        });
    });
    Route::post('/saveImage', function () use ($window) {
        $name = Input::get('id') . '_' . Input::get('index') . '.jpg';
        $url = 'temp/' . $name;

        // remove the base64 part
        $base64 = preg_replace('#^data:image/[^;]+;base64,#', '', Input::get('image'));
        $base64 = base64_decode($base64);

        $source = imagecreatefromstring($base64); // create
        imagejpeg($source, $url, 100); // save image

        // return URL
        $validation = array (
            'url'     => $url,
            'thumb'   => $url . '?' . sha1(uniqid(mt_rand(), true)),
            'name'    => $name
        );
        return json_encode($validation);
    });

    Route::post ('/downloadImage', function () use ($window) {
        $name = Input::get('id') . '_' . Input::get('index') . '.jpg';
        $url = 'temp/' . $name;

        file_put_contents($url, file_get_contents(Input::get('image')));

        // return URL
        $validation = array (
            'url'     => $url,
            'thumb'   => $url . '?' . sha1(uniqid(mt_rand(), true)),
            'name'    => $name
        );
        return json_encode($validation);
    });

    Route::get('/', function () use ($window) {
        return Response::view('admin.views.index', ['window' => $window], 404);
    });

    Route::any( '{all}', function( ) use ($window){
        return Response::view('admin.views.index', ['window' => $window], 404);
    })->where('all', '.*');


});

//
// Confide RESTful route
Route::get('users/create', 'UsersController@create');
Route::post('users', 'UsersController@store');
Route::get('users/login', 'UsersController@login');
Route::post('users/login', 'UsersController@doLogin');
Route::get('users/confirm/{code}', 'UsersController@confirm');
Route::get('users/forgot_password', 'UsersController@forgotPassword');
Route::post('users/forgot_password', 'UsersController@doForgotPassword');
Route::get('users/reset_password/{token}', 'UsersController@resetPassword');
Route::post('users/reset_password', 'UsersController@doResetPassword');
Route::get('users/logout', 'UsersController@logout');
Route::get('me', function() use ($window) {
    $categories = Cache::get('categories');
    return View::make('account.profile', ['window' => $window, 'categories' => $categories]);
});
Route::group(['prefix' => 'users/{username}'], function($username) use ($window) {
    $categories = Cache::get('categories');
    Route::get('account', function() use ($window, $categories) {
        return View::make('search', ['window' => $window, 'categories' => $categories]);
    });
});

/*Route::get('users/confirm/{code}', 'UsersController@getConfirm');
Route::get('users/reset_password/{token}', 'UsersController@getReset');
Route::get('users/reset_password', 'UsersController@postReset');
Route::resource( 'users', 'UsersController');*/

App::missing(function($exception) use ($window) {
    $categories = Cache::get('categories');
    return Response::view('404', ['window' => $window, 'categories' => $categories], 404);
});