<?php

use LaravelBook\Ardent\Ardent;
use Nicolaslopezj\Searchable\SearchableTrait;
use Conner\Tagging\TaggableTrait;

class Coupon extends Ardent {

    use SearchableTrait, TaggableTrait;
    protected $table = 'coupons';
    //protected $fillable = [];
    protected $with = ['Photos', 'Shop'];
    protected $attributes = [
        //'image' => 9,
    ];

    /**
     * Searchable rules.
     *
     * @var array
     */
    protected $searchable = [
        'columns' => [
            'title' => 10,
            'title_alias' => 10,
            'description' => 2,
            'shops.title' => 2,
            'shops.title_alias' => 2,
        ],
        'joins' => [
            'shops' => ['coupons.shop_id','shops.id'],
        ],
    ];

    public static $rules = array(
        /*'title'                  => 'required|between:4,16',
        'title_alias'                 => 'required|email',
        'expire_date'              => 'required|alpha_num|between:4,8|confirmed',
        'new_price' => 'required|alpha_num|between:4,8',*/
    );

    public function category() {
        return $this->belongsTo('Category');
    }

    public function shop() {
        return $this->belongsTo('Shop');
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

    public function avatar() {
        $collection = $this->photos->first();
        return $collection;
    }
}