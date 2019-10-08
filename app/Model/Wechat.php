<?php 

namespace App\Model;

/**
 * 非静默授权获取用户信息
 */
class Wechat
{
    public static function getUserInfo()
    {

        $openid=session('openid'); 
        if($openid){
            return $openid;
        }
        $code=request()->get('code');
        if($code){
            $appid="wxb420b634b262c408";
            $secret="101c16a28aed9bd6e85a2baf33cceb1a";
            $url="https://api.weixin.qq.com/sns/oauth2/access_token?appid=$appid&secret=$secret&code=$code&grant_type=authorization_code";
            $re = file_get_contents($url);
            $re=json_decode($re,true);
            // dd($re);
            $access_token=$re['access_token'];
            // dd($access_token);
            $openid=$re['openid'];
            // dd($openid);
            $url="https://api.weixin.qq.com/sns/userinfo?access_token=$access_token&openid=$openid&lang=zh_CN"; 
            // dd($url);
            $info=file_get_contents($url);
            $info=json_decode($info,true);
            // dd($info);
            session(['openid'=>$info]);
        }else{
            $host=$_SERVER['HTTP_HOST'];
            $uri=$_SERVER['REQUEST_URI'];
            $appid="wxb420b634b262c408";
            $redirect_uri=urlencode("http://".$host.$uri);
            $url="https://open.weixin.qq.com/connect/oauth2/authorize?appid=$appid&redirect_uri=$redirect_uri&response_type=code&scope=snsapi_userinfo&state=111#wechat_redirect";
            header("location:".$url);die;
        }
        return $info;
    }




}
