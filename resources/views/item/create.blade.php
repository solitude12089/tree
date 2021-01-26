@extends('layouts.dashboard',[
'page_title'=>'',
'menu'=>1,
'breadcrumb'=>[
'物件管理' => '/item/index',
'建立物件' => '/item/create'
]
])



@section('style')
@parent
    <link href="/css/datatables.min.css" rel="stylesheet">
    <link href="/css/bootstrap-dialog.min.css" rel="stylesheet">



    <style>
        .div_title{
            text-align: center;
        }
        .div_title > label{
            font-size: 20px;
        }
        .div_row{
            margin: 20px 10px;
        }
    </style>
@stop


@section('section')




<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">建立物件</h3>
    </div>
    <!-- /.box-header -->
    <form id="post_form" action="{{url('/item/create')}}"  method="post" enctype="multipart/form">
        <div class="box-body">
            <div class="row">
                <div class="col-lg-12 div_row">
                    <div class="col-lg-2 div_title">
                        <label>名稱<label>
                    </div>
                    <div class="col-lg-10">
                        <input id="name" class="form-control" name="name" />
                    </div>
                </div>
                <div class="col-lg-12 div_row">
                    <div class="col-lg-2 div_title">
                        <label>內容<label>
                    </div>
                    <div class="col-lg-10">
                        <textarea id="description"  name="description"></textarea>
                    </div>
                </div>
                <div class="col-lg-12 div_row">
                    <div style="float :right">
                        <button class="btn btn-primary">儲存</button>
                    </div>
                </div>
                <!-- /.box-body -->

            </div>
        </div>
    </from>
    <!-- /.box-body -->


     <div class="box-footer">

       
           
               
      
    </div>

</div>


   

@stop




@section('script')
    <script src="https://cdn.tiny.cloud/1/9s0mmkxa4krv8batthjjbgekfsxw1ci7678ab18ak4ras1k4/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
         tinymce.init({
            selector: '#description',
            plugins: 'image,autoresize',
            toolbar: 'codesample | bold italic sizeselect fontselect fontsizeselect | hr alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | insertfile undo redo | forecolor backcolor emoticons | code',
            language: 'zh_TW',
            images_upload_url: '{{url('/file/upload')}}',
            images_upload_credentials: true,
            file_picker_types: 'image',
            autoresize_bottom_margin: 450,
           
        });

      
        $( "#post_form" ).submit(function( event ) {
           // event.preventDefault();
            if($('#name').val()==''){
                event.preventDefault();
                alert('請輸入名稱.');
                return;
            }
            if(tinymce.activeEditor.getContent()==''){
                event.preventDefault();
                alert('請輸入內容.');
                return;
            }
           // $( "#post_form" ).submit();
           
        });
       

       
    
      
    </script>

@stop