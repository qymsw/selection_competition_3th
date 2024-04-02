<?php

namespace App\Http\Controllers;
use App\Http\Middleware\AuthUser;
use App\Models\Admin;
use App\Models\Size;
use App\Models\Frame;
use App\Models\Order;
use App\Models\User;
use App\Models\Photo;
use App\Models\Cart;
use App\Models\CartPhoto;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;


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

    public function uploadPhoto(Request $request) {
        // 从数据库获取尺寸数据
        $size = Size::find($request->size_id);
    
        // 检查尺寸是否存在
        if (!$size) {
            return response()->json(['error' => 'Size not found'], 404);
        }
    
        // 从尺寸数据中获取 frame_id 和 frame_url
        $frame = Frame::where('size_id', $size->id)->first();
    
        // 如果没有找到相应的 frame，则返回错误响应
        if (!$frame) {
            return response()->json(['error' => 'Frame not found for this size'], 404);
        }
    
        $frame_id = $frame->id;
        $frame_url = $frame->url;
    
        // 将厘米转换为像素
        $ppi = 100; // 假设像素密度为100 PPI
        $target_width = $size->width * $ppi / 2.54;
        $target_height = $size->height * $ppi / 2.54;
    
        // 检查是否有上传的文件
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();
    
            // 根据文件类型创建不同类型的图像资源
            switch ($extension) {
                case 'jpg':
                case 'jpeg':
                    $source_image = imagecreatefromjpeg($image->path());
                    break;
                case 'png':
                    $source_image = imagecreatefrompng($image->path());
                    break;
                case 'gif':
                    $source_image = imagecreatefromgif($image->path());
                    break;
                default:
                    return response()->json(['error' => 'Unsupported image format'], 400);
            }
    
            // 获取原始图像的宽高
            $original_width = imagesx($source_image);
            $original_height = imagesy($source_image);
    
            // 计算原始图像的长宽比例
            $original_aspect_ratio = $original_width / $original_height;
    
            // 计算缩放后的宽度和高度
            if ($original_width > $original_height) {
                // 原始图像宽度大于高度，按目标高度进行缩放
                $new_height = $target_height;
                $new_width = $new_height * $original_aspect_ratio;
            } else {
                // 原始图像宽度小于等于高度，按目标宽度进行缩放
                $new_width = $target_width;
                $new_height = $new_width / $original_aspect_ratio;
            }
    
            // 创建一个新的图片资源，用于存储缩放后的图片
            $scaled_image = imagecreatetruecolor($new_width, $new_height);
    
            // 将原始图像调整大小并复制到新的图片资源中（缩放）
            imagecopyresampled($scaled_image, $source_image, 0, 0, 0, 0, $new_width, $new_height, $original_width, $original_height);
    
            // 创建一个新的图片资源，用于存储裁剪后的图片
            $cropped_image = imagecreatetruecolor($target_width, $target_height);
    
            // 计算裁剪的起点坐标使其居中
            $crop_x = ($new_width - $target_width) / 2;
            $crop_y = ($new_height - $target_height) / 2;
    
            // 将缩放后的图片裁剪到目标尺寸
            imagecopy($cropped_image, $scaled_image, 0, 0, $crop_x, $crop_y, $target_width, $target_height);
    
            // 生成原始图片的路径和裁剪后图片的路径
            $originalImagePath = 'uploads/' . $image->hashName();
            $editedImagePath = 'edited/' . $image->hashName();
    
            // 保存原始图片到 public/uploads 目录
            imagejpeg($scaled_image, public_path($originalImagePath));
    
            // 保存裁剪后的图像到 public/edited 目录
            imagejpeg($cropped_image, public_path($editedImagePath));
    
            // 释放内存，关闭图片资源
            imagedestroy($source_image);
            imagedestroy($scaled_image);
            imagedestroy($cropped_image);
    
            // 保存编辑后的图像到数据库
            $photo = new Photo();
            $photo->edited_url = asset($editedImagePath); // 使用 asset 函数获取完整 URL
            $photo->original_url = asset($originalImagePath); // 使用 asset 函数获取完整 URL
            $photo->size_id = $size->id;
            $photo->frame_id = $frame_id;
            $photo->save();
    
            // 返回上传后的图片路径和编辑后的图像路径
            return response()->json([
                'id' => $photo->id,
                'original_url' => $photo->original_url,
                'edited_url' => $photo->edited_url,
                'frame_id' => $frame_url
            ]);
    
        } else {
            // 如果没有上传文件，返回错误响应
            return response()->json(['error' => 'No image uploaded'], 400);
        }
    }   


    public function deletePhoto(Request $request,$id){
        $deletePhoto = Photo::where('id',$id)->delete();
        if($deletePhoto){
            return response()->json(['msg'=>'success']);
        }
        return response()->json(['msg'=>'not found']);
    }

    public function setFrameForPhoto(Request $request,$photo_id,$frame_id){
        $photo_id = $request->photo_id;
        // return $photo_id;
        $frame_id = $request->frame_id;
        // return $frame_id;
        $photo = Photo::find($photo_id);
        // return $photo;
        $photo->update(['frame_id'=>$frame_id]);
        // return $photo;
        $frame = Frame::find($frame_id);
        if(!$photo || !$frame){
            return response()->json(['msg'=>'not found']);
        }
        $result = array();
        $result['id'] = $photo->id;
        $result['frame_url'] = $photo->frame->url;

        return response()->json(['msg'=>'success','data'=>$result]);
        return $photo;

        return $photo;
        // return $photo_id;
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
        $cart = Cart::with('photo')->get();
        // $cart = Cart::find(1)->photo;
        // 返回查询结果
        return response()->json($cart);
        return 'test';
    }
    public function addPhotosToCart(Request $request){
        // $aaa = CartPhoto::all();
        // return $aaa;
        $token = $request->header('Authorization');
        $isLogin = User::where('token',$token)->first();
        $user_id = $isLogin->id;
        $cart = Cart::where('user_id',$user_id)->first();
        $cart_id = $cart->id;
        // return !$cart;
        if(!$cart){
            $newcart = new Cart;
            $newcart['user_id'] = $user_id;
            $newcart->save();
            $cart_id = $newcart->id;
        }
        $photo_id_list = $request->photo_id_list;         
               
        foreach($photo_id_list as $photo_id){
            // echo $photo_id;
            // echo '<br>';
            $photo = Photo::where(['id'=>$photo_id])->first();
            // return !$photo;
            if(!$photo){
                return response()->json(['msg'=>'not found']);  
            }
            $cart_photo = new CartPhoto;
            $cart_photo['cart_id'] = $cart_id;
            $cart_photo['photo_id'] = $photo_id;
            $cart_photo->save();
            
        }
        return $photo_id_list;

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
