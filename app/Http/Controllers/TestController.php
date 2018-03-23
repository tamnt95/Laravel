<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use App\TheLoai;
use App\LoaiTin;


class TestController extends Controller
{
    
    private $slide; 
	private $theloai; //Khai báo property để sử dụng view share
	public function __construct(){ 
		$this->loaitin = LoaiTin::all();
		$this->theloai = TheLoai::all();
		View()->share('theloai',$this->theloai);
		View()->share('loaitin',$this->loaitin);
	}
    public function testfunction(){

    	return view('pages.selectview');
    	
    	// $data = DB::table('loaitin')->get();//get data from table
    	// $data1= DB::table('theloai')->get();
    	// return view('pages.selectview',compact('data','data1')); //sent data to view

    }
}
