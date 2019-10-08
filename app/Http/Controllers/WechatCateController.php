<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\model\Wechat;
use DB;
use Illuminate\Support\Facades\Cache;
use App\Tools\Tools;

class WechatCateController extends Controller
{
    public $tools;
    public function __construct(Tools $tools)
    {   
        $this->tools=$tools;
    }
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 菜单添加视图
     */
    public function addWechatCate()
    {
        $data = DB::connection('port')->table('wechatcate')->where('status',2)->get();
        return view('cate/addWechatCate',['data'=>$data]);
    }

    /**
     * 创建微信菜单
     */
    public function doaddcate()
    {
        $data = \request()->except(['_token']);
        // dd($data);
        unset($data['s']);
//        dd($data);
        if($data['pid'] != null){
            //二级菜单添加
            $data['status'] = 3;
            $result = DB::connection('port')->table('wechatcate')->where('pid',$data['pid'])->count();
            if($result >= 5){
                echo "<script>alert('每个一级分类最多可添加5个二级分类');history.back(-1)</script>";
                die;
            }
        }elseif($data['content'] == null){
        //该分类下要添加二级分类  status应为2   2级菜单的意思
            $data['status'] = 2;
            $result = DB::connection('port')->table('wechatcate')->where('pid',0)->count();
            if($result >= 3){
                echo "<script>alert('一级分类最多三个');history.back(-1)</script>";
                die;
            }
        }else{
            $data['status'] = 1;
            $result = DB::connection('port')->table('wechatcate')->where('pid',0)->count();
            if($result >= 3){
                echo "<script>alert('一级分类最多三个');history.back(-1)</script>";
                die;
            }
        }

        $res = DB::connection('port')->table('wechatcate')->insert($data);
        if($res){
                echo "<script>alert('OK');location.href='listWechatCate'</script>";
        }else{
            echo "<script>alert('滚');history.back(-1)</script>";
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 微信菜单列表展示
     */
    public function listWechatCate()
    {
        $data = DB::connection('port')->table('wechatcate')->get();
        $data = $this->stroycate1($data);
//        foreach($data as $k=>$v){
//            if(!empty($v->son)){
//                $data[$k]['son'] = $v->son;
//            }
//        }
//        dd($data);
        return view('cate/listWechatCate',['data'=>$data]);
    }

    /**
     * 应用到微信分类
     */
    public function createwechatcate()
    {
        $data = DB::connection('port')->table('wechatcate')->get()->toArray();//一级分类
        $data = $this->stroycate($data);
//        dd($data);
        $arr = [
            'click'=>'key',
            'view'=>'url'
        ];
        $postData = [];
        foreach($data as $key=>$value){
            if(empty($value->content)){
                //二级菜单   说明有son分类
                $postData['button'][$key]['name'] = $value->cate_name;
                foreach($value->son as $k=>$v){
                    $postData['button'][$key]['sub_button'][] = [
                       "type"=>$v->cate_type,
                       "name"=>$v->cate_name,
                       $arr[$v->cate_type]=>$v->content
                    ];
                }
            }else{
                //一级菜单
                $postData['button'][] = [
                    'type'=>$value->cate_type,
                    'name'=>$value->cate_name,
                    $arr[$value->cate_type]=>$value->content,
                ];
            }
        }
            $postData = json_encode($postData,JSON_UNESCAPED_UNICODE);
            $access = $this->tools->get_wechat_access_token();
            $url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token={$access}";
            // $url1 = "https://api.weixin.qq.com/cgi-bin/menu/delete?access_token={$access}";
            // $re = file_get_contents($url1);

            $res = $this->tools->curl_post($url,$postData);
           // dd($postData);
        $dd = json_decode($res,true);
        // dd($dd);
            if($dd['errmsg'] == 'ok'){
                    echo "<script>alert('分类应用成功');history.back(0)</script>";
            }else{
                echo "<script>alert('错误');history.back(0)</script>";
            }



    }
    public function stroycate($arr,$pid=0,$level=1)
    {
        $data = [];
        foreach($arr as $key=>$value){
            if($value->pid == $pid){
                $value->level = $level+1;
                $value->son= $this->stroycate($arr,$value->id,$level+3);
                $data[$key]= $value;
            }
        }
        return $data;
    }

    /**
     * @param $arr
     * @param int $pid
     * @param int $level
     * @return array
     * 微信菜单无限极分类
     */
    public function stroycate1($arr,$pid=0,$level=1)
    {
        static $data = [];
        foreach($arr as $key=>$value){
            if($value->pid == $pid){
                $value->level = $level;
                $data[$key]= $value;
                $this->stroycate1($arr,$value->id,$level+3);
            }
        }
        return $data;
    }
    public function clearcate()
    {
        $access = Wechat::getaccess();
        $url = "https://api.weixin.qq.com/cgi-bin/menu/delete?access_token={$access}";
        $res = file_get_contents($url);
        dd($res);
    }

}
