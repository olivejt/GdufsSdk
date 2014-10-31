GdufsSdk
========

    A sdk for products of quantacenter

Version 1.0
--------
#文件结构
    function __construt(){} //判断APPID和APPKEY是否存在
    function sdkCurl(){}    //构造curl请求
    function login(){}      //用学生学号和密码登录 获取学生信息及二次连接的token
    function getUserInfo(){}//免密码，用token获取更多相关信息
  
#Sdk使用说明
    1.请先申请项目APPID和APPKEY,记录于类文件中,再添加到项目;
    2.调用方法参考SdkDemo.php文件,调用前注意开启session;
    3.获取的学生信息可以自行保存,但Sdk类及Api本身不会记录学生密码.
    
    
