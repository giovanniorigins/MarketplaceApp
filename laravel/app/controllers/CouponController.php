<?php

use Illuminate\Support\Facades\Input;
use Teepluss\Cloudinary\Facades\Cloudy;

class CouponController extends \BaseController {

    /**
     * Display a listing of the resource.
     * GET /coupon
     *
     * @return Response
     */
    public function index()
    {
        //
        if (Input::has('ids')) {
            return Coupon::with('Category')->find(str_split(Input::get('ids')));
        } else
            return Coupon::with('Category')->get();
    }

    /**
     * Show the form for creating a new resource.
     * GET /coupon/create
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     * POST /coupon
     *
     * @return Response
     */
    public function store()
    {
        //
        $coupon = new Coupon;
        $coupon->title = Input::get('title');
        $coupon->title_alias = Input::get('title_alias');
        $coupon->expire_date = Input::get('expire_date');
        $coupon->is_code = Input::get('is_code', null);
        $coupon->code = Input::get('code', null);
        $coupon->discount = Input::get('discount', null);
        $coupon->description = Input::get('description');
        $coupon->shop_id = Input::get('shop_id');
        $coupon->category_id = Input::get('category_id');
        $coupon->is_percentage = Input::get('is_percentage', 0);
        $coupon->size = Input::get('size');
        $coupon->save();

        // handle tags
        /*$tags = explode(',', Input::get('coupon_tags'));
        foreach ($tags as $tag) {
            $coupon->tag($tag);
        }*/

        // handle image
        $public_id = $coupon->shop_id . $coupon->id . sha1(uniqid(mt_rand(), true));
        if ( Input::get('edit_image') == 1 ) {
            // Get cloudinary uploader
            $uploader = Cloudy::getUploader();
            //$file = Cloudy::upload(Input::get('image_url'), $public_id, Input::get('coupon_tags', null));
            $file = $uploader->upload(Input::get('image_url'));
            $photo = new Photo;
            $photo->path = $file['url'];
            //$photo->public_id = $public_id;
            $photo->public_id = $file['public_id'];
            $photo->main = Input::get('main', 1);

            $coupon->photos()->save($photo);

        } elseif ( Input::get('edit_image') == 2 ) {
            // Get cloudinary uploader
            $uploader = Cloudy::getUploader();
            //$file = Cloudy::upload(Input::get('image_url'), $coupon->shop_id . '_' . $coupon->id . sha1(uniqid(mt_rand(), true)), Input::get('coupon_tags', null));
            $file = $uploader->upload(Input::get('image_url'));

        }

        return $coupon->load('Photos', 'Category');

    }

    /**
     * Display the specified resource.
     * GET /coupon/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
        return Coupon::with('Category')->find($id);
    }

    /**
     * Show the form for editing the specified resource.
     * GET /coupon/{id}/edit
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //

    }

    /**
     * Update the specified resource in storage.
     * PUT /coupon/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        //
        $coupon = Coupon::find($id);
        $coupon->title = Input::get('title', $coupon->title);
        $coupon->title_alias = Input::get('title_alias', $coupon->title_alias);
        $coupon->expire_date = Input::get('expire_date', $coupon->expire_date);
        $coupon->is_code = Input::get('is_code', $coupon->is_code);
        $coupon->code = Input::get('code', $coupon->code);
        $coupon->discount = Input::get('discount', $coupon->discount);
        $coupon->description = Input::get('description', $coupon->description);
        $coupon->shop_id = Input::get('shop_id', $coupon->shop_id);
        $coupon->category_id = Input::get('category_id', $coupon->category_id);
        $coupon->is_percentage = Input::get('is_percentage', $coupon->is_percentage);
        $coupon->size = Input::get('size', $coupon->size);
        $coupon->save();

        // handle tags
        /*$tags = explode(',', Input::get('coupon_tags'));
        foreach ($tags as $tag) {
            $coupon->tag($tag);
        }*/

        // handle image
        //$public_id = $coupon->shop_id . $coupon->id . sha1(uniqid(mt_rand(), true));
        /*if ( Input::get('edit_image') == 1 ) {
            // Get cloudinary uploader
            $uploader = Cloudy::getUploader();
            //$file = Cloudy::upload(Input::get('image_url'), $public_id, Input::get('coupon_tags', null));
            $file = $uploader->upload(Input::get('image_url'));

            if ( $coupon->hasPhotos() ) {
                $photo = Photo::where('imageable_id', $coupon->id)->where('imageable_type', 'Coupon')->first();
                $photo->path = $file['url'];
                $photo->public_id = $file['public_id'];
                //$photo->public_id = $public_id;
                $photo->main = Input::get('main', 1);

                $coupon->photos()->save($photo);
            } else {
                $photo = new Photo;
                $photo->path = $file['url'];
                $photo->public_id = $file['public_id'];
                //$photo->public_id = $public_id;
                $photo->main = Input::get('main', 1);

                $coupon->photos()->save($photo);
            }

        } elseif ( Input::get('edit_image') == 2 ) {
            // Get cloudinary uploader
            $uploader = Cloudy::getUploader();
            //$file = Cloudy::upload(Input::get('image_url'), $coupon->shop_id . '_' . $coupon->id . sha1(uniqid(mt_rand(), true)), Input::get('coupon_tags', null));
            $file = $uploader->upload(Input::get('image_url'));

        }*/

        return $coupon->load('Photos', 'Category');
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /coupon/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
        return Coupon::find($id)->delete();
    }

}