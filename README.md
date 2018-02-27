# 说明文档
## Jpush极光推送集成thinkphp使用说明
> 别名是app端直接调极光的sdk去打别名:建议是用户在注册成时给用户打一个且项目里面唯一的别名:建议是id+时间戳

### 1.去Jgconfig.php配置文件
### 2.调用推送 以别名推送为例

```
#把以下代码放在一个方法体内部。

#在使用前，文件顶部一定先引用命名空间
use Jpush\JpushSer;

//别名数组
$toJgs = ['a1','a2'];
$mess['title'] = '发送标题';
$mess['content'] = '发送正文';
//JpushSer里面的静态方法可根据业务需求自行扩展
$res = JpushSer::sendByAlias($toJgs, $mess);
if ($res == true)
{
    //TODO 写推送成功的逻辑
}else
{
    //TODO 写推送失败的逻辑
    //获取极光反的错误码
    print_r($res['code']);
    //获取极光反的错误提示信息
    print_r($res['messsage']);
}
```

### 额外说明
此包写的比较有扩展信,更多的参数设置请去极光官网查看,根据业务需求酌情添加
https://docs.jiguang.cn/jpush/server/push/rest_api_v3_push/#audience