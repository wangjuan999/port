<?php
namespace App\Tools;

class Tools 
{
    public $redis;
    public function __construct()
    {
        $this -> redis = new \Redis();

        $this -> redis -> connect( '127.0.0.1' , '6379' );
    }


    
    /**
     * $url
     */
    public function curl_post($url,$data)
    {
        $curl = curl_init($url);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);   
        curl_setopt($curl,CURLOPT_POST,true);
        curl_setopt($curl,CURLOPT_POSTFIELDS,$data);
       
        $data=curl_exec($curl);
        $errno=curl_errno($curl);///错误码
        // dd($errno);
        $err_msg=curl_error($curl);//错误信息
        
        curl_close($curl);
        return $data;
    }



    /**
     * 获取access_token
     *
     * @return void
     */
    public function get_wechat_access_token()
    {
        
//        加入缓存
        $access_token_key = "wechat_access_token";
        if ($this->redis->exists($access_token_key)) {
//         存在 直接返回
            return $this->redis->get($access_token_key);
        } else {
//        不存在获取
            // 获取access_token
            $result = file_get_contents('https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=' . env('WECHAT_APPID') . '&secret=' . env('WECHAT_APPSECRET'));
            $re = json_decode($result, 1);
//        dd($re);
            $this->redis->set($access_token_key, $re['access_token'], $re['expires_in']);//加入缓存
            return $re['access_token'];

        }
    }


}
