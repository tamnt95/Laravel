<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TheLoai extends Model
{
    //Khai bao ten cac bang !
    protected $table = "TheLoai";

    public function loaitin() //function nay lay ra tat ca thang loaitin cua thang The Loai nay
    {
    	return $this->hasMany('App\LoaiTin','idTheLoai','id'); //liên kết 1 thể loại có nhiều loại tin
    }
    // Lấy hết các tin tức trong thể loại
    public function tintuc(){
    	return $this->hasManyThrough('App\TinTuc','App\LoaiTin','idTheLoai','idLoaiTin','id'); //Từ Tin Tuc sẽ truy vẫn sang loại tin (đây là thằng trung gian)
    }
}
