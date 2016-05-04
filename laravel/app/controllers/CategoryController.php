<?php

use Illuminate\Support\Facades\Input;

class CategoryController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /category
	 *
	 * @return Response
	 */
	public function index()
	{
		//
        return Category::with('Deals')->get();
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /category/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /category
	 *
	 * @return Response
	 */
	public function store()
	{
		//
        $cat = new Category;
        $cat->title = Input::get('title');
        $cat->title_alias = Input::get('title_alias');
        $cat->category_icon = Input::get('category_icon');
        $cat->save();

        return $cat;
	}

	/**
	 * Display the specified resource.
	 * GET /category/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
        $cat = Category::find($id);
        return $cat;
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /category/{id}/edit
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
	 * PUT /category/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
        $cat = Category::find($id);
        $cat->title = Input::get('title', $cat->title);
        $cat->title_alias = Input::get('title_alias', $cat->title_alias);
        $cat->category_icon = Input::get('category_icon', $cat->category_icon);
        $cat->save();

        return $cat;
    }

	/**
	 * Remove the specified resource from storage.
	 * DELETE /category/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}