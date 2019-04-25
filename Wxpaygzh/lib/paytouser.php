<?php
    require_once "WxPay.Config.php";
    //结算
    function payToUser($openid,$xinming,$amount,$oid)
    {

         $data=array(
        'mch_appid'=>WxPayConfig::APPID,//商户账号appid
        'mchid'=>WxPayConfig::MCHID,//商户号
        'nonce_str'=>md5($amount.$oid),//'616516516',//随机字符串
        'partner_trade_no'=>'tx'.$oid,//商户订单号
        'openid'=>$openid,//用户openid
        'check_name'=>'FORCE_CHECK',//NO_CHECK校验用户姓名选项,
        're_user_name'=>$xinming,//收款用户姓名
        'amount'=>floor($amount*100),//金额
        'desc'=>'预约猫提现',//企业付款描述信息
        'spbill_create_ip'=>getIP::ClientIp(),//Ip地址
        );
        // print_r($data);
        $secrect_key=WxPayConfig::KEY;//'Zvj4gxGrJvMNUvoEHojOYZuYUuBYn0ZR';///这个就是个API密码。32位的。。随便MD5一下就可以了
        $data=array_filter($data);
        ksort($data);
        $str='';
        foreach($data as $k=>$v) {
            $str.=$k.'='.$v.'&';
        }
        $str.='key='.$secrect_key;
        $data['sign']=md5($str);
        //print_r($data);
        $xml=arraytoxml($data);
        // echo $xml;

        $return1=array("err_code"=>"SYSTEMERROR");
 $url='https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers';
        $i=0;
        while(isset($return1['err_code'])&&$return1['err_code']=="SYSTEMERROR"&&$i<3)
        {
            $i++;
            $res=curl($xml,$url);
            var_dump($res);
            $return1=xmltoarray($res);
            echo $i,"aaa  ";
        }
        
        //print_r($return1);
    
        return $return1;
        //print_r($return);
    }
   

    // echo getcwd().'/cert/apiclient_cert.pem';die;
    function unicode() {
        $str = uniqid(mt_rand(),1);
        $str=sha1($str);
    return md5($str);
    }
    function arraytoxml($data){
        $str='<xml>';
        foreach($data as $k=>$v) {
            $str.='<'.$k.'>'.$v.'</'.$k.'>';
        }
        $str.='</xml>';
        return $str;
    }
    function xmltoarray($xml) { 
        //禁止引用外部xml实体 
        libxml_disable_entity_loader(true); 
        $xmlstring = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA); 
        $val = json_decode(json_encode($xmlstring),true); 
        return $val;
    } 
 
    function curl($param="",$url) {
    
        $postUrl = $url;
        $curlPost = $param;
        $ch = curl_init();                                      //初始化curl
        curl_setopt($ch, CURLOPT_URL,$postUrl);                 //抓取指定网页
        curl_setopt($ch, CURLOPT_HEADER, 0);                    //设置header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);            //要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_POST, 1);                      //post提交方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);           // 增加 HTTP Header（头）里的字段 
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);        // 终止从服务端进行验证
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch,CURLOPT_SSLCERT,WxPayConfig::SSLCERT_PATH ); //这个是证书的位置绝对路径
        curl_setopt($ch,CURLOPT_SSLKEY,WxPayConfig::SSLKEY_PATH); //这个也是证书的位置绝对路径
        $data = curl_exec($ch);   
        //var_dump(curl_error($ch));                              //运行curl
        curl_close($ch);
        return $data;
    }
?>
