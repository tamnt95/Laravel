<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\TheLoai;
use App\LoaiTin;
use App\TinTuc;
use App\Slide;
use App\Comment;
use App\User;
use DB;

use Illuminate\Support\Facades\Auth; // khai báo thư viện này để sử dụng đăng nhập
class PagesController extends Controller
{
	private $slide; 
	private $theloai; //Khai báo property để sử dụng view share
	public function __construct(){ 
		$this->slide = Slide::all();
		$this->theloai = TheLoai::all();
		View()->share('theloai',$this->theloai);
		View()->share('slide',$this->slide);
	}

	function trangchu(){
		return view('pages.trangchu');
	}
	function lienhe(){
		return view('pages.lienhe');
	}
    function loaitin($id){ //truyền biến id ở route
    	$loaitin = LoaiTin::find($id);
    	$tintuc = TinTuc::where('idLoaiTin',$id)->paginate(5); //Tìm tất cả tin tức có id = id Loại Tin tìm về và sử dụng phân trang
    	return view('pages.loaitin',['loaitin'=>$loaitin,'tintuc'=>$tintuc]);
    }
    function tintuc($id){
    	$tintuc = TinTuc::find($id);
        // $comment = Comment::where('idTinTuc',$id)->paginate();
    	$comment = Comment::paginate(3);
        $tinnoibat = TinTuc::where('NoiBat',1)->take(4)->get();	//Lấy ra 5 tin nỗi bật
        $tinlienquan = TinTuc::where('idLoaiTin',$tintuc->idLoaiTin)->take(4)->get();//Tin lieen quan cùng nằm trong 1 loại tin nên tìm ra các tin tức có idLoaiTin = $tintuc idLoaiTin mà mình lấy được

        return view('pages.tintuc',compact('tintuc','tinnoibat','tinlienquan','comment'));
    }
    function getDangnhap(){
    	return view('pages.dangnhap');
    }
    function postDangnhap(Request $request){
    	$this->validate($request,[
    		'email'=>'required',
    		'password' => 'required|min:3|max:32',
    	],[
    		'email.required'=> ' Bạn chưa nhập Email',
    		'password.required'=>'Bạn chưa nhập mật khẩu',
    		'password.min'=>'Mật khẩu có ít nhất 3 kí tự',
    		'password.max'=>'Mật khẩu có nhiều nhất 32 kí tự',
    	]);
    	if(Auth::attempt(['email'=>$request->email,'password'=>$request->password])){
    		return redirect('trangchu');
    	}
    	else
    	{
    		return redirect('dangnhap')->with('thongbao','Đăng nhập không thành công');
    	}
    }
    function getDangxuat(){
    	Auth::logout();
    	return redirect('trangchu');
    }



    function getNguoidung(){
        if(Auth::check()) // check nguoi dung da dang nhap chua, neu chua dang nhap thi tra ve trang dang nhap
        return view('pages.nguoidung',['user' => Auth::user()]);
        else
        	return redirect('dangnhap')->with('thongbao','Bạn chưa Đăng Nhập!');
    }
    function postNguoidung(Request $request)
    {
    	$this->validate($request,
    		[
    			'name' => 'required|min:3',
    		],
    		[
    			'name.required'=>'Bạn chưa nhập họ tên người dùng',
    			'name.min'=>'Tên người dùng phải có ít nhất 3 kí tự',
    		]);
    	$user = Auth::user();
    	$user->name = $request->name;

    	if($request->changePassword == "on")
    	{
    		$this->validate($request,
    			[
    				'password' => 'required|min:3|max:32',
    				'passwordAgain' => 'required|same:password',
    			],
    			[
    				'password.required'=>'Bạn chưa nhập mật khẩu',
    				'password.min'=>'Mật khẩu có ít nhất 3 kí tự',
    				'password.max'=>'Mật khẩu có nhiều nhất 32 kí tự',
    				'passwordAgain.required'=>'Bạn chưa nhập lại mật khẩu',
    				'passwordAgain.same'=>'Mật khẩu chưa chính xác',
    			]);
    		$user->password ==  bcrypt($request->password);
    	}
    	$user->save();
    	return redirect('nguoidung')->with('thongbao','Sửa thành công');
    }

    function getGioithieu(){
        $data = DB::table('loaitin')->get(); //get data from table
        return view('pages.gioithieu',compact('data')); //sent data to view



    	// return view('pages.gioithieu'); // sử dụng view share 
    	// return view('pages.gioithieu',['slide'=>$this->slide,'theloai'=>$this->theloai]); //Không sử dụng View()->share('slide',$this->slide); thì cần dùng thể này để trỏ vào truyền giá trị đi
    }

    function getDangky(){
    	return view('pages.dangky');
    }
    function postDangky(Request $request){
    	$this->validate($request,[
    		'name' => 'required|min:3',
    		'email' => 'required|email|unique:users,email', //Ở unipue chú ý unique:users phải trùng với users trong sql
    		'password' => 'required|min:3|max:32',
    		'passwordAgain' => 'required|same:password',
    	],[
    		'name.required'=>'Bạn chưa nhập họ tên người dùng',
    		'name.min'=>'Tên người dùng phải có ít nhất 3 kí tự',
    		'emai.required'=>'Bạn chưa nhập Email',
    		'email.email'=>'Bạn chưa nhập đúng cấu trúc Email',
    		'email.unique'=>'Email này đã tồn tại',
    		'password.required'=>'Bạn chưa nhập mật khẩu',
    		'password.min'=>'Mật khẩu có ít nhất 3 kí tự',
    		'password.max'=>'Mật khẩu có nhiều nhất 32 kí tự',
    		'passwordAgain.required'=>'Bạn chưa nhập lại mật khẩu',
    		'passwordAgain.same'=>'Mật khẩu chưa chính xác',
    	]);
    	$user = new User;
    	$user->name = $request->name;
    	$user->email = $request->email;
    	$user->password = bcrypt($request->password);
    	$user->quyen = 0;
    	// $user->passwordAgain = bcrypt($request->passwordAgain);

    	$user->save();
    	return redirect('dangky')->with('thongbao','Bạn đã đăng ký thành công');
    }

    function getTimKiem(Request $request){
    	$tukhoa = $request->tukhoa;
    	$tukhoa=$request->get('tukhoa');
    	$tintuc = TinTuc::where('TieuDe','like','%'.$tukhoa.'%')->orWhere('TomTat','like','%'.$tukhoa.'%')->orWhere('NoiDung','like','%'.$tukhoa.'%')->paginate(5);
    	return view('pages.timkiem',['tukhoa'=>$tukhoa,'tintuc'=>$tintuc]);
    }

}
