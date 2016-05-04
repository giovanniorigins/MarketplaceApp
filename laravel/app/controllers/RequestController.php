<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class RequestController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /request
	 *
	 * @return Response
	 */
	public function index()
	{
		//
		return RequestItem::all();
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /request/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /request
	 *
	 * @return Response
	 */
	public function store()
	{
		//
		$req = new RequestItem;
		$req->request = Input::get('request', 'store');
		$req->text = Input::get('text');
		$req->save();
		return $req;
	}

	/**
	 * Display the specified resource.
	 * GET /request/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
		return RequestItem::find($id);
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /request/{id}/edit
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
	 * PUT /request/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /request/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}