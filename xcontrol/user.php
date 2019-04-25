<?php

//面向对象的control 类

class user
{
	var $res=array("code"=>1,"msg"=>"sucess");
	var $userid=0;
	var $username="";
	var $openid="";

	function __construct() 
	{
      // parent::__construct();
       //print "In SubClass constructor\n";
		if(isset($_SESSION['userid'])&&$_SESSION['userid']>0)
		{
			$this->userid=$_SESSION['userid'];
			$this->username=$_SESSION['username'];
			$this->res['userid']=$_SESSION['userid'];
			$this->res['username']=$_SESSION['username'];
			$this->res['pic']=$_SESSION['pic'];
			$this->res['name']=$_SESSION['name'];
			$this->res['ustatus']=$_SESSION['status'];

			if($this->res['ustatus']<1&&$_GET['act']<>'login')
				msgback("该账号已经被禁用或者权限调整请重新登录");
		}
		elseif(isset($_REQUEST['act'])&&$_REQUEST['act']<>"login"&&$_REQUEST['act']<>"regist")
		{
			gourl("index.php?m=user&act=login");
		}
		
   	}

   	function custEdit()
   	{
   		$this->res['name']="";
   		$id=0;
   		if(isset($_GET['id']))
   			$id=$_GET['id'];
   		//print_r($_POST);
   		if(isset($_POST['mobile']))
   		{
   			if(isset($_POST['customerid'])&&trim($_POST['customerid'])=="")
   			{//找到用户id
   				$cust=getRow("select id,name from customer where mobile='".trim($_POST['mobile'])."'");
   				if(!empty($cust))
   					$customerid=$cust['id'];
   				else
   				{
   					//if(%_POST['unit']==0)

   					saveData("customer", array('mobile' =>$_POST['mobile'] ));
   					$customerid=getLastId();
   				}
   			}
   			else
   				$customerid=$_POST['customerid'];

   			//检查重复用户
   			if(empty($_POST['id']))
   			{
   				$myid=getRow("select id from usercust where customerid=".$customerid);

   			if(!empty($myid))
   				$_POST['id']=$myid['id'];
   			}
   			

   			$_POST['customerid']=$customerid;
   			$_POST['userid']=$this->userid;
   			saveData("usercust",$_POST);
   			if($_POST['id']>0)
   				$id=$_POST['id'];
   			else
   				$id=getLastId();
   			

   		}

   		if($id>0)
   		{
   			$this->res=getRow("select uc.*,c.name,c.mobile from customer as c,usercust as uc where c.id=uc.customerid and uc.id=$id")+$this->res;
   		}
   	}

   	function custQianDao()
   	{
   		if(isset($_GET['id']))
   			exeSql("update usercust set remark=concat(sysdate(),'签到<br>',remark) where id=".$_GET['id']);

   		gourl("index.php?m=user&act=custList");
   	}

   	function custList()
   	{
   		$this->res['custlist']=getData("select uc.*,c.name,c.mobile from customer as c,usercust as uc where c.id=uc.customerid and uc.userid=".$this->userid);
   	}

   	function smsList()
   	{
   		$smslimit=getRow("select smslimit from user where id=".$this->userid);
   			$smslimit=intval($smslimit['smslimit']);
   			$this->res['smslimit']=$smslimit;
   		//发送短信
   		if(isset($_POST['smsmsg']))
   		{//检查剩余消息条数
   			
   			if(mb_strlen($_POST['smsmsg'])>65)
   				msgback("消息超过长度，请分开发送");



   			if($smslimit<=0)
   				msgback("您的短信条数不够了");


			
			include "lib/smsnew.php";

   			if(trim($_POST['mobile'])<>"")
   			{
   				$mobile=$_POST['mobile'];

   				$tmp=explode(",", $mobile);

   				$msgcount=count($tmp);

   				if($msgcount>$smslimit)
   						msgback("您的短信条数不够了");
   				
   			}
   			else
   			{
   				$sql="select distinct c.mobile,c.openid,c.id  from usercust as cu,customer as c where cu.customerid=c.id and cu.userid=".$this->userid;

	   			if($_POST['type']=="new")
	   				$where=" and cu.begindt<'".date("Y-m-d",strtotime("+7 days"))."'";
	   			elseif($_POST['type']=="out10")
	   				$where=" and cu.enddt>'".date("Y-m-d",strtotime("-10 days"))."' and cu.enddt<'".date("Y-m-d")."'";
	   			elseif($_POST['type']=="old")
	   				$where="' and cu.enddt>'".date("Y-m-d")."'";
	   			if($_POST['type']=="all")
	   				$where="";

	   			if($smslimit>200)
	   			$sql.=$where." limit 0,200";
	   			else
	   				$sql.=$where." limit 0,$smslimit";
	   			

	   			$data=getData("$sql");	
	   			$mobile="15005819707";

   				$msgcount=1;
   				foreach ($data as $key => $value) {
   					$mobile.=",".$value['mobile'];

   					$msgcount++;

   				}
   			}
	   			

   			//批量发送短信
   				

   			

   				send($mobile,$_POST['smsmsg']);

   				exeSql("update user set smslimit=smslimit-".$msgcount.",smstimes=smstimes+".$msgcount."  where id=".$this->userid);
   			

   		}
   		//
   		$sql="select distinct c.mobile,c.openid,cu.*  from usercust as cu,customer as c where cu.customerid=c.id and cu.userid=".$this->userid;
   		$this->res['list']=getData($sql);


   	}

   	function test()
   	{
   		//echo dirname("/");
   		echo file_get_contents("/home/bae/app/conf/t1.php");
   		exit;
   		//echo phpinfo();
   		//setCache("abc","aaaa dcdcd dddcdc ");
   		//echo getCache("abc");
   		//exit;
   	}

