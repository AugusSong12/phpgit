<?php
error_reporting(E_ERROR);
class JSSDK {
  private $appId;
  private $appSecret;

  public function __construct($appId, $appSecret) {
    $this->appId = $appId;
    $this->appSecret = $appSecret;
  }

  public function getSignPackage() {
    $jsapiTicket = $this->getJsApiTicket();

    // 注意 URL 一定要动态获取，不能 hardcode.
    //print_r($_SERVER);
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $url = "https://".$_SERVER[HTTP_HOST].$_SERVER[REQUEST_URI];
    //echo $url;
    $timestamp = time();
    $nonceStr = $this->createNonceStr();

    // 这里参数的顺序要按照 key 值 ASCII 码升序排序
    $string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";

    $signature = sha1($string);

    $signPackage = array(
      "appId"     => $this->appId,
      "nonceStr"  => $nonceStr,
      "timestamp" => $timestamp,
      "url"       => $url,
      "signature" => $signature,
      "rawString" => $string
    );
    return $signPackage; 
  }

  private function createNonceStr($length = 16) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $str = "";
    for ($i = 0; $i < $length; $i++) {
      $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
    }
    return $str;
  }

  public function getJsApiTicket() {
    // jsapi_ticket 应该全局存储与更新，以下代码以写入到文件中做示例
    $data = json_decode($this->get_php_file($this->appId."jsapi_ticket.php"));
    if ($data->expire_time < time()) {
      $accessToken = $this->getAccessToken();
      // 如果是企业号用以下 URL 获取 ticket
      // $url = "https://qyapi.weixin.qq.com/cgi-bin/get_jsapi_ticket?access_token=$accessToken";
      $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=$accessToken";
      $res = json_decode($this->httpGet($url));
      $ticket = $res->ticket;
      if ($ticket) {
        $data->expire_time = time() + 7000;
        $data->jsapi_ticket = $ticket;
        $this->set_php_file($this->appId."jsapi_ticket.php", json_encode($data));
      }
    } else {
      $ticket = $data->jsapi_ticket;
    }

    return $ticket;
  }

  public function getAccessToken() {
    // access_token 应该全局存储与更新，以下代码以写入到文件中做示例
    $data = json_decode($this->get_php_file($this->appId."access_token.php"));
    if ($data->expire_time < time()) {
      // 如果是企业号用以下URL获取access_token
      // $url = "https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid=$this->appId&corpsecret=$this->appSecret";
      $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$this->appId&secret=$this->appSecret";
      $res = json_decode($this->httpGet($url));
      $access_token = $res->access_token;
      if ($access_token) {
        $data->expire_time = time() + 7000;
        $data->access_token = $access_token;
        $this->set_php_file($this->appId."access_token.php", json_encode($data));
      }
    } else {
      $access_token = $data->access_token;
    }

    //echo $this->appId," ",$access_token," ";
    return $access_token;
  }

  function getCurlStr($dt)
  {
    $str="";
    foreach ($dt as $key => $value) {
      $str.=$key."=".$value."&";
    }
    $str=substr($str,0,-1);
    //echo $str;
    return $str;
  }

  function getMiniCode($scene="yuyuemao",$page="index/index")
  {
    $param=json_encode(array("path"=>$page));//"scene"=>$scene,
   $key=md5($param.$this->appId);
    if(file_exists("mini".$key.".jpg"))
    {
      return "mini".$key.".jpg";
    }
    //echo "fucking....";
    $img=$this->request_post("https://api.weixin.qq.com/wxa/getwxacode?access_token=".$this->getAccessToken(),$param);
    //echo $img;
    file_put_contents("mini".$key.".jpg", $img);
    return "mini".$key.".jpg";
  }

  function request_post($url = '', $param = '') {
        if (empty($url) || empty($param)) {return false;}
        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_URL,$url);//抓取指定网页
        curl_setopt($ch, CURLOPT_HEADER, "charset=UTF-8");//设置header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
        $data = curl_exec($ch);//运行curl
        curl_close($ch);
        return $data;
    }

  public function httpGet($url,$param = '') {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_TIMEOUT, 500);
    curl_setopt($curl, CURLOPT_HEADER, 0);//设置header
    // 为保证第三方服务器与微信服务器之间数据传输的安全性，所有微信接口采用https方式调用，必须使用下面2行代码打开ssl安全校验。
    // 如果在部署过程中代码在此处验证失败，请到 http://curl.haxx.se/ca/cacert.pem 下载新的证书判别文件。
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, true);
    curl_setopt($curl, CURLOPT_URL, $url);

    if($param!='')
    {
       curl_setopt($curl, CURLOPT_POST, 1);//post提交方式
        curl_setopt($curl, CURLOPT_POSTFIELDS, $param);
    }

    $res = curl_exec($curl);
    curl_close($curl);

    return $res;
  }

  private function get_php_file($filename) {
    return trim(substr(file_get_contents($_SERVER['DOCUMENT_ROOT']."/wxsdk/".$filename), 15));
  }
  private function set_php_file($filename, $content) {
    $fp = fopen($_SERVER['DOCUMENT_ROOT']."/wxsdk/".$filename, "w");
    fwrite($fp, "<?php exit();?>" . $content);
    fclose($fp);
  }

  public function getCode()//授权 获得code
  {
    $REDIRECT_URI="http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];//"/index.php?m=user&act=login";
    $url="https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$this->appId."&redirect_uri=".urlencode($REDIRECT_URI)."&response_type=code&scope=snsapi_base&state=1#wechat_redirect";

    //echo $url;
    header("Location: ".$url);
    exit;
   // return json_decode($this->httpGet($url));
//https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxcf13520e5d92f3f9&redirect_uri=https%3A%2F%2Fyuyuemao.cn%2Findex.php%3Fm%3Duser%26act%3Dauthor&response_type=code&scope=snsapi_base&state=1#wechat_redirect
  }

  public function getUserAccess_token()
  {
  

    
    if(isset($_GET['code']))
      $CODE=$_GET['code'];
    else
    {
       $this->getCode();
      //exit;
    }

    $url="https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$this->appId."&secret=".$this->appSecret."&code=".$CODE."&grant_type=authorization_code";
    //echo $url;

    return json_decode(file_get_contents($url));
   // return json_decode($this->httpGet($url));
    //1.检查是不是有 没有直接授权
    //2.检查是不是过期 过期的话刷新
    //3.检查刷新有没有过期，过期的话授权
  }

  public function refreshAccess_token($REFRESH_TOKEN)
  {
    $url="https://api.weixin.qq.com/sns/oauth2/refresh_token?appid=".$this->appId."&grant_type=refresh_token&refresh_token=".$REFRESH_TOKEN;
  }

  public function sendMessage($data)
  {
    $ACCESS_TOKEN=$this->getAccessToken();
    //echo "  ttt:".$ACCESS_TOKEN;
    $url="https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$ACCESS_TOKEN;
    //echo $data;
    $rs=$this->httpGet($url,$data);
    //print_r($rs);
    return $rs;
//{"errcode":0,"errmsg":"ok","msgid":244934489904627719}
  }

   public function sendMessageMini($data)
  {
    $ACCESS_TOKEN=$this->getAccessToken();
    //echo "  ttt:".$ACCESS_TOKEN;
    $url="https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=".$ACCESS_TOKEN;
    //echo $data;
    $rs=$this->httpGet($url,$data);
    //print_r($rs);
    return $rs;
//{"errcode":0,"errmsg":"ok","msgid":244934489904627719}
  }

  public function getOpenId()
  {
    $tmp=$this->getUserAccess_token();

    return $tmp->openid;
  }

}

