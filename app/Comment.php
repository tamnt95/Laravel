<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //Khai bao ten cac bang !
    protected $table = "Comment";

    //Comment thuộc tin tức nào
    public function tintuc(){
    	return $this->belongsTo('App\TinTuc','idTinTuc','id');
    }

    //Comment thuộc user nào ()
    public function user(){//function user là gọi đến model user
    	return $this->belongsTo('App\User','idUser','id');
    }
}
