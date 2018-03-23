<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoaiTin extends Model
{
    //Khai bao ten cac bang !
    protected $table = "LoaiTin";

    public function theloai() //liên kết loai tin thể loại vì để biết loại tin thuộc thể loại nào
    {
    	return $this->belongsTo('App\TheLoai','idTheLoai','id');  //Loại tin thuộc cái thể loại nào đó
    }

    public function tintuc() //Trong loại tin có bao nhiêu tin tức
    {
    	return $this->hasMany('App\TinTuc','idLoaiTin','id'); //Loại tin có bao nhiêu tin tức (lưu ý id là trong bảng loaitin)
    }
}
