<?php
/**
 * Created by PhpStorm
 * PROJECT:
 * User:  Doing <vip.dulin@gmail.com>
 * Date:
 * Desc:极光推送配置文件
 */
#去极光后台创建应用得到的AppKey
const JG_APP_KEY = 'key123';
#去极光后台创建应用得到的Master Secret
const JG_MASTER_SCERET = 'sceret456';
#推送的地址(极光推送官网接口请求baseurl):不用修改
const JG_URL = 'https://api.jpush.cn/v3/push';
#项目所处环境  指定 APNS 通知发送环境：True 表示推送生产环境，False 表示要推送开发环境
//对于安装用户此参数是不受影响的,对于苹果用户是受严格验证的,如果环境指定错误苹果是收不到信息的
const JG_APNS = False;
#离线时间 单位秒 默认0(只发在线用户)
const JG_TIME_TO_LIVE = 0;



