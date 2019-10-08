<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Curl;
use DB;
use Illuminate\Support\Facades\Cache;
use App\Tools\Tools;

class LoginController extends Controller
{
    public $tools;
    public function __construct(Tools $tools)
    {
        $this->tools=$tools;
    }

    public function login()
    {
    	
    	return view('admin/login');
    }

    public function login_do(Request $request)
    {
    	$all=request()->except('_token');
    	// dd($all);
		//用户名错误 密码错误 或者全错
		$res = DB::connection('port')->table('adminLogin')->where('username','=',$all['username'])->first();
		// dd($res);
        // Cache::set($code);
        if(!$res){
            return redirect('admin/login');
        }else{
            if($all['password']==$res->password){
                request()->session()->put('username',$res);
                return redirect('admin/index');
            }else{
                return redirect('admin/login');
            }
        }
    	
    }

    public function send(Request $request)
    {
        $post = request()->all();
        // dd($post);
        $username = $post['username'];
        $password = $post['password'];
        //查询数据表
        $adminData = DB::connection('port')->table('adminLogin')->first();
        // dd($adminData);
        //发送验证码
        $code = rand(1000,9999);
        Cache::put($code,120);
        // dd($codes);
        // dd($data);
        $url = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$this->tools->get_wechat_access_token();
        // dd($url);
       $data = [
            'touser'=>$adminData->openid,
            'template_id' =>'1aJxhXFI1vydJUvTCAvWxRruJMIzL_iHuftYXddLgxs',
            'data'=>[
                'name'=>[
                    'value'=>$username,
                    'color'=>'#173177',
                ],
                'code'=>[
                    'value'=>$code,
                    'color'=>'#173177',
                ]
            ]
       ];
       // dd($data);
       // dd(get_object_vars($data));
        $postdata = json_encode($data,JSON_UNESCAPED_UNICODE);

        // dd($data);    
        
       //发送请求
        
       $res = Curl::post($url,$postdata);
       return json_encode(['res'=>1,'msg'=>'发送成功']);
    }


    public function band()
    {
        return view('cate/band');
    }
}
