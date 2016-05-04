<?php

class Category extends Eloquent {
    protected $table = 'categories';
	//protected $fillable = [];
    protected $hidden = ['created_at','updated_at'];
    protected $appends = ['deals_count'];

    public function deals() {
        return $this->hasMany('Deal');
    }

    //This is got via a magic method whenever you call $this->likeCount (built into Eloquent by default)
    public function getDealsCountAttribute()
    {
        return $this->deals->count();
    }
}