   	function index()
   	{
   		//检查商家资料
   		$user=getRow("select * from user where id=".$this->userid);
   		

   		$msgnum=0;

   		$viewtimes=0;

   		$msg=array();

   		//检查商家介绍 
   		if(trim($user['into'])=="")
   			$msg[]=array("msg"=>"您的商家介绍还没有填写","url"=>"index.php?m=user&act=profile");
   		//检查地址
   		if(trim($user['address'])==""||trim($user['city'])=="")
   			$msg[]=array("msg"=>"您的地址还没有填写正确","url"=>"index.php?m=user&act=profile");
   		//检查商家图片
   		if(trim($user['pic'])=="")
   			$msg[]=array("msg"=>"您的门店图片还没有上传","url"=>"index.php?m=user&act=profile");
   		//检查服务
   		$service=getData("select * from service where userid=".$this->userid);
   		//检查服务
   		if(empty($service))
   			$msg[]=array("msg"=>"您没有上传服务","url"=>"index.php?m=user&act=resEdit");

   		//检查服务图片
   		foreach ($service as $key => $value) 
   		{
   			$viewtimes+=$value['viewtimes'];
   			if(empty($value['pic']))
   				$msg[]=array("msg"=>"您的服务".$value['name']."没有上传图片","url"=>"index.php?m=user&act=resEdit&id=".$value['id']);
   			if($value['begin1']==$value['end1'])
   				$msg[]=array("msg"=>"您的".$value['name']."营业时间设置不对","url"=>"index.php?m=user&act=resEdit&id=".$value['id']);
   			# code...
   		}

   		$msgnum=count($msg);

   		$this->res['msgnum']=$msgnum;
   		$this->res['msg']=$msg;
   		$this->res['viewtimes']=$viewtimes;
   		$this->res['service']=$service;

   		//print_r($this->res);


   	}

   	function acount()
   	{
   		header("Content-type: text/html; charset=utf-8");


		

   		//处理提现
   		/*if(isset($_POST['payname']))
   		{
   			if(!$_POST['paypass']==$_SESSION["passkey"])
   				msgback("短信验证码不对哦");
   		}*/
   		//获得账户信息
   		$this->res['mobile']=getRow("select mobile from user where id=".$this->userid);
   		$this->res['acount']=getRow("select * from acount where userid=".$this->userid);
   		//获得账单明细
   		//echo $this->userid;
   		//print_r($this->res);
   		if(isset($this->res['acount']['id']))
   		$this->res['detail']=getData("select * from acountDetail where acountid=".$this->res['acount']['id']." order by id desc limit 0,100");


   		//支付宝提现
   		if(isset($_POST['payname'])&&isset($_POST['payid'])&&strlen($_POST['payid'])>5)
   		{
   			require_once 'lib/alipay/wappay/service/AlipayTradeService.php';
		require_once 'lib/alipay/wappay/buildermodel/AlipayTradeWapPayContentBuilder.php';
		require_once 'lib/alipay/config.php';
   			//检查账上是否有钱
   			$realmoney=$this->res['acount']['balance']-intval($this->res['acount']['locked']);
   			if($realmoney<$_POST['payamount'])
   				msgback("您的现金不足");


   				$change=-round($_POST['payamount'],2);
		      $detail=array(
		         "acountid"=>$this->res['acount']['id'],
		         "lastbalance"=>$this->res['acount']['balance'],
		         "change"=>$change,
		         "dt"=>date("Y-m-d H:i:s"),
		        
		         "payway"=>"a",
		         "userid"=>$this->res['acount']['userid'],
		         "remark"=>"提现",
		         "status"=>"1"
		      );
		      saveData("acountDetail",$detail);
		      $detailId=getLastId();
   			//支付宝转账
	   		$aop = new AopClient ();
			$aop->gatewayUrl = $config['gatewayUrl'];//'https://openapi.alipay.com/gateway.do';
			$aop->appId =  $config['app_id'];//'your app_id';
			$aop->rsaPrivateKey = $config['merchant_private_key'];//'请填写开发者私钥去头去尾去回车，一行字符串';
			$aop->alipayrsaPublicKey=$config['alipay_public_key'];//'请填写支付宝公钥，一行字符串';
			$aop->apiVersion = '1.0';
			$aop->signType = 'RSA2';
			$aop->postCharset='utf-8';
			$aop->format='json';
			$request = new AlipayFundTransToaccountTransferRequest ();
			$request->setBizContent("{" .
			"\"out_biz_no\":\""."tx_".$detailId."\"," .
			"\"payee_type\":\"ALIPAY_LOGONID\"," .
			"\"payee_account\":\"".$_POST['payid']."\"," .
			"\"amount\":\"".$_POST['payamount']."\"," .
			"\"payer_show_name\":\"提现\"," .
			"\"payee_real_name\":\"".$_POST['payname']."\"," .
			"\"remark\":\"提现\"" .
			"}");
			$result = $aop->execute ( $request); 

			$responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";
			$resultCode = $result->$responseNode->code;
			if(!empty($resultCode)&&$resultCode == 10000){
				//账户减少
				$change=-round($_POST['payamount'],2);
		      $detail=array(
		      	"id"=>$detailId,
		       /*  "acountid"=>$this->res['acount']['id'],
		         "lastbalance"=>$this->res['acount']['balance'],
		         "change"=>$change,
		         "dt"=>date("Y-m-d H:i:s"),
		         "pinzhen"=>$result['order_id'],
		         "payway"=>"a",
		         "userid"=>$this->res['acount']['userid'],
		         "remark"=>"提现",*/
		          "pinzhen"=>$result->responseNode->order_id,
		         "status"=>"2"
		      );
		      saveData("acountDetail",$detail);
		         //修改总账
		      saveData("acount",array("id"=>$this->res['acount']['id'],"balance"=>$this->res['acount']["balance"]+$change,"lastdt"=>date("Y-m-d H:i:s")));

			msgback( "提现成功");
			} else {
				print_r($result );
			echo "失败";
			}
   		}

   		//微信提现
   		if(isset($_POST['payname'])&&empty($_POST['payid']))
   		{
   			if(!($_POST['payamount']>99))
   				msgback("最小提现不能小于100");
   			//检查是不是在微信环境
   			if(is_weixin())
			{

				if(empty($_SESSION['openid']))
					msgback("亲，您的登录不正常，请退出后重新登录");

				//检查用户的openid

				//检查短信
				//检查账上是否有钱
   			$realmoney=$this->res['acount']['balance']-intval($this->res['acount']['locked']);
   			if($realmoney<$_POST['payamount'])
   				msgback("您的现金不足");


   				$change=-round($_POST['payamount'],2);
		      $detail=array(
		         "acountid"=>$this->res['acount']['id'],
		         "lastbalance"=>$this->res['acount']['balance'],
		         "change"=>$change,
		         "dt"=>date("Y-m-d H:i:s"),
		        
		         "payway"=>"w",
		         "userid"=>$this->res['acount']['userid'],
		         "remark"=>"提现到微信",
		         "status"=>"1"
		      );
		      saveData("acountDetail",$detail);
		      $detailId=getLastId();


				require_once "Wxpaygzh/lib/paytouser.php";
				$r=payToUser($_SESSION['openid'],$_POST['payname'],$_POST['payamount'],$detailId);

				if(($r['return_code']=='SUCCESS'&&$r['result_code']=='SUCCESS')||$r['err_code']=='SYSTEMERROR')
				{
				//账户减少
					$change=-round($_POST['payamount'],2);
			      $detail=array(
			      	"id"=>$detailId,
			     
			          "pinzhen"=>$r['payment_no'],
			         "status"=>"2"
			      );
			      if(isset($r['err_code'])&&$r['err_code']=='SYSTEMERROR')
			      	 $detail["remark"]="提现到微信延迟支付";

			      saveData("acountDetail",$detail);
			         //修改总账
			      saveData("acount",array("id"=>$this->res['acount']['id'],"balance"=>$this->res['acount']["balance"]+$change,"lastdt"=>date("Y-m-d H:i:s")));

				msgback( "提现成功");
				} else {
					//print_r($r);
					//exit;
					msgback($r['err_code_des']);
				}


	   		}
	   		else
	   		{
	   			msgback("请在微信环境下登录");
	   		}
	   }
	   

   		//充值
   		if(isset($_POST['chzhi']))
   		{

   			require_once 'lib/alipay/wappay/service/AlipayTradeService.php';
		require_once 'lib/alipay/wappay/buildermodel/AlipayTradeWapPayContentBuilder.php';
		require_once 'lib/alipay/config.php';
   			//生成充值明细
   			$change=round($_POST['payamount'],2);
		      $detail=array(
		         "acountid"=>$this->res['acount']['id'],
		         "lastbalance"=>$this->res['acount']['balance'],
		         "change"=>$change,
		         "dt"=>date("Y-m-d H:i:s"),
		        // "pinzhen"=>$result['order_id'],
		         "payway"=>"a",
		         "userid"=>$this->res['acount']['userid'],
		         "remark"=>"充值",
		         "status"=>"1"
		      );
		      saveData("acountDetail",$detail);

		      $detailId=getLastId();

		
		    //商户订单号，商户网站订单系统中唯一订单号，必填
		    $out_trade_no =  "cz_".$detailId;//$_POST['trade_no'];

		    //订单名称，必填
		    $subject = "充值";

		    //付款金额，必填
		    $total_amount = $_POST['payamount'];

		    //商品描述，可空
		    $body = "预约猫后台充值";

		    //超时时间
		    $timeout_express="1m";

		    $payRequestBuilder = new AlipayTradeWapPayContentBuilder();
		    $payRequestBuilder->setBody($body);
		    $payRequestBuilder->setSubject($subject);
		    $payRequestBuilder->setOutTradeNo($out_trade_no);
		    $payRequestBuilder->setTotalAmount($total_amount);
		    $payRequestBuilder->setTimeExpress($timeout_express);

		    $payResponse = new AlipayTradeService($config);
		    $result=$payResponse->wapPay($payRequestBuilder,$config['https://yuyuemao.cn/index.php?m=user&act=acount'],$config['https://yuyuemao.cn/lib/alipay/wappay/notify_url.php']);

		    return ;
   		
   		}

   		//微信充值

   		


   	}

