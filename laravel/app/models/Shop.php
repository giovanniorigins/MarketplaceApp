<?php

use LaravelBook\Ardent\Ardent;
use Nicolaslopezj\Searchable\SearchableTrait;

class Shop extends Eloquent {

    use SearchableTrait;

    protected $table = 'shops';
    protected $hidden = ['created_at','updated_at'];
	//protected $fillable = [];
    protected $with = ['Photos', 'Locations'];
    protected $appends = ['rating'];

    /**
     * Searchable rules.
     *
     * @var array
     */
    protected $searchable = [
        'columns' => [
            'first_name' => 10,
            'last_name' => 10,
            'bio' => 2,
            'email' => 5,
            'posts.title' => 2,
            'posts.body' => 1,
        ],
        'joins' => [
            'posts' => ['users.id','posts.user_id'],
        ],
    ];

    public function deals() {
        return $this->hasMany('Deal');
    }

    public function coupons() {
        return $this->hasMany('Coupon');
    }

    public function locations() {
        return $this->hasMany('Location');
    }

    public function getRatingAttribute() {
        return Jraty::get($this->id, 'Shop');
    }

    public function photos() {
        return $this->morphMany('Photo', 'imageable');
    }

    public function hasPhotos() {
        $check = $this->where('id', $this->id)->whereHas('Photos', function ($q) {
            $q->where('imageable_id', $this->id);
        })->get();
        return !!count($check);
    }

    public function hasMainPhoto() {
        $check = $this->where('id', $this->id)->whereHas('Photos', function ($q) {
            $q->where('imageable_id', $this->id)->where('main', 1);
        })->get();
        return !!count($check);
    }
}