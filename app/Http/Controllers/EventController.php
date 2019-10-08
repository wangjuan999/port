<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use App\Tools\Tools;

class EventController extends Controller
{
    public $tools;
    public function __construct(Tools $tools)
    {   
        $this->tools=$tools;
    }

    /**
     * 接收微信发送的消息【用户互动】
     */
    // public function event()
    // {
    //     $xml_string = file_get_contents('php://input');  //获取微信返回数据（xml包）
    //     //记录访问日志
    //     $wechat_log_psth = storage_path('logs/wechat/'.date('Y-m-d').'.log');
    //     file_put_contents($wechat_log_psth,"<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<\n",FILE_APPEND);
    //     file_put_contents($wechat_log_psth,$xml_string,FILE_APPEND);
    //     file_put_contents($wechat_log_psth,"\n<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<\n\n",FILE_APPEND);
    //     //dd($xml_string);
    //     //将xml包转为可执行对象
    //     $xml_obj = simplexml_load_string($xml_string,'SimpleXMLElement',LIBXML_NOCDATA);
    //     $xml_arr = (array)$xml_obj;
    //     \Log::Info(json_encode($xml_arr,JSON_UNESCAPED_UNICODE));
    //     //echo $_GET['echostr'];
    //     //业务逻辑
    //     // dd($xml_arr);
    //     // 
    //     // 
    //     if($xml_arr['MsgType'] == 'event'){
    //         if($xml_arr['Event'] == 'subscribe'){
    //             //如果是关注事件
    //             $share_code = explode('_',$xml_arr['EventKey'])[1];
    //             $openid = $xml_arr['FromUserName']; //粉丝openid
    //             //判断openid是否已经在日志表
    //             $wechat_users = DB::connection('mysql_cart')->table('wechat_users')->where(['openid'=>$openid])->first();
    //             if(empty($wechat_users)){
    //                 DB::connection('mysql_cart')->table('wechat_user')->where(['id'=>$share_code])->increment('share_num',1);
    //                 DB::connection('mysql_cart')->table('wechat_users')->insert([
    //                     'openid'=>$openid,
    //                     'add_time'=>time()
    //                 ]);
    //             }
    //         }
    //     }
    //     $message = '欢迎关注！';
    //     $xml_str = '<xml><ToUserName><![CDATA['.$xml_arr['FromUserName'].']]></ToUserName><FromUserName><![CDATA['.$xml_arr['ToUserName'].']]></FromUserName><CreateTime>'.time().'</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA['.$message.']]></Content></xml>';
    //     echo $xml_str;
    //     dd($xml_str);
    // } 
    public function event()
    {
        $xml_string = file_get_contents('php://input');  //获取微信返回数据（xml包）
        //记录访问日志
        $wechat_log_psth = storage_path('logs/wechat/'.date('Y-m-d').'.log');
       file_put_contents($wechat_log_psth,"<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<\n",FILE_APPEND);
        file_put_contents($wechat_log_psth,$xml_string,FILE_APPEND);
        file_put_contents($wechat_log_psth,"\n<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<\n\n",FILE_APPEND);
        //dd($xml_string);
        //将xml包转为可执行对象
        $xml_obj = simplexml_load_string($xml_string,'SimpleXMLElement',LIBXML_NOCDATA);
        $xml_arr = (array)$xml_obj;
        // dd($xml_arr);
        \Log::Info(json_encode($xml_arr,JSON_UNESCAPED_UNICODE));

        ///业务逻辑处理
        ///关注微信公众号时，回复文本消息成功
        if($xml_arr['MsgType'] == 'event' && $xml_arr['Event'] == 'subscribe'){
            //获取用户 基本信息
            $url = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$this->tools->get_wechat_access_token().'&openid='.$xml_arr['FromUserName'].'&lang=zh_CN';
            // dd($url);
            $userinfo = json_decode(file_get_contents($url),true);
            // dd($userinfo);
            // 
            $msg = '你好'.$userinfo['nickname'].'当前时间为'.$userinfo['subscribe_time'];
            $this->sendtextmsg($msg,$xml_arr);
        }

    }
    //封装好的发送文本消息方法
    /**
     * [sendtextmsg description]
     * @param  [type] $msg [description]  需要发送的内容
     * @return [type]      [description]  没有返回值，不报错证明发送成功
     */
    public function sendtextmsg($msg,$xml_arr)
    {
        $str = '<xml><ToUserName><![CDATA['.$xml_arr['FromUserName'].']]></ToUserName><FromUserName><![CDATA['.$xml_arr['ToUserName'].']]></FromUserName><CreateTime>'.time().'</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA['.$msg.']]></Content></xml>';
        echo $str;
    }
    /**
     * [getuserinfo description]
     * @return [type] [description]
     */
    public function bang()
    {
        dd(1);
    }



}