	function resEdit()
	{
		$this->res['name']="";
		if(isset($_POST['name']))
		{
			//print_r($_POST);
			$_POST['begin1']=date("H:i:00",strtotime($_POST['begin1']));
			$_POST['end1']=date("H:i:00",strtotime($_POST['end1']));
			$_POST['begin2']=date("H:i:00",strtotime($_POST['begin2']));
			$_POST['end2']=date("H:i:00",strtotime($_POST['end2']));
			if($_POST['begin2']==$_POST['end2'])
			{
				unset($_POST['begin2']);
				unset($_POST['end2']);	
			}	
			if(isset($_POST['weekend']))
			$_POST['stopweekday']=implode(",",$_POST['weekend']);

			if(empty($_POST['id']))
			{
				if(isset($_GET['uid']))
					$_POST['userid']=$_GET['uid'];
				else
					$_POST['userid']=$this->userid;
			}
			
			
			$tmp=explode(" - ",$_POST['vication']) ;
			$_POST['vicationstart']=date("Y-m-d",strtotime($tmp[0]));
			$_POST['vicationstop']=date("Y-m-d",strtotime($tmp[1]));

			if(!isset($_POST['status']))
				$_POST['status']='1';


			saveData("service",$_POST);

			if(empty($_POST['id']))
			{

				//echo "sjajksa";
			$id=getLastId();
			gourl("index.php?m=user&act=resEdit&id=".$id);

			}
			//msgback("已经保存");
		}

		if(isset($_GET['id'])&&$_GET['id']>0)
		{
			$data=getRow("select * from service where id=".$_GET['id']);



		$msgnum=0;

   		$viewtimes=0;

   		$msg=array();


   		//检查服务图片
   		
   			$viewtimes=$data['viewtimes'];
   			if(empty($data['pic']))
   				$msg[]=array("msg"=>"您的服务".$data['name']."没有上传图片","url"=>"#");
   			if($data['begin1']==$data['end1'])
   				$msg[]=array("msg"=>"您的".$data['name']."营业时间设置不对","url"=>"#");
   			# code...
  

   		$msgnum=count($msg);

			$data['begin1']=date("H:i",strtotime($data['begin1']));
			$data['end1']=date("H:i",strtotime($data['end1']));
			$data['begin2']=date("H:i",strtotime($data['begin2']));
			$data['end2']=date("H:i",strtotime($data['end2']));

			$tmp=explode(",", $data['stopweekday']);

			for($i=1;$i<=7;$i++)
			{
				if(in_array($i, $tmp))
					$data['wk'.$i]=1;
			}

			$data['vaction']=date("m/d/Y",strtotime($data['vicationstart']))." - ".date("m/d/Y",strtotime($data['vicationstop']));

			//得到特价列表
			$priceList=getData("select * from serviceprice where serviceid=".$_GET['id']);


			foreach ($priceList as $key => $value) {
				$remark="";
				if($value['begin1']<>$value['end1'])
					$remark="每日".$value['begin1']."到".$value['end1'];

				if(trim($value['stopweekday'])<>"")
					$remark.=" 周".$value['stopweekday'];

				$remark.=" 节假日".$value['vicationstart']."到".$value['vicationstop'];
				$priceList[$key]['remark']=$remark;
			}

			$this->res['priceList']=$priceList;
			$data['priceList']=$priceList;

			if(isset($_FILES['f1'])&&isset($_POST['serviceid'])&&$_POST['serviceid']>0)//上传
			{
				include "includes/img.inc";
				//校验图片
				$imgpath=savePic("f1","pic/service/",400);

				//图片压缩保存

				//写入数据库
				$_POST['picname']=$imgpath;
				//print_r($_POST);
				saveData("servicepic",$_POST);
				saveData("service",array("id"=>$_POST['serviceid'],"pic"=>$imgpath));


			}

			$this->res["pic"]=getData("select * from servicepic where serviceid=".$_GET['id']." order by id desc");

			$this->res['data']=$data;
			//$data['pic1']=$data['pic'];
			$data['pic1']=$this->res["pic"];
						$data['msgnum']=$msgnum;
   					$data['msg']=$msg;
   					$data['viewtimes']=$viewtimes;
			return $data;
		}


	}

