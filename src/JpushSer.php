<?php
/**
 * Created by PhpStorm
 * PROJECT:
 * User:  Doing <vip.dulin@gmail.com>
 * Date:
 * Desc:极光推送封装逻辑 可根据自己的逻辑需求自行扩展参数
 */


namespace Jpush;


class JpushSer {

    /**按别名推送
     *
     * @param array $toJgs极光别名数组 :关联数组且key必须是是从0开始的连续数字
     * @param $mess [信息]
     *
     * @return bool
     */
    public static function sendByAlias($toJgs, $mess)
    {
        #别名数组 格式如下
        //$toJgs = ['1','2','3'];
        $params['alias']['alias'] = $toJgs;
        #推送消息:正文和标题
        $params['content'] = $mess['content'];
        $params['title'] = $mess['title'];
        #格外信息:让app开发者收到当不然用户看到的信息:有需要添加,不需要默认为空
        $params['extras'] = '';
        #time_to_live 推送当前用户不在线时，为该用户保留多长时间的离线消息，以便其上线时再次推送
        //默认 86400 （1 天），最长 10 天。
        //设置为 0 表示不保留离线消息，只有推送当前在线的用户可以收到。

        #开推
        $res = JpushApi::instance()->push($params, 'alias');
        #成功返回true
        if ($res === true) return true;
        #失败去$res里面去拿极光的错误信息做相应的逻辑处理
        throw new \Exception($res);
    }//pub

    /** 简述:更新xxx发送
     *根据需求执行扩展
     *
     * @params
     *
     */
    public static function sendXXX()
    {

    }//pf


}//class