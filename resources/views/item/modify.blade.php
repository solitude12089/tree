@extends('layouts.dashboard',[
'page_title'=>'',
'menu'=>1,
'breadcrumb'=>[
'物件管理' => '/item/index',
'修改物件' => Request::url()
]
])



@section('style')
@parent
    
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
        <h3 class="box-title">編輯物件</h3>
    </div>
    <!-- /.box-header -->
    <form id="post_form" action="{{url('/item/modify/'.$item->id)}}"  method="post" enctype="multipart/form">
        <div class="box-body">
            <div class="row">
                <div class="col-lg-12 div_row">
                    <div class="col-lg-2 div_title">
                        <label>名稱<label>
                    </div>
                    <div class="col-lg-10">
                        <input id="name" class="form-control" name="name" value="{{$item->name}}"/>
                    </div>
                </div>

                <div class="col-lg-12 div_row">
                    <div class="col-lg-2 div_title">
                        <label>狀態<label>
                    </div>
                    <div class="col-lg-10">
                        <select  id="status" name="status" class="form-control">
                                
                                <option value="1" {{$item->status=="1"?'selected':''}}>啟用</option>
                                <option value="9" {{$item->status=="9"?'selected':''}}>關閉</option>

                        </select>
                        
                    </div>
                </div>




                <div class="col-lg-12 div_row">
                    <div class="col-lg-2 div_title">
                        <label>內容<label>
                    </div>
                    <div class="col-lg-10">
                        <textarea id="description"  name="description">{{$item->description}}</textarea>
                    </div>
                </div>
                <div class="col-lg-12 div_row">
                    <div style="float :right">
                        <input id="btn_delete" type="button"class="btn btn-danger" value="刪除"/>
                        <button class="btn btn-primary">儲存</button>
                    </div>
                    
                </div>
                <!-- /.box-body -->

            </div>
        </div>
    </form>
    <!-- /.box-body -->


    <div class="box-footer">
        <form id="delete_form" action="{{url('/item/delete/'.$item->id)}}"  method="post" enctype="multipart/form" hidden>
        </form>
       
           
               
      
    </div>

</div>


   

@stop




@section('script')
    <script src="https://cdn.tiny.cloud/1/9s0mmkxa4krv8batthjjbgekfsxw1ci7678ab18ak4ras1k4/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script src="/js/bootstrap-dialog.min.js"></script>
    <script>
        $('#btn_delete').click(function() {
            BootstrapDialog.confirm({
                title: '刪除確認',
                message: '是否刪除該物件??',
                type: BootstrapDialog.TYPE_DANGER, // <-- Default value is BootstrapDialog.TYPE_PRIMARY
                closable: true, // <-- Default value is false
                draggable: true,
                btnCancelLabel: '取消', // <-- Default value is 'Cancel',
                btnOKLabel: '確定', // <-- Default value is 'OK',
                btnOKClass: 'btn-danger', // <-- If you didn't specify it, dialog type will be used,
                callback: function(result) {
                    
                    if(result) {
                        $('#delete_form').submit();
                        
                    }
                }
            });
        });
           
        $( "#post_form" ).submit(function( event ) {
           // event.preventDefault();
            if($('#name').val()==''){
                event.preventDefault();
                alert('請輸入名稱.');
                return;
            }
            if($('#description').val()==''){
                event.preventDefault();
                alert('請輸入內容.');
                return;
            }
           // $( "#post_form" ).submit();
           
        });
       

        tinymce.init({
            selector: '#description',
            plugins: 'image,autoresize',
            language: 'zh_TW',
            toolbar: 'codesample | bold italic sizeselect fontselect fontsizeselect | hr alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | insertfile undo redo | forecolor backcolor emoticons | code',
            images_upload_url: '{{url('/file/upload')}}',
            images_upload_credentials: true,
            file_picker_types: 'image',
            autoresize_bottom_margin: 450,
           
        });
      
    </script>

@stop