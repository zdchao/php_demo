域名相关
========

添加域名
---------
接口地址：
    * https://api.dnsdun.com/?c=domain&a=add
HTTP请求方式：
    * POST
请求参数：
    * 接口公共参数
    * domain     域名,必选
    * group_id   分组id
响应代码：
    * 共通返回
    * 7 域名以存在
    * 8 用户信息s不存在
    * 10 意外
    


示例::

    curl -X POST 'https://api.dnsdun.com/?c=domain&a=add' -d 'format=json&domain=dnsdun.com&api_key=test&uid=1000'
    
返回参考：

    * JSON::

        {
            "status": {
                "code":"1",
                "message":"Action completed successful",
                "created_at":"2012-11-23 22:17:47"
            },
            "domain": {
                "id":"dnsdun.com",
                "domain":"dnsdun.com"
            }
        }

删除域名
---------
接口地址：
    * https://api.dnsdun.com/?c=domain&a=del
HTTP请求方式：
    * POST
请求参数：
    * 接口公共参数
    * domain     域名,必选
响应代码：
    * 共通返回
    * 10 意外    


示例::

    curl -X POST 'https://api.dnsdun.com/?c=domain&a=del' -d 'format=json&domain=dnsdun.com&api_key=test&uid=1000'
    
返回参考：

    * JSON::

        {
            "status": {
                "code":"1",
                "message":"Action completed successful",
                "created_at":"2012-11-23 22:17:47"
            }
        }
