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
                     <h2 style="margin-top:0px; margin-bottom:0px;">Giới thiệu</h2>
                 </div>

                 <div class="panel-body">
                    <!-- item -->
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

                </div>
            </div>
        </div>
    </div>
    <!-- /.row -->
</div>
<!-- end Page Content -->
@endsection
@section('script')

<script type="text/javascript">
  $("#nameid").select2({
    placeholder: 'Select a Name',
    allowClear: true
});
</script>
@endsection
@section('css')
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
@endsection

