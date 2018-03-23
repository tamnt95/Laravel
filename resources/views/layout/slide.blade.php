

		<!-- slider -->
		<div class="row carousel-holder">
			<div class="col-md-12">
				<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
					<ol class="carousel-indicators">
						<?php $i=0; ?> {{-- Tạo biến đếm i để số slide tăng dần mỗi một vòng lặp thì cho biến $i tăng lên 1 đơn vị --}}
						@foreach($slide as $sl) {{--  Lấy biến slide từ viewshare về --}}
						<li data-target="#carousel-example-generic" data-slide-to="{{$i}}"
						@if($i == 0) {{-- Để cái li đầu tiên có class active thì dùng if để in cái li đầu tiên có class active ra--}}
						 	class="active"
						@endif

						></li>
						@endforeach
						<?php $i++; ?>
					</ol>
					<div class="carousel-inner">
						<?php $i=0; ?>
						@foreach($slide as $sl)
							<div 
							@if($i == 0)
								class="item active"
							@else 
								class="item"
							@endif
							>
							<?php $i++; ?>
								<img class="slide-image" {{-- style="width: 800px; height="300px;" --}} " src="upload/slide/{{$sl->Hinh}}" alt="{{$sl->NoiDung}}">
							</div>
						@endforeach
					</div>
					<a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
						<span class="glyphicon glyphicon-chevron-left"></span>
					</a>
					<a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
						<span class="glyphicon glyphicon-chevron-right"></span>
					</a>
				</div>
			</div>
		</div>
		<!-- end slide -->