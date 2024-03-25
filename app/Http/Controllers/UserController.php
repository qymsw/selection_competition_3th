<?php

namespace App\Http\Controllers;
use App\Http\Middleware\AuthUser;
use App\Models\Admin;
use App\Models\Size;
use App\Models\Frame;
use App\Models\Order;
use App\Models\User;
use Validator;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    public function __construct(){
        $this->middleware(AuthUser::class)->only(['logout','resetUser','getCart','addPhotosToCart','deletePhotoFromCart','getOrder','createOrder','cancelOrder',]);
    }
    public function login(Request $request){
        $email = $request->email;
        $password = $request->password;
        $user = User::where('email',$email)->first();
        if(!$user){
            return response()->json([
                'msg'=>'data cannot be processed'
            ],422);
        }
        if($user->password === $password){
            $token = md5($email);
            $user->update(['token'=>$token]);
            $user->makeHidden(['updated_at','created_at','password']);
            $user['create_time'] = date('Y-m-d H:i', strtotime($user['created_at']));
            return response()->json([
                'msg'=>'success',
                'data'=>$user
            ]);
        }  
        return response()->json([
            'msg'=>'user credentials are invalid'
        ]);
        return 'test';
    }
    
    public function register(Request $request){
        $user = User::where('email',$request->email)->first();    
        if($user){
            return response()->json([
                'msg'=>'email has already been used'
            ]);
        }
        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
        ]);        
        if($request->password !== $request->repeat_password || $validator->fails()){
            return response()->json([
                'msg'=>'data cannot be processed'
            ]);
        }
        $user = new User;
        $user->email = $request->email;
        $user->username = $request->username;
        $user->password = $request->password;
        $user->token = md5($user->email);
        $user->save();
        $user = User::where('email',$request->email)->first();
        $user->makeHidden(['updated_at','created_at']);
        $user['create_time'] = date('Y-m-d H:i', strtotime($user['created_at']));
        return response()->json([
            'msg'=>'success',
            'data'=>$user
        ]);
        // return 'test';
    }
    public function logout(Request $request){
        $token = $request->header('Authorization');
        $isLogin = User::where('token',$token)->first()->update(['token'=>'']);        
        return response()->json([
            'msg'=>'success'
        ],200);
        return 'test';
    }

    public function resetUser(Request $request){        
        if($request->new_password !== $request->repeat_password){
            return response()->json([
                'msg'=>'data cannot be processed'
            ],422);
        }
        $token = $request->header('Authorization');
        // return $token;
        $randomNumber = $request->new_password;
        $admin = User::where('token',$token)->first();
        if(!$admin){
            return response()->json([
                'msg'=>'not found'
            ]);
        }
        $admin->update(['password'=>$randomNumber]);
        $admin->makeHidden(['updated_at','created_at','token']);
        $admin['create_time'] = date('Y-m-d H:i', strtotime($admin['created_at']));
        return response()->json([
            'msg'=>'success',
            'data'=>$admin
        ]);
        return 'test';
    }
    public function getAllSize(Request $request){
        $allSize = Size::all();
        foreach($allSize as $item){
            $item->makeHidden(['updated_at','created_at']);
        }
        return response()->json([
            'msg'=>'success',
            'data'=>$allSize
        ]);
    }
    public function uploadPhoto(Request $request){
        
        return 'test';
    }
    public function deletePhoto(Request $request){
        return 'test';
    }
    public function setFrameForPhoto(Request $request){
        return 'test';
    }
    public function getAllFrame(Request $request){
        $arr = array();    
        $allFrame = Frame::all();        
        foreach($allFrame as $item){ 
            $item->size;          
            $tmp['id'] = $item->id;
            $tmp['url'] = $item->url;
            $tmp['price'] = $item->price;
            $tmp['name'] = $item->name;
            $tmp['size'] = $item->size->size;       
            array_push($arr,$tmp);
        }
        return response()->json([
            'msg'=>'success',
            'data'=>$arr,
        ],200);
        return $arr;    
        return 'test';
    }
    public function getCart(Request $request){
        return 'test';
    }
    public function addPhotosToCart(Request $request){
        return 'test';
    }
    public function deletePhotoFromCart(Request $request){
        return 'test';
    }
    public function getOrder(Request $request){
        return 'test';
    }
    public function createOrder(Request $request){
        
        return 'test';
    }
    public function cancelOrder(Request $request){
        return 'test';
    }
}
