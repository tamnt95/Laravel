<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use App\TinTuc;

use Illuminate\Support\Facades\Auth; // khai báo thư viện này để sử dụng đăng nhập

class CommentController extends Controller
{
	 public function __construct(){ //Khai báo
     $this->tintuc = TinTuc::all();

   }
    public function getXoa($id,$idTinTuc) //B8
    {
    	$comment = Comment::find($id); //tìm loại tin có id = id truyền vào
    	$comment->delete();//xóa comment
    	return redirect('admin/tintuc/sua/'.$idTinTuc)->with('thongbao','Bạn đã xóa comment thành công');
    }

    public function postComment($id,Request $request){
    // dd($request);

    	$idTinTuc = $id;
    	$tintuc = TinTuc::find($id);
    	$comment = new Comment;
    	$comment->idTinTuc = $idTinTuc; //để lưu cmt thì truyền vào idTinTuc
    	$comment->idUser = Auth::user()->id;
    	$comment->NoiDung = $request->noidung;
    	$comment->save();

    	return redirect("tintuc/$id/".$tintuc->TieuDeKhongDau.".html")->with('thongbao','Bạn đã viết bình luận thành công');
    }
}
