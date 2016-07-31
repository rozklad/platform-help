<?php namespace Sanatorium\Help\Controllers\Frontend;

use Platform\Foundation\Controllers\Controller;

class HelpsController extends Controller {

	/**
	 * Return the main view.
	 *
	 * @return \Illuminate\View\View
	 */
	public function index()
	{
		return view('sanatorium/help::index');
	}

}
