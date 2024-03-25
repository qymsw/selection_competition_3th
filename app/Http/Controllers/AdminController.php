<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Size;
use App\Models\Frame;
use App\Models\Order;
use App\Models\User;
use Validator;
use App\Http\Middleware\AuthAdmin;

class AdminController extends Controller
{
    //
    public function __construct(){
        $this->middleware(AuthAdmin::class)->except(['login']);
    }
    
    public function login(Request $request) {
        $email = $request->email;
        $password = $request->password;
        $admin = Admin::where('email',$email)->first();
        // $admin = Admin::select('*','created_at as create_time','full_name as name')->where('email',$email)->get()[0];
        // $time = $admin->created_at;
        //  return date('Y-m-d H:i:s',strtotime($time));
        // $admin = Admin::select('id','email','password','full_name','created_at as create_time')->where('email',$email)->get()[0];
        // return $admin['create_time'];
        if(!$admin){
            return response()->json([
                'msg'=>'data cannot be processed'
            ]);
        }
        if($admin && $admin->password === $password){
            $token = md5($email);
            $admin->update(['token'=>$token]);
            // $admin['create_time'] = $admin['created_at'];
            $admin->makeHidden(['updated_at','created_at','password','token']);
            $admin['create_time'] = date('Y-m-d H:i',strtotime($admin->created_at));
            return response()->json([
                'msg'=>'success',
                'data'=>$admin
            ]);
        }
        return response()->json([
            'msg'=>'user credentials are invalid'
        ]);
    }

    // function login(Request $request){
    //     // return 'login';
    //     $validator = Validator::make($request->all(),[
    //         'email'=>'required|email',
    //         'password'=>'required',
    //     ]);
    //     if($validator->fails()){
    //         return response(['msg'=>'data cannot be processed'],422);
    //     }
    //     $admin = Admin::where(['email'=>$request->email,'password'=>$request->password]);   
        
    //     if($admin->exists()){
    //         $adminGet=$admin->get()->toArray()[0];
    //         $token = md5($adminGet['email']);
    //         $admin->update(['token'=>$token]);
    //         $admin = Admin::selectRaw('id,email,full_name,token,created_at as create_time')->get()[0];
    //         return response(['msg'=>'success','data'=>$admin]); 
    //     }
    //     return response(['msg'=>'user credentials are invalid'],401);
    // }

    public function logout(Request $request) {
        $token = $request->header('Authorization');
        $isLogin = Admin::where('token',$token)->first()->update(['token'=>'']);        
        return response()->json([
            'msg'=>'success'
        ],200);
    }

    // public function getAllSizes(Request $request) {
    //     $allSize = Size::all();
    //     foreach($allSize as $item){
    //         $item->makeHidden(['updated_at','created_at']);
    //     }
    //     return response()->json([
    //         'msg'=>'success',
    //         'data'=>$allSize
    //     ]);
    // }

    public function getAllSizes(Request $request){
        $data = Size::select('id', 'size', 'width', 'height', 'price as aa','created_at as created_time')->get();
        return response(['msg'=>'success', "data"=>$data], 200);
    }

    public function upDateSize(Request $request,$id){        
        $size = Size::find($id);
        $size->update(['price'=>$request->price]);
        $size->makeHidden(['updated_at','created_at']);      
        return response()->json([
            'msg'=>'success',
            'data'=>$size,
        ],200);
    }

    public function getAllFrames(Request $request) {          
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
    }

    public function updateFrame(Request $request,$id) {
        $frame = Frame::find($id);
        $frame->update(['name'=>$request->frame_name,'size_id'=>$request->size_id,'price'=>$request->price,]);
        $frame = Frame::find($id);
        $frame->makeHidden(['updated_at','created_at']);   
        $frame->size;          
        $tmp['id'] = $frame->id;
        $tmp['url'] = $frame->url;
        $tmp['price'] = $frame->price;
        $tmp['name'] = $frame->name;
        $tmp['size'] = $frame->size->size;       
        return response()->json([
            'msg'=>'success',
            'data'=>$tmp,
        ],200);
        return $tmp;
    }

    public function getAllOrders(Request $request) {          
        $arr = array();    
        $allOrders = Order::all();        
        foreach($allOrders as $item){ 
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
        return $allOrders;       
    }

    public function cancelOrder(){
        return 'cancelOrder';
    }    

    public function completeOrder(){
        return 'completeOrder';
    }

    public function getAllUsers(){
        $allUsers = User::all();
        foreach($allUsers as $item){
            $item->order;
            $item->makeHidden(['updated_at','created_at','token']);
            $item['create_time'] = date('Y-m-d H:i', strtotime($item['created_at']));
        }
        return response()->json([
            'msg'=>'success',
            'data'=>$allUsers
        ]);
        return 'completeOrder';
    }

    public function resetUser(){
        return 'completeOrder';
    }

    public function deleteUser(){
        return 'completeOrder';
    }

    public function resetCart(){
        return 'completeOrder';
    }

    public function getAllAdmin(){
        // $allAdmin = Admin::all();
        $allAdmin = Admin::select('id','email','full_name','created_at as create_time')->get();
        return $allAdmin;
        // foreach($allUsers as $item){
        //     $item->makeHidden(['updated_at','created_at','token','password',]);
        //     $item['create_time'] = date('Y-m-d H:i', strtotime($item['created_at']));
        // }
        return response()->json([
            'msg'=>'success',
            'data'=>$allAdmin
        ]);
    }

    public function createAdmin(Request $request){        
        $admin = Admin::where('email',$request->email)->first();        
        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
        ]);        
        if($request->password !== $request->repeat_password || $admin || $validator->fails()){
            return response()->json([
                'msg'=>'data cannot be processed'
            ]);
        }
        $admin = new Admin;
        $admin->email = $request->email;
        $admin->full_name = $request->full_name;
        $admin->password = $request->password;
        $admin->save();

        $admin = Admin::where('email',$request->email)->first();
        $admin->makeHidden(['updated_at','created_at','token','password',]);
        $admin['create_time'] = date('Y-m-d H:i', strtotime($admin['created_at']));
        return response()->json([
            'msg'=>'success',
            'data'=>$admin
        ]);
    }

    public function resetAdmin(Request $request,$id){
        $randomNumber = mt_rand(10000000, 99999999);
        $admin = Admin::where('id',$id)->first();
        if(!$admin){
            return response()->json([
                'msg'=>'not found'
            ]);
        }
        $admin->update(['password'=>$randomNumber]);
        // 隐藏 $admin 所有的属性
        $admin->makeHidden(array_keys($admin->getAttributes()));
        // 显示 $admin 部分属性
        $admin->makeVisible(['id','password']);
        return response()->json([
            'msg'=>'success',
            'data'=>$admin
        ]);
    }

    public function deleteAdmin(Request $request,$id){
        $admin = Admin::where('id',$id)->first();
        if(!$admin){
            return response()->json([
                'msg'=>'not found'
            ]);
        }
        $admin->delete();
        return response()->json([
            'msg'=>'success',
        ]);
        return 'completeOrder';
    }

    public function test(){
        return 'test';
    }  
}
