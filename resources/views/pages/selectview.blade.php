<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
	<style type="text/css" media="screen">
	.select2-container--default .select2-results__option[aria-disabled=true] {
		font-family: ROBOTO;
    	font-size: 25px;
    	font-weight: bold;
    	color: #e70a0a;
	}
	.select2-results__option[aria-selected] {
		padding-left: 2em;
	}
	</style>

</head>
<body>
	<center>
		<h1>Laravel select dropbox using select2</h1>
		<span>Name: </span>

		<select id="nameid" style="width: 300px"  class="select2" {{-- multiple="multiple" --}}>
			<option></option>
			@foreach($theloai as $d1)
				@if(count($d1->loaitin) > 0) {{-- Lay ra danh sach loai tin trong the loai && Kiem tra the loai co loai tin khong ! Co thi in ra --}}
					<option disabled="disabled" >{{$d1->Ten}}</option>  {{-- <option disabled="disabled" > để không cho người dùng chọn được thể loại mà chỉ chọn được loại tin --}}
					@foreach($d1->loaitin as $d)
						<option>{{$d->Ten}}</option>
					@endforeach
				@endif
			@endforeach
		</select>
	</center>
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

	<script type="text/javascript">
		  $("#nameid").select2({
            placeholder: 'Select a Name',
            allowClear: true
            // minimumResultsForSearch: Infinity
        });
	</script>
</body>
</html>