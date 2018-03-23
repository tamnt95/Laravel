<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TheLoai;
use App\TinTuc;
use App\LoaiTin;
use App\Comment;

class TinTucController extends Controller
{
	public function getDanhSach()
	{
   $tintuc = TinTuc::orderBy('id','DESC')->get();
   return view('admin.tintuc.danhsach',['tintuc'=>$tintuc]);
 }
 public function getThem()
 {
  $theloai = TheLoai::all();
  $loaitin = LoaiTin::all();
  return view('admin.tintuc.them',['theloai'=>$theloai,'loaitin'=>$loaitin]); 
}
public function postThem(Request $request)

{
 $this->validate($request,[
  'LoaiTin'=>'required',
  'TieuDe'=>'required|min:3|unique:TinTuc,TieuDe',
  'TomTat'=>'required',
  'NoiDung'=>'required',
],[
  'LoaiTin.required'=>'Bạn chưa chọn loại tin',
  'TieuDe.required'=>'Bạn chưa nhâp tiêu đề',
  'TieuDe.min'=>'Tiêu đề phải có ít nhất 3 kí tự',
  'TieuDe.unique'=>'Tiêu đề đã tồn tại',
  'TomTat.required'=>'Bạn chưa nhập tóm tắt',
  'NoiDung.required'=>'Bạn chưa nhập nội dung'
]);

 $tintuc = new TinTuc;
 $tintuc->TieuDe = $request->TieuDe;
 $tintuc->TieuDeKhongDau = changeTitle($request->TieuDe);
 $tintuc->idLoaiTin = $request->LoaiTin;
 $tintuc->TomTat = $request->TomTat;
 $tintuc->NoiDung = $request->NoiDung;
 $tintuc->SoLuotXem = 0;


 if($request->hasFile('Hinh'))
 {
  $file = $request->file('Hinh');
        $duoi = $file->getClientOriginalExtension();//Kiểm tra đuôi up ảnh lên có đúng định dạng không
        
        
        if($duoi != 'jpg' && $duoi != 'png' && $duoi != 'jpeg') // != khác
        {
          return redirect('admin/tintuc/them')->with('thongbao','Bạn chỉ được chọn file có đuôi jpg,png,jpeg');
        }
        //Kiểm tra hình đã tồn tại chưa
        $name = $file->getClientOriginalName();
        $Hinh = str_random(4)."_". $name;
        while(file_exists("upload/tintuc".$Hinh)) //check trường hợp trên random cũng ra trùng ảnh thì random thêm lần nữa đến khi hết trùng
        {
          $Hinh = str_random(4)."_". $name;
        }
        $file->move("upload/tintuc",$Hinh);
        $tintuc->Hinh = $Hinh;
      }
      else
      {
        $tintuc->Hinh = "";
      }
      $tintuc->save();

      return redirect('admin/tintuc/them')->with('thongbao','Thêm tin thành công');
    }

    public function getSua($id) //B16
    {
      $theloai = TheLoai::all();
      $loaitin = LoaiTin::all();
      $tintuc = TinTuc::find($id);
      return view('admin.tintuc.sua',['tintuc'=>$tintuc,'theloai'=>$theloai,'loaitin'=>$loaitin]);
    }
    public function postSua(Request $request,$id) //B16
    {
    	$tintuc = TinTuc::find($id);
      $this->validate($request,[
        'LoaiTin'=>'required',
        'TieuDe'=>'required|min:3|unique:TinTuc,TieuDe',
        'TomTat'=>'required',
        'NoiDung'=>'required',
      ],[
        'LoaiTin.required'=>'Bạn chưa chọn loại tin',
        'TieuDe.required'=>'Bạn chưa nhâp tiêu đề',
        'TieuDe.min'=>'Tiêu đề phải có ít nhất 3 kí tự',
        'TieuDe.unique'=>'Tiêu đề đã tồn tại',
        'TomTat.required'=>'Bạn chưa nhập tóm tắt',
        'NoiDung.required'=>'Bạn chưa nhập nội dung',
      ]);
      $tintuc->TieuDe = $request->TieuDe;
      $tintuc->TieuDeKhongDau = changeTitle($request->TieuDe);
      $tintuc->idLoaiTin = $request->LoaiTin;
      $tintuc->TomTat = $request->TomTat;
      $tintuc->NoiDung = $request->NoiDung;

      if($request->hasFile('Hinh'))
      {
        $file = $request->file('Hinh');
            $duoi = $file->getClientOriginalExtension();//Kiểm tra đuôi up ảnh lên có đúng định dạng không
            if($duoi != 'jpg' && $duoi != 'png' && $duoi != 'jpeg') // != khác
            {
              return redirect('admin/tintuc/them')->with('thongbao','Bạn chỉ được chọn file có đuôi jpg,png,jpeg');
            }
            //Kiểm tra hình đã tồn tại chưa
            $name = $file->getClientOriginalName();
            $Hinh = str_random(4)."_". $name;
            while(file_exists("upload/tintuc".$Hinh)) //check trường hợp trên random cũng ra trùng ảnh thì random thêm lần nữa đến khi hết trùng
            {
              $Hinh = str_random(4)."_". $name;
            }
            $file->move("upload/tintuc",$Hinh);
            if($tintuc->Hinh){
              @unlink("public/upload/tintuc/".$tintuc->Hinh);
            }
            $tintuc->Hinh = $Hinh;
          }
          $tintuc->save();
          return redirect()->back()->with('thongbao','Sửa thành công');
        }

    public function getXoa($id) //B8
    {
    	$tintuc = TinTuc::find($id); //Tìm ra các loại tin với id loại tin truyền vào
      $comment = Comment::where('idTinTuc',$tintuc->id)->delete(); //Tìm ra comment và xóa tất cả comment thuộc cái tin tức đó
      $tintuc->delete();//xóa tin tức
      return redirect('admin/tintuc/danhsach')->with('thongbao','Xóa thành công');
    }


  }
