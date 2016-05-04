<?php

use Illuminate\Support\Facades\Input;
use Teepluss\Cloudinary\Facades\Cloudy;

class DealController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /deal
	 *
	 * @return Response
	 */
	public function index()
	{
		//
        if (Input::has('ids')) {
            return Deal::with('Category')->find(str_split(Input::get('ids')));
        } else
            return Deal::with('Category')->get();
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /deal/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /deal
	 *
	 * @return Response
	 */
	public function store()
	{
		//
        $deal = new Deal;
        $deal->title = Input::get('title');
        $deal->title_alias = Input::get('title_alias');
        $deal->expire_date = Input::get('expire_date');
        $deal->list_price = Input::get('list_price', null);
        $deal->new_price = Input::get('new_price', null);
        $deal->discount = Input::get('discount', null);
        $deal->description = Input::get('description');
        $deal->shop_id = Input::get('shop_id');
        $deal->category_id = Input::get('category_id');
        $deal->issue_id = Input::get('issue_id', 0);
        $deal->size = Input::get('size');
        $deal->save();

        // handle tags
        /*$tags = explode(',', Input::get('deal_tags'));
        foreach ($tags as $tag) {
            $deal->tag($tag);
        }*/

        // handle image
        $public_id = $deal->shop_id . $deal->id . sha1(uniqid(mt_rand(), true));
        if ( Input::get('edit_image') == 1 ) {
            // Get cloudinary uploader
            $uploader = Cloudy::getUploader();
            //$file = Cloudy::upload(Input::get('image_url'), $public_id, Input::get('deal_tags', null));
            $file = $uploader->upload(Input::get('image_url'));
            $photo = new Photo;
            $photo->path = $file['url'];
            //$photo->public_id = $public_id;
            $photo->public_id = $file['public_id'];
            $photo->main = Input::get('main', 1);

            $deal->photos()->save($photo);

        } elseif ( Input::get('edit_image') == 2 ) {
            // Get cloudinary uploader
            $uploader = Cloudy::getUploader();
            //$file = Cloudy::upload(Input::get('image_url'), $deal->shop_id . '_' . $deal->id . sha1(uniqid(mt_rand(), true)), Input::get('deal_tags', null));
            $file = $uploader->upload(Input::get('image_url'));

        }

        return $deal->load('Photos', 'Category');

    }

	/**
	 * Display the specified resource.
	 * GET /deal/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
        return Deal::with('Category')->find($id);
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /deal/{id}/edit
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
	 * PUT /deal/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
        $deal = Deal::find($id);
        $deal->title = Input::get('title', $deal->title);
        $deal->title_alias = Input::get('title_alias', $deal->title_alias);
        $deal->expire_date = Input::get('expire_date', $deal->expire_date);
        $deal->list_price = Input::get('list_price', $deal->list_price);
        $deal->new_price = Input::get('new_price', $deal->new_price);
        $deal->discount = Input::get('discount', $deal->discount);
        $deal->description = Input::get('description', $deal->description);
        $deal->shop_id = Input::get('shop_id', $deal->shop_id);
        $deal->category_id = Input::get('category_id', $deal->category_id);
        $deal->issue_id = Input::get('issue_id', $deal->issue_id);
        $deal->size = Input::get('size', $deal->size);
        $deal->save();

        // handle tags
        /*$tags = explode(',', Input::get('deal_tags'));
        foreach ($tags as $tag) {
            $deal->tag($tag);
        }*/

        // handle image
        //$public_id = $deal->shop_id . $deal->id . sha1(uniqid(mt_rand(), true));
        /*if ( Input::get('edit_image') == 1 ) {
            // Get cloudinary uploader
            $uploader = Cloudy::getUploader();
            //$file = Cloudy::upload(Input::get('image_url'), $public_id, Input::get('deal_tags', null));
            $file = $uploader->upload(Input::get('image_url'));

            if ( $deal->hasPhotos() ) {
                $photo = Photo::where('imageable_id', $deal->id)->where('imageable_type', 'Deal')->first();
                $photo->path = $file['url'];
                $photo->public_id = $file['public_id'];
                //$photo->public_id = $public_id;
                $photo->main = Input::get('main', 1);

                $deal->photos()->save($photo);
            } else {
                $photo = new Photo;
                $photo->path = $file['url'];
                $photo->public_id = $file['public_id'];
                //$photo->public_id = $public_id;
                $photo->main = Input::get('main', 1);

                $deal->photos()->save($photo);
            }

        } elseif ( Input::get('edit_image') == 2 ) {
            // Get cloudinary uploader
            $uploader = Cloudy::getUploader();
            //$file = Cloudy::upload(Input::get('image_url'), $deal->shop_id . '_' . $deal->id . sha1(uniqid(mt_rand(), true)), Input::get('deal_tags', null));
            $file = $uploader->upload(Input::get('image_url'));

        }*/

        return $deal->load('Photos', 'Category');
    }

	/**
	 * Remove the specified resource from storage.
	 * DELETE /deal/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
        return Deal::find($id)->delete();
	}

}