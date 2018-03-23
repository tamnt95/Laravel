<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TheLoai;
use App\LoaiTin;
use App\Comment;
use App\TinTuc;
class LoaiTinController extends Controller
{
	public function getDanhSach()
	{
    	$loaitin = LoaiTin::all();  //luu danh sach cac loaitin lay dc tu model loaitin

    	return view('admin.loaitin.danhsach',['loaitin'=>$loaitin]);
    }
    public function getThem()
    {
    	$theloai = TheLoai::all();
    	return view('admin.loaitin.them',['theloai'=>$theloai]);
    }
    public function postThem(Request $request)
    {
    	$this->validate($request,
    		[
    			'Ten'=>'required|unique:LoaiTin,Ten|min:1|max:100','TheLoai'=>'required'
    		],
    		[
    			'Ten.required'=>'Bạn chưa nhập tên loại tin',
    			'Ten.unique'=>'Tên loại tin đã tồn tại',
    			'Ten.min'=>'Tên loại tin phải có độ dài từ 1->100 ký tự',
    			'Ten.max'=>'Tên loại tin phải có độ dài từ 1->100 ký tự',
    			'TheLoai.required'=>'Bạn chưa chọn thể loại'
    		]
    	);
    	$loaitin = new LoaiTin;
    	$loaitin->Ten = $request->Ten;
    	$loaitin->TenKhongDau = changeTitle($request->Ten);
    	$loaitin->idTheLoai = $request->TheLoai;
    	$loaitin->save();

    	return redirect('admin/loaitin/them')->with('thongbao','Bạn đã thêm thành công');
    }

    public function getSua($id) //B8
    {
    	$theloai = TheLoai::all();
    	$loaitin = LoaiTin::find($id); // Lấy thông tin loai tin cần sửa
    	return view('admin.loaitin.sua',['loaitin'=>$loaitin,'theloai'=>$theloai]);
    }
    public function postSua(Request $request,$id) //B8
    {
    	//check request
    	$this->validate($request,
    		[
    			'Ten'=>'required|unique:LoaiTin,Ten|min:1|max:100','TheLoai'=>'required'
    		],
    		[
    			'Ten.required'=>'Bạn chưa nhập tên loại tin',
    			'Ten.unique'=>'Tên loại tin đã tồn tại',
    			'Ten.min'=>'Tên loại tin phải có độ dài từ 1->100 ký tự',
    			'Ten.max'=>'Tên loại tin phải có độ dài từ 1->100 ký tự',
    			'TheLoai.required'=>'Bạn chưa chọn thể loại'
    		]
    	);
    	$loaitin = LoaiTin::find($id);
    	$loaitin->ten = $request->Ten;
    	$loaitin->TenKhongDau = changeTitle($request->Ten);
    	$loaitin->idTheLoai = $request->TheLoai;
    	$loaitin->save();

    	return redirect('admin/loaitin/sua/'.$id)->with('thongbao','Bạn đã sửa thành công');
    }

    public function getXoa($id) //B8
    {
    	$loaitin = LoaiTin::find($id);//Tìm ra các loại tin với id loại tin truyền vào
        $tintuc = TinTuc::where('idLoaiTin',$loaitin->id)->get();//Tìm ra tin tức thuộc cái loại tin đó
        foreach($tintuc as $tt){//loop tất cả tin tức
            $comment = Comment::where('idTinTuc',$tt->id)->delete(); //Tìm ra comment và xóa tất cả comment thuộc cái tin tức đó
        }
        $tintuc = TinTuc::where('idLoaiTin',$loaitin->id)->delete();//Xóa tất cả các tin tức trong loại tin đó
        $loaitin->delete(); // Xóa loại tin 
    	return redirect('admin/loaitin/danhsach')->with('thongbao','Bạn đã xóa thành công');
    }
}