	function resPicDel()
	{
			$dt=getRow("select * from servicepic where id=".$_GET['id']);
		
				unlink($value['picname']);

		exeSql("delete from servicepic where id=".$_GET['id']);
		

			//delservice

			gourl("index.php?m=user&act=resEdit&id=".$dt['serviceid']);
	}

	function resList()
	{
		$start=0;
		if(isset($_GET['page']))
		{
			$page=$_GET['page'];
			if($page<1)$page=1;

			$start=($page-1)*20;
		}

		if(isset($_GET['id']))
			$id=$_GET['id'];
		else
			$id=$this->userid;
		$data=getData("select * from service where status>0 and userid='".$id."' order by id desc limit $start,20");

		$this->res['data']=$data;
		$this->res['uid']=$id;

		if(isset($_GET['op']))
			$this->res['op']=$_GET['op'];


		
	}

	function resOrder()
	{
		if(isset($_POST['name']))
		{
			//检查手机 用户是不是存在，不存在就创建用户
			//print_r($_POST);
			//exit;
			if (!isset($_POST['mobile'])||strlen(trim($_POST['mobile']))<>11||substr($_POST['mobile'],0,1)<>1) 
			{
				msgback("手机号码不正确");
			}

			$cust=getRow("select id from customer where mobile='".trim($_POST['mobile'])."' ");
			if(empty($cust))
			{
				saveData("customer",array("mobile"=>trim($_POST['mobile'])));
				$customerid=getLastId();
			}
			else
				$customerid=$cust['id'];

			//建立订单
			 $order=array("dt"=>date("Y-m-d H:i:s"),
               "userid"=>$this->userid,
               "customerid"=>$customerid,
               "status"=>'2',
               "totle"=>0,
               "remark"=>$_POST['remark']
               );

		      saveData("order",$order);
		      $orderid=getLastId();
		      //写入订单明细表

		      $tt=explode(" ", trim($_POST['timerange']));
		      foreach ($tt as $key => $value) 
		      {
		      	 
		      	$tmp=explode("-", $value);
		     
		         $orderDetail=array('serviceid' => $_POST['id'],
		         "price"=> 0,
		         "num"=>1,
		         "begintime"=>date("Y-m-d H:i:s",strtotime($_GET['dt']." ".$tmp[0])),
		         "endtime"=>date("Y-m-d H:i:s",strtotime($_GET['dt']." ".$tmp[1])),
		         "orderid"=>$orderid
		         );
		         # code...
		      
		      saveData("orderdetail",$orderDetail);
		      }
		     

		      $order['id']=$orderid;
		      gourl("index.php?m=user&act=oEdit&id=".$order['id']);

		}

		$service=getRow("select * from service where id=".$_REQUEST['id']);
		$this->res['service']=$service;
	}

	function resDel()
	{
		if(isset($_GET['id'])&&$_GET['id']>0)
		{
			//del pic
			$dt=getData("select * from servicepic where serviceid=".$_GET['id']);
			foreach ($dt as $key => $value) 
			{
				unlink($value['picname']);

			}
			exeSql("delete from servicepic where serviceid=".$_GET['id']);
			exeSql("update service set status=0 where id=".$_GET['id']);

			//delservice

			gourl("index.php?m=user&act=resList");
		}
	}

	function resPriceDel()
	{
		if(isset($_GET['id'])&&$_GET['id']>0)
		{
			
			exeSql("delete from serviceprice where id=".$_GET['id']);
			

			gourl("index.php?m=user&act=resList");
		}
	}

	function resPrice()
	{
		//保存价格策略
		if(isset($_POST['name']))
		{
			//print_r($_POST);
			$_POST['begin1']=date("H:i:00",strtotime($_POST['begin1']));
			$_POST['end1']=date("H:i:00",strtotime($_POST['end1']));
			
			
			if(isset($_POST['weekend']))
			$_POST['stopweekday']=implode(",",$_POST['weekend']);
			$_POST['userid']=$this->userid;
			$tmp=explode(" - ",$_POST['vication']) ;
			$_POST['vicationstart']=date("Y-m-d",strtotime($tmp[0]));
			$_POST['vicationstop']=date("Y-m-d",strtotime($tmp[1]));

			if(!isset($_POST['status']))
				$_POST['status']='1';


			saveData("serviceprice",$_POST);
			msgback("已经保存");
		}

		if(isset($_GET['id'])&&$_GET['id']>0)
		{
			$data=getRow("select sp.*,s.name  from service as s left join serviceprice as sp on s.id=sp.serviceid  where sp.id=".$_GET['id']);
		}
		elseif(isset($_GET['sid'])&&$_GET['sid']>0)
		{
			$data=getRow("select sp.*,s.name  from service as s left join serviceprice as sp on s.id=sp.serviceid  where s.id=".$_GET['sid']);
			$data['serviceid']=$_GET['sid'];
		}
			

			$data['begin1']=date("H:i",strtotime($data['begin1']));
			$data['end1']=date("H:i",strtotime($data['end1']));
			

			$tmp=explode(",", $data['stopweekday']);

			for($i=1;$i<=7;$i++)
			{
				if(in_array($i, $tmp))
					$data['wk'.$i]=1;
			}

			if(is_null($data['vicationstart']))
				$data['vaction']=date("m/d/Y")." - ".date("m/d/Y");
			else
				$data['vaction']=date("m/d/Y",strtotime($data['vicationstart']))." - ".date("m/d/Y",strtotime($data['vicationstop']));


			$this->res['data']=$data;

		
			return $data;
		
	}

