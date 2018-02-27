<?php
/**
 * Created by PhpStorm
 * PROJECT:
 * User: Doing <vip.dulin@gmail.com>
 * Desc:极光接口:根据官方接口整理
 */


namespace Jpush;


class JpushApi {
    #实例化对象
    private static $instance;
    #app_key在Jgconfig.php配置
    private $app_key = '';
    #master_secret在Jgconfig.php配置
    private $master_secret = '';
    #baseurl
    private $url = '';


    /**
     * JpushApi constructor.
     */
    public function __construct()
    {
        $this->app_key = JG_APP_KEY;
        $this->master_secret = JG_MASTER_SCERET;
        $this->url = JG_URL;
    }

    /**入口实例化对象
     *
     * @param array $options
     *
     * @return array|static
     */

    public static function instance()
    {
        if (is_null(self::$instance))
        {

            self::$instance = new static();
        }

        return self::$instance;
    }

    /*
        $content 推送的内容。
        $extras  附加字段  array类型
        $m_time 保存离线时间的秒数默认为一天(可不传)单位为秒
    */
    /**
     * @param array $param title 推送标题:一定填写
     * @param array $param content 推送内容:一定填写
     * @param string $type 按什么推送默认是按别名推送
     *
     * @return bool
     */
    public function push($param = [], $type = 'alias')
    {

        $base64 = base64_encode("$this->app_key:$this->master_secret");
        $header = ["Authorization:Basic $base64", "Content-Type:application/json"];
        $data = [];
        //目标用户终端手机的平台类型android,ios,winphone,all所有
        $data['platform'] = ['android', 'ios'];
        #发送目标 和发送类型: 根据标签tag,根据别名alias官方文档给了很多方式:目前字融入了别名
        //文档地址:https://docs.jiguang.cn/jpush/server/push/rest_api_v3_push/
        switch ($type)
        {
            case 'alias':
                # 根据别名推送
                $data['audience'] = json_encode($param['alias']);
                break;
        }//switch

        #发送通知
        $data['notification'] = [
            //统一的模式--标准模式
            //"alert"=>$content,
            //安卓自定义
            "android" => [
                "alert"      => $param['content'],
                "title"      => $param['title'],
                "builder_id" => 1,
                "extras"     => $param['extras']
            ],
            //ios的自定义
            "ios"     => [
                "alert"  => $param['content'],
                "badge"  => "1",
                "sound"  => "default",
                "extras" => $param['extras']
            ],
        ];

        //自定义信息
        $data['message'] = [
            "msg_content" => $param['content'],
            "extras"      => $param['extras']
        ];

        //附加选项
        $data['options'] = [
            "sendno"          => time(),
            //推送在线用户还是离线用户 需要保留离线时间请在Jgconfig.php里面的JG_TIME_TO_LIVE配置 并使用
            "time_to_live"    => JG_TIME_TO_LIVE,
            //指定 APNS 通知发送环境：0开发环境开发过程，1生产环境。
            "apns_production" => JG_APNS,
        ];
        $param = json_encode($data);
        $res = json_decode($this->push_curl($param, $header));
        if (!isset($res->error))
            return true;
        return $res->error;
    }

    //推送的Curl方法
    public function push_curl($param = "", $header = "")
    {
        if (empty($param))
        {
            return false;
        }
        $postUrl = $this->url;
        $curlPost = $param;
        $ch = curl_init();                                      //初始化curl
        curl_setopt($ch, CURLOPT_URL, $postUrl);                 //抓取指定网页
        curl_setopt($ch, CURLOPT_HEADER, 0);                    //设置header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);            //要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_POST, 1);                      //post提交方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);           // 增加 HTTP Header（头）里的字段
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);        // 终止从服务端进行验证
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        $data = curl_exec($ch);                                 //运行curl
        curl_close($ch);
        return $data;
    }


}//class