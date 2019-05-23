<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class Wechat extends Model
{
    public static function GetAccessToken()
    {
        /*
         * 读取文件，看有没有 ，有的话读取，没有的话创建
         * 看看token是否过期，没有获取，有的话 生成
         */
        $path=public_path()."/wx";
        if(is_dir($path)){
            $filename=$path."/token.txt";
            if(is_file($filename)){
                $str=file_get_contents($filename);
                if(!empty($str)){
                    $now=time();
                    $data=json_decode($str,true);
                    if($now->$data['expire']){
                        $token=self::CreateAccessToken();
//                        print_r($token);die;
                        $expire=time()+7100;
                        $arr=['token'=>$token,'expire'=>$expire];
                        $str=json_encode($arr);
                        file_put_contents($filename,$str);
                    }else{
                        $token=$data['token'];
                    }
                }else{
                    $token=self::CreateAccessToken();
                    $expire=time()+7100;
                    $arr=['token'=>$token,'expire'=>$expire];
                    $str=json_encode($arr);
                    file_put_contents($filename,$str);
                }
            }else{
                touch($filename);
            }
        }else{
            mkdir($path);
        }

            return $token;

    }
    static private function CreateAccessToken()
    {
        $appid=env('WXAPPID');
        $appsecret=env('WXAPPSECRET');
        $url="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$appsecret";
        $re= file_get_contents($url);
        $token=json_decode($re,true)['access_token'];
        return $token;
    }
}