	function detail()
	{
		//判断是不是购买了本条信息
		if($this->userid>0)
		{
			$data=getData("slect re.* from requment as re,order1 as o where o.requid=re.id and o.userid='".$this->userid."' and re.id=".$_GET['id']);
			$this->res['data']=$data;
		}
		else
		{
			$this->res=array("code"=>0,"msg"=>"您还没有登录");
		}

		echo json_encode($this->res);
	}

	function login()
	{
		//无密登陆

			//检查openid是否存在，存在的话直接登陆
		$openid="";
		 
		if(isset($_SESSION['userid'])&&$_SESSION['userid']>0)
		{
			//if(trim($_SESSION['pic'])=="")
	   		//			gourl("index.php?m=user&act=profile");
	   		//else
				gourl("index.php?m=user&act=index");
		}



		if(is_weixin())
		{

			if(empty($_SESSION['openid']))
			{
				include "wxsdk/jssdk.php";
				$jssdk = new JSSDK(APPID, APPSECRET);
				$openid=$jssdk->getOpenId();
				$_SESSION['openid']=$openid;
			}
			else
			{
				$openid=$_SESSION['openid'];
			}
			


			if(($row=getRow("select id,username,name,pic,status,openid from user where openid='".$openid."'")) && $openid<>"")
			{

				//$_SESSION['mobile']=$row['mobile'];
				$_SESSION['userid']=$row['id'];
				$_SESSION['username']=$row['username'];
				$_SESSION['name']=$row['name'];
				$_SESSION['pic']=$row['pic'];
				$_SESSION['status']=$row['status'];
				//$_SESSION['openid']=$row['openid'];

				
				//查询用户openid
				
				//print_r($row);
				//记录登录操作
				exeSql("update user set lastlogin=sysdate(),logintimes=logintimes+1 where id=".$row['id']);

					//if(trim($row['pic'])=="")
	   				//	gourl("index.php?m=user&act=profile");
	   				//else
						gourl("index.php?m=user&act=index");
				exit;
			
			}

		}
			
			



		if(isset($_POST['mobile'])&&$_POST['mobile']&&$_POST['passwd'])
		{
			$_POST['pws']=md5("egg".$_POST['passwd']);
			if($row=getRow("select * from user where mobile=:mobile and passwd=:pws",$_POST))
			{
				//$_SESSION['mobile']=$row['mobile'];
				$_SESSION['userid']=$row['id'];
				$_SESSION['username']=$row['username'];
				$_SESSION['name']=$row['name'];
				$_SESSION['pic']=$row['pic'];
				$_SESSION['status']=$row['status'];
				//$_SESSION['openid']=$row['openid'];

				
				//查询用户openid
				
				
				//记录登录操作
				if($openid<>"")
				exeSql("update user set openid='".$openid."', lastlogin=sysdate(),logintimes=logintimes+1 where id=".$row['id']);
				else
					exeSql("update user set lastlogin=sysdate(),logintimes=logintimes+1 where id=".$row['id']);
				
				if(trim($row['pic'])=="")
	   					gourl("index.php?m=user&act=profile");
	   				else
					gourl("index.php?m=user&act=calendar");
			}
			else
			{
				msgback("用户名或密码错误");
			}
		}

	}

	function author()
	{


	  		//print_r($_SERVER);
			
		/*	include "wxsdk/jssdk.php";
						$jssdk = new JSSDK(APPID, APPSECRET);
						$openid=$jssdk->getOpenId();*/

						exeSql("update user set openid='".$_SESSION['openid']."' where id=".$_SESSION['userid']);

		gourl("index.php?m=user&act=calendar");			
	}

	function logout()
	{
		session_destroy(); 
		gourl("index.php?m=user&act=login");
	}

	function regist()
	{
		if(isset($_POST['name'])&&$_POST['name']&&$_POST['passwd']==$_POST['passwd1'])
		{
			if (!isset($_POST['mobile'])||strlen(trim($_POST['mobile']))<>11||substr($_POST['mobile'],0,1)<>1) 
			{
				msgback("手机号码不正确");
			}

			

			$_POST['regdt']=date("Y-m-d H:m:t");
			$_POST['passwd']=md5("egg".$_POST['passwd']);

			try {
	
				saveData("user",$_POST);
				//msgback("注册成功，点左下角链接试试是否可以登录");
				gourl("index.php?m=user&act=login");

			} catch (PDOException $ex) {
//修改密码
			 if($_POST["verify"]!=$_SESSION['passkey'])
	         {
	            msgback("验证码不对");
	         }

            $row=getRow("select id from user where mobile=:mobile",$_POST);
            $_POST['id']=$row['id'];
            unset($_POST['regdt']);
            saveData("user",$_POST);
			   msgback("您的新密码已经设置好,点击左下角链接，试试是否可以登录");
			}


			
			
		}
		
	}

	function oList()
	{
		if($this->res['ustatus']>2)
			$data=getData("select distinct o.id,c.name,c.mobile,o.dt,o.totle,s.name as sname,o.status,LEFT(od.begintime,16) as begin  from customer as c,`order` as o ,orderdetail as od,service as s where c.id=o.customerid and o.id=od.orderid and od.serviceid=s.id and o.status>='2' order by o.id desc limit 0,100");
		else
		$data=getData("select distinct o.id,c.name,c.mobile,o.dt,o.totle,s.name as sname,o.status,LEFT(od.begintime,16) as begin from customer as c,`order` as o ,orderdetail as od,service as s where c.id=o.customerid and o.id=od.orderid and od.serviceid=s.id and o.userid=".$_SESSION['userid']." and o.status>='2' order by o.id desc limit 0,100");

		$order=array();
		$lastId=0;
		/*foreach ($data as $key => $value) {
			# code...
			if($lastId<>$value['id'])
			{
				$order[]=$value;
				$lastId=$value['id'];
			}
			else
			{
				$order[sizeof($order)]['sname'].=",".$value['sname'];
			}
			
		}*/

		$this->res['data']=$data;

	}

