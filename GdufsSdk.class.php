<?php
/**
 * Sdk类
 * 调用该类之前请先session_start();
 * 未注册应用的，需到http://120.24.78.54/Api/index.php/Index/applyKey申请密钥
 * 免责声明：该Sdk类以及所调用的Api类 均不保存用户数字广外密码 不会引起密码泄露问题
 * @author olivejt
 *
 */

//记录本应用使用Api的注册id和key
define('APPID', '');
define('APPKEY', '');
define('URL','http://120.24.78.54/Api/index.php/Index/');

class GdufsSdk{
	
	/**
	 * 构造函数
	 * 如果未设置APPID或APPKEY 则跳转到Api的申请页面
	 * 
	 */
	public function __construct(){
		if(APPID == '' || APPKEY == ''){
			header('location:http://120.24.78.54/Api/index.php/Index/applyKey');
			exit();
		}
	}
	/**
	 * 构造curl 抓取api返回的内容
	 * @param string $url
	 * @param array $datas
	 * @return array 
	 */
	public function sdkCurl($url,$datas){
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);//保存抓取内容而不直接输出
		curl_setopt($ch,CURLOPT_POST,1);//是否传值
		curl_setopt($ch,CURLOPT_POSTFIELDS,$datas);
		curl_setopt($ch, CURLOPT_ENCODING, "");
		$result = curl_exec($ch);
		curl_close($ch);
	
		$result = json_decode($result,true);
		return $result;
	}
	
	/**
	 * 登录获取学生信息
	 * @param String $username 学号
	 * @param String $password 密码
	 * @return array <array datas:学生信息,boolean isLogin:登录状态,string token:二次连接口令>
	 */
	public function login($username,$password){
		//用curl将学号密码及appid appkey传给api 会获得用户信息及一个token
		$datas['appId'] = APPID;
		$datas['appKey'] = APPKEY;
		$datas['type'] = 'login';
		$datas['username'] = $username;
		$datas['password'] = $password;
		$result = $this->sdkCurl(URL, $datas);
		
		$_SESSION['mygdufs_token'] = $result['token'];//将$result里的token保存到session中
		
		return $result;
	}
	
	/**
	 * 无需登录 用token获取Api上的学生信息
	 * @param String $username 学号 如：20121003532
	 * @return mixed if(-1) session已过期; else array datas:学生信息
	 */
	public function getUserInfo($username){
		//获取信息之前 Api检测token是否过期
		if($_SESSION['mygdufs_token'] == ''){ 
			return '-1';
		}
		$token = $_SESSION['mygdufs_token'];
		$datas['type'] = 'getUserData';
		$datas['username'] = $username;
		$datas['token'] = $token;
		$result = $this->sdkCurl(URL, $datas);
		return $result;
	}
}

?> 