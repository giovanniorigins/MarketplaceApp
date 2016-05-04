<?php

use Illuminate\Support\Facades\Input;

class ShopController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /shop
	 *
	 * @return Response
	 */
	public function index()
	{
		//
        if (Input::has('ids')) {
            return Shop::with('Deals.Photos')->find(str_split(Input::get('ids')));
        } else
        return Shop::with('Deals.Photos')->get();
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /shop/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /shop
	 *
	 * @return Response
	 */
	public function store()
	{
		//
        $shop = new Shop;
        $shop->title = Input::get('title');
        $shop->title_alias = Input::get('title_alias');
        $shop->policies = Input::get('policies');
        $shop->summary = Input::get('summary');
        $shop->save();

        if ( Input::get('edit_image') == 1 ) {
            // Get cloudinary uploader
            $uploader = Cloudy::getUploader();
            $file = $uploader->upload(Input::get('image_url'));

            if ( !!count($shop->has('Photos', '>=', 1)->get()) ) {
                $photo = $shop->photos()->first()->photo;
                $photo->path = $file['url'];
                $photo->public_id = $file['public_id'];
                $photo->main = Input::get('main', 1);

                $shop->photos()->updateExistingPivot($photo);
            } else {
                $photo = new Photo;
                $photo->path = $file['url'];
                $photo->public_id = $file['public_id'];
                $photo->main = Input::get('main', 1);

                $shop->photos()->save($photo);
            }

        } elseif ( Input::get('edit_image') == 2 ) {
            // Get cloudinary uploader
            $uploader = Cloudy::getUploader();
            $file = $uploader->upload(Input::get('image_url'));

        }
	}

	/**
	 * Display the specified resource.
	 * GET /shop/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
        return $shop = Shop::with('Deals')->find($id);
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /shop/{id}/edit
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
	 * PUT /shop/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
        $shop = Shop::find($id);
        $shop->title = Input::get('title', $shop->title);
        $shop->title_alias = Input::get('title_alias', $shop->title_alias);
        $shop->policies = Input::get('policies', $shop->policies);
        $shop->summary = Input::get('summary', $shop->summary);
        $shop->save();

        if ( Input::get('edit_image') == 1 ) {
            // Get cloudinary uploader
            $file = Cloudy::upload(Input::get('image_url'));
            if ( $shop->hasPhotos() ) {
                return $photo = Photo::where('imageable_id', $shop->id)->where('imageable_type', 'Shop')->first();
                $photo->path = $file['url'];
                $photo->public_id = $file['public_id'];
                $photo->main = Input::get('main', 1);

                $shop->photos()->updateExistingPivot($photo);
            } else {
                $photo = new Photo;
                $photo->path = $file['url'];
                $photo->public_id = $file['public_id'];
                $photo->main = Input::get('main', 1);

                $shop->photos()->save($photo);
            }

        } elseif ( Input::get('edit_image') == 2 ) {
            // Get cloudinary uploader
            $file = Cloudy::upload(Input::get('image_url'));

        }

        return $shop->load('Photos');
    }

	/**
	 * Remove the specified resource from storage.
	 * DELETE /shop/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}