	function oListPrint()
	{
		$data=getData("select o.id,c.name,c.mobile,o.dt,o.totle,s.name as sname,o.status,LEFT(od.begintime,16) as begin,LEFT(od.endtime,16) as end from customer as c,`order` as o ,orderdetail as od,service as s where c.id=o.customerid and o.id=od.orderid and od.serviceid=s.id and o.userid=".$_SESSION['userid']." and o.status>='2' order by o.id desc limit 0,100");

		$order=array();
		$lastId=0;
		/*foreach ($data as $key => $value) {
			# code...
			if($lastId<>$value['id'])
			{
				$order[]=$value;
				$lastId=$value['id'];
			}
			else
			{
				$order[sizeof($order)]['sname'].=",".$value['sname'];
			}
			
		}*/

		$this->res['data']=$data;
	}

	function oEdit()
	{

		$order=getRow("select distinct o.id,c.name,c.mobile,o.dt,o.totle,o.paytype,o.status,o.remark  from customer as c,`order` as o  where c.id=o.customerid  and o.id=".$_GET['id']);
		$od=getData("select od.*,s.name as sname   from orderdetail as od,service as s where  od.serviceid=s.id and od.orderid=".$_GET['id']);

		if(isset($_GET['s'])&&$_GET['s']=='4'&&$order['status']=='2')
		{
			exeSql("update `order` set status='4' where id=".$_GET['id']);
			$order['status']='4';
		}	
		
		$this->res+=$order;
		$this->res['orderdetail']=$od;

	}

	function oRefund()//退款
	{
		$acountDetail=getRow("select pinzhen,payway from acountDetail where orderid=".$_REQUEST['orderid']);
		if(empty($acountDetail))
			msgback("没有找到支付记录");
		if($acountDetail['payway']=="w")//微信支付
		{

			ini_set('date.timezone','Asia/Shanghai');
			error_reporting(E_ERROR);

			require_once "../Wxpaygzh/lib/WxPay.Api.php";
			require_once '../Wxpaygzh/example/log.php';

			if(isset($_REQUEST["transaction_id"]) && $_REQUEST["transaction_id"] != "")
			{
			$transaction_id = $_REQUEST["transaction_id"];
			$total_fee = $_REQUEST["total_fee"];
			$refund_fee = $_REQUEST["refund_fee"];
			$input = new WxPayRefund();
			$input->SetTransaction_id($transaction_id);
			$input->SetTotal_fee($total_fee);
			$input->SetRefund_fee($refund_fee);
		    $input->SetOut_refund_no(WxPayConfig::MCHID.date("YmdHis"));
		    $input->SetOp_user_id(WxPayConfig::MCHID);
			print_r($result=WxPayApi::refund($input));

			//修改订单状态
			$oid=$_REQUEST['orderid'];
		
		

		      $order=getRow("select * from `order` where id=".$oid);
		      if($order['status']==2)
		      {
		           //修改订单状态	
		      	exeSql("update `order` set status=5 where id=".$oid);
		       
		         //卖家资金账户修改+
		        
		      $order['remark']="服务退款";
		     // $order['pinzhen']=$pinzhen;
		      $order['payway']="w";//$payway;
		         //增加财务记录
					include "cust.php";
					$cust=new cust;
					$order['totle']=-$order['totle'];
					$this->changeAcount($order);	
				
					msgback("退款成功");
		      }

		
			}
		}


	}

	function profile()//编辑用户资料
	{
		if(isset($_POST['name']))
		{
			//unset($_POST['name']);
			unset($_POST['mobile']);
			if($_POST['passwd']<>$_POST['passagain'])
				msgback("两次输入密码不一致");
			if(trim($_POST['passwd'])=="")
				unset($_POST['passwd']);
			
			if(!isset($_POST['ispublic']))
				$_POST['ispublic']='1';

			//创建财务账户
			if(isset($_POST['rate'])&&trim($_POST['rate'])>0)
			{
				
				$acount=getRow("select rate from acount where userid=".$_POST['id']);
				
					if(empty($acount))
					{
					//插入我的财物账户记录
						saveData("acount",array("userid"=>$_POST['id'],"rate"=>$_POST['rate']));

					}
					else
						unset($_POST['sales']);
				
				
			      
			}

			saveData("user",$_POST);
			exeSql("update city set times=times+1 where name='".trim($_POST['city'])."'");



		}


		if(isset($_FILES['f1']))//上传
			{
				include "includes/img.inc";
				//校验图片
				$imgpath=savePic("f1","pic/user/",400);

				//图片压缩保存

				//写入数据库
				$_POST['picname']=$imgpath;
				//print_r($_POST);
				if($_POST['type']=="背景")
				{
					saveData("user",array("id"=>$this->userid,"backpic"=>$imgpath));
				}
				elseif($_POST['type']=="营业执照")
				{
					saveData("user",array("id"=>$this->userid,"licencepic"=>$imgpath));
				}
				else
				{
					saveData("user",array("id"=>$this->userid,"pic"=>$imgpath));
					$_SESSION['pic']=$imgpath;
				}
			}

			$acount=getRow("select rate from acount where userid=".$this->userid);
			$this->res+=$acount;
		$this->res+=getRow("select * from user where id=".$this->userid);
		$this->res['cities']=getData("select * from city order by times desc,name");
		$this->res['typelist']=getData("select * from usertype");

		$msgnum=0;

   		

   		$msg=array();

   		//检查商家介绍 
   		if(trim($this->res['into'])=="")
   			$msg[]=array("msg"=>"您的商家介绍还没有填写","url"=>"#");
   		//检查地址
   		if(trim($this->res['address'])==""||trim($this->res['city'])=="")
   			$msg[]=array("msg"=>"您的地址还没有填写正确","url"=>"#");
   		//检查商家图片
   		if(trim($this->res['pic'])=="")
   			$msg[]=array("msg"=>"您的门店图片还没有上传","url"=>"#");
   			//检查服务
   		$service=getData("select * from service where userid=".$this->userid);
   		//检查服务
   		if(empty($service))
   			$msg[]=array("msg"=>"您没有上传服务","url"=>"index.php?m=user&act=resEdit");

   		

   		$msgnum=count($msg);

   		$this->res['msgnum']=$msgnum;
   		$this->res['msg']=$msg;
   		
	}

	function calendar()
	{
		$str="";
		if(isset($_GET['id']))
			$str=" and od.serviceid=".$_GET['id'];

		$this->res['data']=getData("select od.*,s.name as sname   from `order` as o, orderdetail as od,service as s where od.begintime>'2018-01-01' and o.id=od.orderid and od.serviceid=s.id and o.userid=".$this->userid."  and o.status>='2' $str order by o.id desc limit 0,50");
		$this->index();
	}

