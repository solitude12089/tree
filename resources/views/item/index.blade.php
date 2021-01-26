@extends('layouts.dashboard',[
'page_title'=>'',
'menu'=>1,
'breadcrumb'=>[
'物件管理' => Request::url()
]
])



@section('style')
@parent
    <link href="/css/datatables.min.css" rel="stylesheet">
@stop


@section('section')




<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">物件管理</h3>
        <div class="box-tools pull-right">
            <a class="btn btn-primary btn-xs"  href="/item/create">新增物件</a>

        </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="row">
            <div class="col-lg-12">
                <table class='table dataTable'>
                    <thead>
                        <tr>
                            <th>名稱</th>
                            <th>狀態</th>
                            <th>最後修改日期</th>
                            <th style="width:80px">QRcode</th>
                            <th style="width:80px">預覽</th>
                            <th style="width:100px"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $key => $item)
                        <tr>
                            <td>{{$item->name}}</td>
                            
                            <td>
                                @if($item->status==1)
                                    <label style="color:green">啟用</label>
                                @else
                                    <label style="color:red">關閉</label>
                                @endif
                            </td>
                            <td>{{$item->updated_at}}</td>
                            <td style="text-align: center">
                                <a href="/item/qrcode/{{$item->id}}"><i class="fa fa-download" aria-hidden="true"></i></a>
                            </td>
                            <td style="text-align: center">
                                <a href="#" onclick="preview('{{$item->uuid}}')"><i class="fa fa-eye" aria-hidden="true"></i></a>
                            </td>
                            <td style="text-align: center">
                                <a href="/item/modify/{{$item->id}}">編輯</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
               
            </div>
            <!-- /.box-body -->

        </div>
    </div>
    <!-- /.box-body -->


     <div class="box-footer">

       
           
               
      
    </div>

</div>


@stop




@section('script')
    <script src="/js/datatables.min.js"></script>
    <script>
         $('.dataTable').dataTable();
        function preview(uuid){
            window.open('{{url('/show/')}}'+'/'+uuid,'mywin','width=450,height=800');
        }
    </script>

@stop