@extends('layout.index')

@section('content')
<!-- Page Content -->
	<div class="container">

		@include('layout.slide')

		<div class="space20"></div>


		<div class="row main-left">
			@include('layout.menu')

			<div class="col-md-9">
				<div class="panel panel-default">            
					<div class="panel-heading" style="background-color:#337AB7; color:white;" >
						<h2 style="margin-top:0px; margin-bottom:0px;">Laravel Tin Tức</h2>
					</div>

					<div class="panel-body">
						@foreach($theloai as $tl)
							@if(count($tl->loaitin) > 0){{-- Lọc loại tin nếu thể loại mà không có loại tin hay tin gì thì không in nó ra --}}
							<!-- item -->
							<div class="row-item row">
								<h3>
									<a href="category.html">{{$tl->Ten}}</a>|
									@foreach($tl->loaitin as $lt) 
										<small>
											<a href="loaitin/{{$lt->id}}/{{$lt->TenKhongDau}}.html"><i>{{$lt->Ten}}</i></a> / 
										</small>
									@endforeach
								</h3>
								 <?php  
								
								$data = $tl->tintuc->where('NoiBat',1)->sortByDesc('created_at')->take(5);// Lấy ra 5 tin nổi bậc
								// ở model thể loại có function tin tức
								$tin1 = $data->shift(); //hàm shift trong laravel lấy ra 1 tin từ 5 tin và trong data sẽ còn 4 tin để hiển thị bên trái (TRẢ VỀ KIỂU MẢNG)
								?>
								<div class="col-md-8 border-right">
									<div class="col-md-5">
										<a href="tintuc/{{$tin1['id']}}/{{$tin1['TieuDeKhongDau']}}.html">
											<img class="img-responsive" src="upload/tintuc/{{$tin1['Hinh']}}{{-- Đây là mảng nên in ra kiểu này --}}" alt="">
										</a>
									</div>

									<div class="col-md-7">
										<h3>{{$tin1['TieuDe']}}</h3>
										<p>{{$tin1['TomTat']}}</p>
										<a class="btn btn-primary" href="tintuc/{{$tin1['id']}}/{{$tin1['TieuDeKhongDau']}}.html">Xem thêm<span class="glyphicon glyphicon-chevron-right"></span></a>
									</div>

								</div>


								<div class="col-md-4">
									@foreach($data->all() as $tintuc) {{-- Lấy hết 4 thằng nỗi bậc còn lại ở data --}}
										<a href="tintuc/{{$tintuc['id']}}/{{$tintuc['TieuDeKhongDau']}}.html">
											<h4>
												<span class="glyphicon glyphicon-list-alt"></span>
												{{$tintuc['TieuDe']}} {{--Đây là mảng nên in ra kiểu này --}}
											</h4>
										</a>
									@endforeach
								</div>
								
								<div class="break"></div>
							</div>
							@endif
							<!-- end item -->
						@endforeach
					</div>
				</div>
			</div>
		</div>
		<!-- /.row -->
	</div>
<!-- end Page Content -->
@endsection