	 function custManage()
	 {
	      $sql="select count(*) as num from customer where pid='".$this->userid."'";


		if(isset($_POST["vication"]))
		{
			$tmp=explode(" - ", $_POST["vication"]);
			$begin=date("Y-m-d",strtotime($tmp[0]));
			$end=date("Y-m-d",strtotime($tmp[1]));
		}
		else
		{
			$begin=date("Y-m-01");
			$end=date("Y-m-d");
		}
		
		if(!empty($_POST['name']))
		{
			$uname=trim($_POST['name']);
			$uname=" and c.pid='".$uname."'";
		}
		else
			$uname= "and c.pid='".$this->userid."'";

		$list=getData("select c.name,c.pid,c.createdt as regdt,o.id,o.totle,o.dt from customer as c,`order` as o where o.customerid=c.id $uname and o.dt>='".$begin."' and o.dt<'".$end."' and o.status in('2','4')");

		$totle=getRow("select count(c.id) as unum,count(o.id) as onum,sum(o.totle) as totle from customer as c,`order` as o where o.customerid=c.id $uname and o.dt>='".$begin."' and o.dt<'".$end."' and o.status in('2','4')");

		$this->res['data']=$list;
		$this->res['totle']=$totle;
	 }

	function userManage()
	{

		if($this->userid>3)
			msgback("权限不够");


		$wherestr=" where 1=1";
		if(isset($_REQUEST['name']))
			$wherestr=" and name like '".trim($_REQUEST['name'])."%'";
		if(isset($_REQUEST['sales']))
			$wherestr=" and sales like '".trim($_REQUEST['sales'])."%'";

		$list=getData("select * from user $wherestr order by id desc limit 0,1000");

		$this->res['data']=$list;
	}

	function userEdit()
	{
		if($this->userid>3)
			msgback("权限不够");


		if(isset($_POST['name']))
		{
			//unset($_POST['name']);
			unset($_POST['mobile']);
			if($_POST['passwd']<>$_POST['passagain'])
				msgback("两次输入密码不一致");
			if(trim($_POST['passwd'])=="")
				unset($_POST['passwd']);
			
			if(!isset($_POST['ispublic']))
				$_POST['ispublic']='1';

			//创建财务账户
			if(isset($_POST['rate'])&&trim($_POST['rate'])>0)
			{
				
				$acount=getRow("select rate from acount where userid=".$_GET['id']);
				
					if(empty($acount))
					{
					//插入我的财物账户记录
						saveData("acount",array("userid"=>$_GET['id'],"rate"=>$_POST['rate']));

					}
					else
						unset($_POST['sales']);
				
				
			      
			}

			saveData("user",$_POST);
			exeSql("update city set times=times+1 where name='".trim($_POST['city'])."'");



		}


		if(isset($_FILES['f1']))//上传
			{
				include "includes/img.inc";
				//校验图片
				$imgpath=savePic("f1","pic/user/",400);

				//图片压缩保存

				//写入数据库
				$_POST['picname']=$imgpath;
				//print_r($_POST);
				if($_POST['type']=="背景")
				{
					saveData("user",array("id"=>$_GET['id'],"backpic"=>$imgpath));
				}
				elseif($_POST['type']=="营业执照")
				{
					saveData("user",array("id"=>$_GET['id'],"licencepic"=>$imgpath));
				}
				else
				{
					saveData("user",array("id"=>$_GET['id'],"pic"=>$imgpath));
					$_SESSION['pic']=$imgpath;
				}
			}


$this->res=getRow("select * from user where id=".$_GET['id']);
			$acount=getRow("select rate from acount where userid=".$_GET['id']);
			$this->res+=$acount;
		
		$this->res['cities']=getData("select * from city order by times desc,name");
		$this->res['typelist']=getData("select * from usertype");






	}

	function orderManage()//计算业务员的提成 输入销售员和时间段
	{
		if($this->userid>3)
			msgback("权限不够");
		if(isset($_POST["vication"]))
		{
			$tmp=explode(" - ", $_POST["vication"]);
			$begin=date("Y-m-d",strtotime($tmp[0]));
			$end=date("Y-m-d",strtotime($tmp[1]));
		}
		else
		{
			$begin=date("Y-m-01");
			$end=date("Y-m-d");
		}
		
		if(!empty($_POST['name']))
		{
			$uname=trim($_POST['name']);
			$uname=" and u.sales like '".$uname."%'";
		}
		else
			$uname="";

		$list=getData("select u.name,u.sales,u.regdt,o.id,o.totle,o.dt from user as u,`order` as o where o.userid=u.id $uname and o.dt>='".$begin."' and o.dt<'".$end."' and o.status in('2','4')");

		$totle=getRow("select count(u.name) as unum,count(u.sales) as usales,count(o.id) as onum,sum(o.totle) as totle from user as u,`order` as o where o.userid=u.id $uname and o.dt>='".$begin."' and o.dt<'".$end."' and o.status in('2','4')");

		$this->res['data']=$list;
		$this->res['totle']=$totle;

	}


