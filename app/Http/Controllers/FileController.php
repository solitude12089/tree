<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;
class FileController extends Controller
{
    public function upload(Request $request){
        $data = $request->all();
        if($request->hasfile('file')){
            $file = $request->file('file');
            $n_file = new \App\models\File;
            $n_file->uuid = md5(uniqid(rand()));
            $n_file->extension = $file->getClientOriginalExtension();
            $n_file->filename = $file->getClientOriginalName();
            $n_file->size = $file->getSize();

            // $save_path = public_path().'/Images';
            // if(!is_dir($save_path)){
            //     mkdir($save_path,0777,true);

            // }
            // $file_path = $save_path.'/'.$file->getClientOriginalName();
            // $file->move($save_path, $file->getClientOriginalName());

            // $url = Storage::url('file.jpg');
            $rt = Storage::disk('gcs')->put('upload/'.$n_file->uuid.'.'.$n_file->extension,file_get_contents($file->getRealPath()),'public');
            $n_file->save();
            $url = env('GOOGLE_CLOUD_FILE_PATH').'/'.env('GOOGLE_CLOUD_STORAGE_BUCKET').'/upload/'.$n_file->uuid.'.'.$n_file->extension;
            // https://storage.googleapis.com/qrcode_tree/upload/95dd6ab7e4e73b485adec26f6cea4668.png

            
            // "url": "http://127.0.0.1/uploaded-image.jpeg"
            return  response()->json([
                "location" => $url,
                "file_path" => $url
            ],200);
            dd($rt,$file,$n_file);
        }
        dd('ZZZ');
    }
}
