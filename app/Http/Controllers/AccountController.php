<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Hash;
class AccountController extends Controller
{
    public function index(){
        $users = \App\User::all();
        return view('account.index',['users'=>$users]);
    }


    public function create(){
        return view('account.create');

    }

    public function p_create(Request $request){
        try{
            $data = $request->all();
        
            if(!isset($data['account'])||$data['account']==''){
                throw new \Exception('帳號不可為空.');
            }
             if(!isset($data['name'])||$data['name']==''){
                throw new \Exception('姓名不可為空.');
            }
    
            if(!isset($data['pwd'])||!isset($data['dpwd'])){
                throw new \Exception('密碼不可為空.');
            }
    
            if($data['pwd']!=$data['dpwd']){
                throw new \Exception('確認密碼不符.');
            }
    
            $user = \App\User::where('account',$data['account'])->first();
            if($user!=null){
                throw new \Exception('帳號重複,無法建立');
            }
    
            $new_user = new \App\User;
            $new_user->account = $data['account'];
            $new_user->name = $data['name'];
            $new_user->password = Hash::make($data['pwd']);
            $new_user->save();
            return redirect('account/index')->with('alert-success', '帳號建立成功.');
        }
        catch(\Exception $e){
            return redirect('account/index')->with('alert-danger', $e->getMessage());
        }
       
    }

    public function modify($id){
        $user = \App\User::where('id','=',$id)
                            ->first();


        return view('account.modify',['user'=>$user]);
    }

    public function p_modify(Request $request,$id){
        try{
            $olduser = \App\User::where('id',$id)->first();
            if($olduser==null){
                throw new \Exception('資料錯誤,無法修改.');
            }
    
            $data = $request->all();
            if(!isset($data['account'])||$data['account']==''){
                throw new \Exception('帳號不可為空.');
            }
             if(!isset($data['name'])||$data['name']==''){
                throw new \Exception('姓名不可為空.');
            }
            if(!isset($data['pwd'])||!isset($data['dpwd'])){
                throw new \Exception('密碼不可為空.');
            }
            if($data['pwd']!=$data['dpwd']){
                throw new \Exception('確認密碼不符.');
            }
            $check = \App\User::where('id','!=',$id)
                                ->where('account','=',$data['account'])
                                ->first();
            if($check!=null){
                throw new \Exception('帳號重複,無法修改.');
            }
           
            $olduser->account = $data['account'];
            $olduser->name = $data['name'];
    
            if($data['pwd']!='nochange'){
                $olduser->password = Hash::make($data['pwd']);    
            }
    
         
            $olduser->status=$data['status'];
            $olduser->save();
           
            return redirect('account/index')->with('alert-success', '帳號修改成功.');
        }
        catch(\Exception $e){
            return redirect('account/index')->with('alert-danger', $e->getMessage());
        }

    }

    public function reset(){
        return view('account.reset');
    }
    public function p_reset(Request $request){
        $data = $request->all();
      
        if(!isset($data['pwd'])||!isset($data['dpwd'])){
              return redirect('account/reset')->with('alert-danger', '密碼不可為空.');
        }

        if($data['pwd']!=$data['dpwd']){
              return redirect('account/reset')->with('alert-danger', '確認密碼不符.');
        }

        $user = Auth::user();
        $user->password = Hash::make($data['pwd']);
        $user->save();


     
        return redirect('account/reset')->with('alert-success', '變更成功.');
    }
}
