<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
class FrontendController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){}

	public function getBooks($topic){
		$url = 'http://192.168.19.5:8000/query/booktopic/' . $topic;
		$page = file_get_contents($url);
		return response()->json(json_decode($page));
	}

	public function getBook($id){
		$url = 'http://192.168.19.5:8000/query/bookid/' . $id;
		$page = file_get_contents($url);
		return response()->json(json_decode($page));
	}
	
	public function buyBook($id){
		$url = 'http://192.168.19.6:8000/buy/' . $id;
		$page = file_get_contents($url);
		return response()->json(json_decode($page));
	}	
    //
}