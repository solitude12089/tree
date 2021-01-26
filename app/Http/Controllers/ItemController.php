<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;
use Auth;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\LabelAlignment;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Response\QrCodeResponse;

class ItemController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
   
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $trees = \App\models\Tree::all();
        // $rt = Storage::disk('gcs')->put('123.txt','Google file','public');
        // dd($rt);
        return view('item.index',['items' => $trees]);
    }
    public function create(){
        return view('item.create');
    }

    public function p_create(Request $request){
        try{

            $user = Auth::user();
            $data=$request->all();
            if(!isset($data['name']) || $data['name']==''){
                throw new \Exception('請輸入名稱.');
            }
            if(!isset($data['description']) || $data['description']==''){
                throw new \Exception('請輸入內容.');
            }
            $n_tree = new \App\models\Tree;
            $n_tree->name = $data['name'];
            $n_tree->description = $data['description'];
            $n_tree->user_id = $user->id;
            $n_tree->status = 1;
            $n_tree->uuid =  md5(uniqid(rand()));
            $n_tree->save();
    
            return redirect('item/index')->with('alert-success', '建立成功.');
        }
        catch(\Exception $e){
            return redirect('item/index')->with('alert-danger', $e->getMessage());
        }
      
    }

    public function modify($tree_id){
        $tree = \App\models\Tree::where('id',$tree_id)->first();
        return view('item.modify',['item' => $tree]);
    }

    public function p_modify(Request $request,$tree_id){
        try{
            $data = $request->all();
            $user = Auth::user();
        
            if(!isset($data['name']) || $data['name']==''){
                throw new \Exception('請輸入名稱.');
            }
            if(!isset($data['description']) || $data['description']==''){
                throw new \Exception('請輸入內容.');
            }
            $o_tree =  \App\models\Tree::where('id',$tree_id)->first();
            if($o_tree==null){
                throw new \Exception('找不到物件資料.');
            }
            $o_tree->name = $data['name'];
            $o_tree->description = $data['description'];
            $o_tree->user_id = $user->id;
            $o_tree->status = $data['status'];
            $o_tree->save();
            
            return redirect('item/index')->with('alert-success', '修改成功.');
        }
        catch(\Exception $e){
            return redirect('item/index')->with('alert-danger', $e->getMessage());
        }
    }

    public function p_delete($item_id){
        $item = \App\models\Tree::where('id',$item_id)->first();
        if($item==null){
            return redirect('item/index')->with('alert-danger', '刪除失敗,找不到物件內容.');
        }
        else{
            $item->delete();
            return redirect('item/index')->with('alert-success', '刪除成功.');
        }
    }

    public function qrcode($tree_id){
        $tree = \App\models\Tree::where('id',$tree_id)->first();
        if($tree==null){
            dd('err');
        }

      
        // Create a basic QR code
        $qrCode = new QrCode(url('/show/'.$tree->uuid));
        $qrCode->setSize(300);
        $qrCode->setMargin(10); 
        // Set advanced options
        $qrCode->setWriterByName('png');
        $qrCode->setEncoding('UTF-8');
        $qrCode->setValidateResult(false);
        
        // Round block sizes to improve readability and make the blocks sharper in pixel based outputs (like png).
        // There are three approaches:
        $qrCode->setRoundBlockSize(true, QrCode::ROUND_BLOCK_SIZE_MODE_MARGIN); // The size of the qr code is shrinked, if necessary, but the size of the final image remains unchanged due to additional margin being added (default)
        $qrCode->setRoundBlockSize(true, QrCode::ROUND_BLOCK_SIZE_MODE_ENLARGE); // The size of the qr code and the final image is enlarged, if necessary
        $qrCode->setRoundBlockSize(true, QrCode::ROUND_BLOCK_SIZE_MODE_SHRINK); // The size of the qr code and the final image is shrinked, if necessary
        
        // Set additional writer options (SvgWriter example)
        $qrCode->setWriterOptions(['exclude_xml_declaration' => true]);

        $path = public_path().'/qrcode';
        if(!is_dir($path)){
            mkdir($path,0777,true);
        }
        $qrcode_path = $path.'/'.$tree->uuid.'.png';
      
        // Save it to a file
        $qrCode->writeFile($qrcode_path);
        return response()->download($qrcode_path, $tree->name.'.png');
       

    }
}
