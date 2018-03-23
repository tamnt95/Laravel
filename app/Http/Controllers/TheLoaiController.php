<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TheLoai;
use App\LoaiTin;
use App\TinTuc;
use App\comment;

class TheLoaiController extends Controller
{
	public function getDanhSach()
	{
    	$theloai = TheLoai::all();  //luu danh sach cac the loai lay dc tu model theloai
    	return view('admin.theloai.danhsach',['theloai'=>$theloai]);
    }
    public function getThem()
    {
    	return view('admin.theloai.them');
    }
    public function postThem(Request $request)
    {
    	$this->validate($request,['Ten' => 'required|min:3|max:100|unique:TheLoai,Ten'],[
    		'Ten.required'=>'Bạn chưa nhập tên thể loại',
    		'Ten.min'=>'Tên thể loại phải có độ dài từ 3 đến 100 ký tự',
    		'Ten.max'=>'Tên thể loại phải có độ dài từ 3 đến 100 ký tự',
    		'Ten.unique' => 'Tên thể loại đã tồn tại',
    	]);
    	$theloai = new TheLoai;
    	$theloai->Ten = $request->Ten;
    	$theloai->TenKhongDau = changeTitle($request->Ten);
    	$theloai->save();
    	return redirect('admin/theloai/them')->with('thongbao','Thêm Thành Công');
    }

    public function getSua($id) //B8
    {
    	$theloai = TheLoai::find($id); //khi nhận id ở getSua($id) thì tìm thể loại id
    	//dd($theloai);

    	return view('admin.theloai.sua',['theloai'=>$theloai]); // tìm xong thì truyền thông tin thể loại sang trang sửa
    }
    public function postSua(Request $request,$id) //B8
    {
    	$theloai = TheLoai::find($id);
    	$this->validate($request,
    		[
    			'Ten' => 'required|unique:TheLoai,Ten|min:3|max:100'
    		],
    		[
    			'Ten.required' => 'Bạn chưa nhập tên thể loại',
    			'Ten.unique' => 'Tên thể loại đã tồn tại',
    			'Ten.min'=>'Tên thể loại phải có độ dài từ 3 đến 100 ký tự',
    			'Ten.max'=>'Tên thể loại phải có độ dài từ 3 đến 100 ký tự',
    		]
    	);
    	$theloai->Ten = $request->Ten;
    	$theloai->TenKhongDau = changeTitle($request->Ten);
    	$theloai->save();
    	return redirect('admin/theloai/sua/'.$id)->with('thongbao','Sửa thành công');
    }

    public function getXoa($id) //B8
    {

        $theloai = TheLoai::find($id);//Tìm ra các id thể loại
        $loaitin=LoaiTin::where('idTheLoai',$theloai->id)->get();//tìm tất cả loại tin thuộc thể loại đó
        foreach($loaitin as $lt){ //loop tất cả loại tin
            $tintuc = TinTuc::where('idLoaiTin',$lt->id)->get();//Tìm ra tin tức thuộc cái loại tin đó
            foreach($tintuc as $tt){//loop tất cả tin tức
                $comment = Comment::where('idTinTuc',$tt->id)->delete(); //Tìm ra comment và xóa tất cả comment thuộc cái tin tức đó
            }
            $tintuc = TinTuc::where('idLoaiTin',$lt->id)->delete();//Xóa tất cả các tin tức trong loại tin đó
        }
        $loaitin=LoaiTin::where('idTheLoai',$theloai->id)->delete();//Xóa tất cả các loại tin trong thể loại đó
        $theloai->delete(); // Xóa thể loại cần xóa
        return redirect('admin/theloai/danhsach')->with('thongbao','Bạn đã xóa thành công');
    }


}
