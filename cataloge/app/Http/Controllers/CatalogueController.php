<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Filesystem\Filesystem;

class CatalogueController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
	public function __construct() {}

		///show book information
	//same code of show rwlated book except that for loop with book-1
	public function Showbookdetails($id){
		$file = new \Illuminate\Filesystem\Filesystem();
		$content = $file->get(__DIR__.'/../../books.txt');
		$explodes = explode ("\n",$content);
		if (sizeof($explodes) < 2){
			return response()->json(['Message' => 'We dont have any book in our store.']);
		}
		$Bookinfo;
		$Jdata;
		$found= false;
		for ($i=0 ; $i<sizeof($explodes)-1 ; $i++){
			$Bookinfo[$i] = explode(",",$explodes[$i]);
			if ($Bookinfo[$i][4] == $id){
				$found= true;
				$Jdata['Title'] = $Bookinfo[$i][0];
				$Jdata['numbe of items in stock'] = $Bookinfo[$i][1];
				$Jdata['Cost'] = $Bookinfo[$i][2];
				$Jdata['Topic'] = $Bookinfo[$i][3];
				$Jdata['ID'] = $Bookinfo[$i][4];
			}
		}
		if (!$found){
			return response()->json(['Message' => 'Wrong item number,book does not exist']);
		}
		return response()->json($Jdata);
	}

	//Check store
	public function Checkstore($id){
		$file = new \Illuminate\Filesystem\Filesystem();
		$content = $file->get(__DIR__.'/../../books.txt');
		$books = explode ("\n",$content);
		if (sizeof($books) < 2){
			return response()->json(['Message' => 'No book']);
		}
		$BookInfo;
		$found= false;
		for ($i=0 ; $i<sizeof($books)-1 ; $i++){
			$BookInfo[$i] = explode(",",$books[$i]);
			if ($BookInfo[$i][4] == $id){
				if ($BookInfo[$i][1] < 1){
					return response()->json(['Message' => '0 books']);
				}
				$BookInfo[$i][1]--;
				$BookInfo[$i][1] =$BookInfo[$i][1].""; 
				$found=true;
			}
		}
		if(!$found){
			return response()->json(['Message' => 'Wrong']);
		}
		for ($i=0 ; $i<sizeof($books)-1 ; $i++){ 
			$books[$i] = implode(",",$BookInfo[$i]);
		}
		$content = implode("\n",$books);
		$file->put(__DIR__.'/../../books.txt' , $content,false);
		return response()->json(['Message' => 'Successfuly Done']);
     }

	//show related book
	public function ShowRelbooks($topic){
		$file = new \Illuminate\Filesystem\Filesystem(); // to open books file that has data 
		$content = $file->get(__DIR__.'/../../books.txt'); // we open it 
		$books = explode ("\n",$content);// to put /n between contents
		if (sizeof($books) < 2){ // if size<2 then no book 
			return response()->json(['Message' => 'We dont have books in our store']);
		}
		$Bookinfo;
		$Jdata;
		$found= false;
		$counter = -1;
		for ($i=0 ; $i<4 ; $i++){ // we have 5 entry in books text   
			$Bookinfo[$i] = explode(",",$books[$i]); // for every content in books
			if ($Bookinfo[$i][3] == $topic){ // element number 3 in books.txt is title if it's equal with topic that user put 
				$counter++; // increment counter by 1 			
				$found = true; // it's found
				$Jdata[$counter]['Title']=$Bookinfo[$i][0]; // return title on position 0 on book.txt
				$Jdata[$counter]['item Number'] = $Bookinfo[$i][1]; // Id on position 3 on books.txt
			}
		}
		if (!$found){ // if not found the topic
			return response()->json(['Message' => 'We dont have these Topic in our store.']); // msg to try another topic
		}
		return response()->json($Jdata); // to return response
	}



	

	//buy book by ID  
	public function buyBook($id){
		$file = new \Illuminate\Filesystem\Filesystem();
		$content = $file->get(__DIR__.'/../../books.txt');
		$books = explode ("\n",$content);
		if (sizeof($books) < 2){
			return response()->json(['Message' => 'We dont have books in our store.']);
		}
		$Bookinfo;
		for ($i=0 ; $i<sizeof($books)-1 ; $i++){
			$BookInfo[$i] = explode(",",$books[$i]);
			if ($BookInfo[$i][4] == $id){
				if ($BookInfo[$i][1] < 0){
					return response()->json(["Message"=>'Sorry,Buy Failed']);
				}
				break;
			}
		}
		return response()->json(['Message' => 'Done successfuly buy']);
}
    //
}