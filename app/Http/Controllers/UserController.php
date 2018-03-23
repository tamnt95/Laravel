<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // khai báo thư viện này để sử dụng đăng nhập
use App\User;
use App\Comment;


class UserController extends Controller
{
	public function getDanhSach()
	{
		$user = User::all();
		return view('admin.user.danhsach',['user'=>$user]);
	}

	public function getThem()
	{
		return view('admin.user.them');
	}

	public function postThem(Request $request)
	{
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
    	// $user->passwordAgain = bcrypt($request->passwordAgain);
		$user->quyen = $request->quyen;


		$user->save();
		return redirect('admin/user/them')->with('thongbao','Thêm thành công');
	}

	public function getSua($id){
	    $user = User::find($id);//tìm user có id truyền vào
	    return view('admin.user.sua',['user'=>$user]);
	}
	public function postSua(Request $request,$id)
	{
		$this->validate($request,[
			'name' => 'required|min:3',
		],[
			'name.required'=>'Bạn chưa nhập họ tên người dùng',
			'name.min'=>'Tên người dùng phải có ít nhất 3 kí tự',
		]);
		$user = User::find($id);
		$user->name = $request->name;
		$user->quyen = $request->quyen;


		if($request->changePassword == "on")
		{
			$this->validate($request,[
				'password' => 'required|min:3|max:32',
				'passwordAgain' => 'required|same:password',
			],[
				'password.required'=>'Bạn chưa nhập mật khẩu',
				'password.min'=>'Mật khẩu có ít nhất 3 kí tự',
				'password.max'=>'Mật khẩu có nhiều nhất 32 kí tự',
				'passwordAgain.required'=>'Bạn chưa nhập lại mật khẩu',
				'passwordAgain.same'=>'Mật khẩu chưa chính xác',
			]);
			$user->password = bcrypt($request->password);
	    	// $user->passwordAgain = bcrypt($request->passwordAgain);
		}

		$user->save();
		return redirect('admin/user/sua/'.$id)->with('thongbao','Sửa thành công');
	}

	public function getXoa($id)
	{
		$user = User::find($id);
	    $comment = Comment::where('idUser',$id); //Tìm các comment của user
	    $comment->delete(); //Xóa các comment của user
	    $user->delete(); //Xóa user
	    return redirect('admin/user/danhsach')->with('thongbao','Xóa tài khoản thành công');
	}

	public function getdangnhapAdmin(){
		return view('admin.login');
	}

	public function postdangnhapAdmin(Request $request)
	{
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
			return redirect('admin/theloai/danhsach');
		}
		else
		{
			return redirect('admin/dangnhap')->with('thongbao','Đăng nhập không thành công');
		}
	}
	public function getDangXuatAdmin()
	{
		Auth::logout();
		return redirect('admin/dangnhap');
	}
}
