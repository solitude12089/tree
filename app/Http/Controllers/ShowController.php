<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
class ShowController extends Controller
{
    public function show($tree_uuid){
     
        $tree = \App\models\Tree::where('uuid',$tree_uuid)->first();
       
        if($tree==null || $tree->status==9){
            abort(404);
        }
       

        return view('show.show',['tree'=>$tree]);
    }
}
