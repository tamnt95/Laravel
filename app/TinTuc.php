<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TinTuc extends Model
{
    //Khai bao ten cac bang !
    protected $table = "TinTuc";

    public function loaitin() //liên kết sang bảng loại tin
    {
    	return $this->belongsTo('App\LoaiTin','idLoaiTin','id');
    }

    //trong tintuc lấy ra các comment
    public function comment(){
    	return $this->hasMany('App\Comment','idTinTuc','id');
    }
}