	function ajaxTimeList()//日期，资源ID 返回时间列表
   	{

   		$data=getRow("select * from service where id=".$_GET['id']." ");
     	$rt=array();

     	//检查是不是可以预定的日期----------------
        $w=date("w",strtotime($_GET['dt']));
         if($w==0) $w='7';

         //echo strpos($data['stopweekday'],$w)," ",$data['stopweekday']," ",$w;
         //判断是不是超过今天或者超过预定期限
         if($_GET['dt']<date("Y-m-d")||$_GET['dt']>date("Y-m-d",strtotime("+".$data['validday']." days"))||strpos("a".$data['stopweekday'],$w)||($_GET['dt']>=$data['vicationstart']&&$_GET['dt']<=$data['vicationstop']))
         {
            echo json_encode($rt);

        // echo json_encode($order);
            exit;
         }

      //查询特价------------
      $price=getRow("select * from serviceprice where serviceid=".$_GET['id']);


   		$cdate=$data['begin1'];
   		//拆分时段--------------	
   		while (($cdate<$data['end1']||$cdate<$data['end2'])&&$cdate>=$data['begin1']) 
   		{
   			# code...
   			$tbegin=date("H:i",strtotime($cdate));
   			$tend=date("H:i",strtotime($cdate ."+".$data['unit']." minutes"));

        //如果是在闲时价格区间
        if(isset($price['price'])&&strpos("a".$price['stopweekday'],$w)&&$tbegin>=$price['begin1']&&$tbegin<$price['end1'])
        {
          $rt[]=array($tbegin,$tend,$data['num'],$price['price']);
        }
        else
   			  $rt[]=array($tbegin,$tend,$data['num'],"0");


   			$cdate=date("H:i",strtotime($tend ."+".($data['intevm'])." minutes"));

   			if($cdate>$data['end1']&&$cdate<$data['begin2']&&$data['end2']>$data["begin2"])
   				$cdate=$data['begin2'];
   		}


   		//查找当天已下订单
   		$order=getData("select od.* from orderdetail as od,`order` as o where od.serviceid=".$_GET['id']." and od.begintime>'".$_GET['dt']."' and od.begintime<='".date("Y-m-d H:i:00",strtotime($_GET['dt']."+1 day "))."' and od.orderid=o.id and o.status=2");
   		//返回时间段
         //print_r($rt);
   		foreach ($rt as $k => $v) 
   		{
   			foreach ($order as $ok => $ov) 
   			{
   				if(isset($rt[$k])&&$v[0]>=substr($ov['begintime'],11,5)&&$v[0]<substr($ov['endtime'],11,5))//已经被预定
               {

                  if($rt[$k][2]==1)
                     unset($rt[$k]);
                  else
                     $rt[$k][2]--;
               }
   					
                  //$rt[$k]['used']=true;
   			}
   			
   		}

   		//$unitlist=$rt;
   		echo json_encode($rt);

        // echo json_encode($order);
   		exit;
   	
   	}

   	public static function tixian($acount)
   	{
   			//微信提现

   		//$user
   		
   			if(!($acount['balance']>99))
   				return ("最小提现不能小于100");
   			//检查是不是在微信环境
   		

				if(empty($acount['openid']))
					return ("亲，您的登录不正常，请退出后重新登录");

				//检查用户的openid

				//检查短信
				//检查账上是否有钱
   			$realmoney=$acount['balance']-intval($acount['locked']);
   			if($realmoney<0)
   				return ("您的现金不足");

//全部金额，除去锁定金额
   				$change=-$realmoney;//round($realmoney,2);
		      $detail=array(
		         "acountid"=>$acount['id'],
		         "lastbalance"=>$acount['balance'],
		         "change"=>$change,
		         "dt"=>date("Y-m-d H:i:s"),
		        
		         "payway"=>"w",
		         "userid"=>$acount['userid'],
		         "remark"=>"提现到微信",
		         "status"=>"1"
		      );
		      saveData("acountDetail",$detail);
		      $detailId=getLastId();


				require_once "Wxpaygzh/lib/paytouser.php";
				$r=payToUser($acount['openid'],$acount['username'],$realmoney,$detailId);

				if(($r['return_code']=='SUCCESS'&&$r['result_code']=='SUCCESS')||$r['err_code']=='SYSTEMERROR')
				{
				//账户减少
					$change=-round($realmoney,2);
			      $detail=array(
			      	"id"=>$detailId,
			     
			          "pinzhen"=>$r['payment_no'],
			         "status"=>"2"
			      );
			      if(isset($r['err_code'])&&$r['err_code']=='SYSTEMERROR')
			      	 $detail["remark"]="提现到微信延迟支付";

			      saveData("acountDetail",$detail);
			         //修改总账
			      saveData("acount",array("id"=>$acount['id'],"balance"=>$acount["balance"]+$change,"lastdt"=>date("Y-m-d H:i:s"),"txdt"=>date("Y-m-d")));

				return ( "提现成功");
				} else {
					//print_r($r);
					//exit;
					saveData("acount",array("id"=>$acount['id'],"txdt"=>date("Y-m-d")));
					return($r['err_code_des']);
				}


	   		
	
   	}

   	function hrEdit()
   	{
   		$id=0;
   		if(isset($_GET['id']))
   			$id=$_GET['id'];

   		if(empty($_COOKIE['city']))
   		{
   			$city=getRow("select city from user where id=".$this->userid);
   			$_COOKIE['city']=$city['city'];
   			setcookie("city",$city['city']);
   		}

   		if(isset($_POST['title']))
   		{
   			$_POST['type']="招聘";
   			$_POST['userid']=$this->userid;
   			 $_POST['begindt']=date("Y-m-d H:i:s");
	        $_POST['enddt']=date("Y-m-d",strtotime("+". $_POST['validday']." days"));
	        $_POST['updatedt']=$_POST['begindt'];
	        $_POST['city']=$_COOKIE['city'];
   			saveData("topic",$_POST);
   			if(empty($_GET['id']))
   				$id=getLastId();
   		}
   		
   		if($id>0)
   		{
   			$this->res['data']=getRow("select * from topic where id=$id");
   		}

   	}

   	function hrList()
   	{
   		$this->res['list']=getData("select * from topic where userid=".$this->userid." and type='招聘'");
   	}

   	function actEdit()
   	{
   		$id=0;
   		if(isset($_GET['id']))
   			$id=$_GET['id'];

   		if(empty($_COOKIE['city']))
   		{
   			$city=getRow("select city from user where id=".$this->userid);
   			$_COOKIE['city']=$city['city'];
   			setcookie("city",$city['city']);
   		}

   		if(isset($_POST['title']))
   		{
   			exeSql("update topic set active=0 where userid=".$this->userid);
   			//added by lingshi
   			$_POST['type']="商家促销";
   			$_POST['userid']=$this->userid;
   			 $_POST['begindt']=date("Y-m-d H:i:s");
	        $_POST['enddt']=date("Y-m-d",strtotime("+". $_POST['validday']." days"));
	        $_POST['updatedt']=$_POST['begindt'];
	        $_POST['city']=$_COOKIE['city'];
	        $_POST['active']=1;
   			saveData("topic",$_POST);
   			if(empty($_GET['id']))
   				$id=getLastId();

   			
   		}
   		
   		if($id>0)
   		{
   			$this->res['data']=getRow("select * from topic where id=$id");
   		}

   		$this->res['servicelist']=getData("select id,name from service where userid=".$this->userid);

   	}

   	function actList()
   	{
   		$this->res['list']=getData("select * from topic where userid=".$this->userid." and type='商家促销'");
   	}

	

}