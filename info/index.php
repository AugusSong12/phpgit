<?php 
include "../includes/common.php";
include "../includes/config.php";
include "../includes/connect.php";

if(isset($_POST['type']))
{
	if(strlen($_POST['mobile'])>7&&is_numeric(substr($_POST['mobile'],0,2)))
	{
		saveData("info",$_POST);
		echo "<script>alert('您的资料在配对中，请耐心等候我们客服联系您')</script>";

	}
	else
		msgback("电话号码不正确");
}

if(isset($_GET['dududu']))
{
	$list=getData("select * from info order by id desc limit 0,200");

	foreach ($list as  $v) {
		echo $v['id']," ",$v['dt']," ",$v['mobile']," ",$v['name']," ",$v['title']," <br>",$v['type']," ",$v['content'],"<br><br>";
		# code...
	}

	exit;
}

?>
<!DOCTYPE html>

<html>

<head>

<title>预约猫-网站维修专家</title>

<!-- for-mobile-apps -->

<meta name="viewport" content="width=device-width, initial-scale=1">

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<meta name="keywords" content="网站维修,网站开发,小程序开发,公众号开发,服务器维护,数据库维护" />

<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false);

		function hideURLbar(){ window.scrollTo(0,1); } </script>

<!-- //for-mobile-apps -->

<link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />

<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />

<!-- js -->

<script type="text/javascript" src="js/jquery-2.1.4.min.js"></script>

<!-- //js -->

<!--link href='http://fonts.googleapis.com/css?family=Cabin:400,400italic,500,500italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'-->

<!--link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css'-->

<!-- start-smoth-scrolling -->

<script type="text/javascript" src="js/move-top.js"></script>

<script type="text/javascript" src="js/easing.js"></script>

<script type="text/javascript">

	jQuery(document).ready(function($) {

		$(".scroll").click(function(event){		

			event.preventDefault();

			$('html,body').animate({scrollTop:$(this.hash).offset().top},1000);

		});

	});

</script>

<!-- start-smoth-scrolling -->

</head>

	

<body>

<!-- banner -->

	<div class="banner">

		<div class="container">

			<nav class="navbar navbar-default">

				<!-- Brand and toggle get grouped for better mobile display -->

				<div class="navbar-header">

				  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">

					<span class="sr-only">Toggle navigation</span>

					<span class="icon-bar"></span>

					<span class="icon-bar"></span>

					<span class="icon-bar"></span>

				  </button>

					<div class="logo">

						<h1><a class="navbar-brand" href="index.html">预约猫</a></h1>

					</div>

				</div>



				<!-- Collect the nav links, forms, and other content for toggling -->

				<div class="collapse navbar-collapse nav-wil" id="bs-example-navbar-collapse-1">

					<nav class="link-effect-2" id="link-effect-2"> 

						<ul class="nav navbar-nav">

						

							<li class="active"><a href="index.html"><span data-hover="首页">首页</span></a></li>

							<li><a href="#about" class="scroll"><span data-hover="关于我们">关于我们</span></a></li>

							<li><a href="#portfolio" class="scroll"><span data-hover="展示">展示</span></a></li>

							<li><a href="#services" class="scroll"><span data-hover="服务">服务</span></a></li>

							<li><a href="#mail" class="scroll"><span data-hover="联系我们">联系我们</span></a></li>

						</ul>

					</nav>

				</div>

				<!-- /.navbar-collapse -->

			</nav>

			<div class="banner-info">

				<h2>网站维修专家</h2>

				<p>我们致力于帮助客户网站维修、小程序、公众号、微网站、数据库、服务器等的维护，以及网站开发、小程序开发、web软件开发、公众号微网站开发等</p>

				<div class="more">

					<a href="#mail" class="hvr-shutter-in-vertical" >提交需求<span class="glyphicon glyphicon-arrow-right"></span></a>

				</div>

				<!--modal-video-->
				<div class="modal video-modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModal">

					<div class="modal-dialog" role="document">

						<div class="modal-content">

							<div class="modal-header">

								<h4>子天科技</h4>

								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>						

							</div>

							<section>

								<div class="modal-body">

									<p>子天科技是互联网科技型服务公司，我们致力于帮助客户网站维修、小程序、公众号、微网站、数据库、服务器等的维护，以及网站开发、小程序开发、web软件开发、公众号微网站开发等

                                       </p>

								</div>

							</section>

						</div>

					</div>

				</div>

				<div class="social_icons">

					<ul>


						<li><a href="#" class="icon page_right_phone"  data-toggle="tooltip" title="0571-85365720"   data-placement="bottom"></a></li>

						<li><a  href="mqqwpa://im/chat?chat_type=wpa&uin=4262833&version=1&src_type=web&web_src=oicqzone.com" class="icon  page_right_qq"></a></li>

						<li><a href="#" class="icon  page_right_web"  data-toggle="tooltip" title="<img src='images/wx.jpg'  width='160px'>" html="true" data-html="<img src='images/wx.jpg'  width='160px'>"  data-placement="bottom"></a></li>

						

					</ul>

				</div>
			</div>

		</div>

	</div>

<!-- //banner -->
<!-- contact -->

	<div class="contact" id="mail">

		<div class="container">

			<h3>需求提交</h3>
<p class="aut">电话：0571-85365720</p>
			
<form action="#" method="post">
			<div class="contact-grids">
				
				<div class="col-md-6 contact-grid">

					

								

						

					<input type="text" name="name" value="姓名" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = '姓名';}" required>

						<input type="text" name="mobile" value="电话" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = '电话';}" required>
					

				</div>

				<div class="col-md-6 contact-grid">

					<input type="text" name="title" value="公司名称" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = '公司名称';}" >

					<select name="type" >
		
		 <option  value="" >请选择您的需求类型 </option>
		 <option  value="网站文字修改" >网站文字修改 </option>
							 <option  value="网站功能修改">网站功能修改 </option>
		 <option  value="服务器部署维护">服务器部署维护</option>
		 <option  value="数据库维护">数据库维护 </option>
		 <option  value="网站部署及安装">网站部署及安装 </option>
		 <option  value="网站搬迁">网站搬迁 </option>
		 <option  value="网站搜索引擎注册">网站搜索引擎注册 </option> 
		 <option  value="网站搜索引擎优化">网站搜索引擎优化 </option>
		 <option  value="网站速度诊断和优化">网站速度诊断和优化 </option>
		 <option  value="网站开发">网站开发 </option>
		 <option  value="小程序开发">小程序开发 </option>
		 <option  value="ios程序开发">ios程序开发 </option>
		 <option  value="安卓程序开发">安卓程序开发 </option>
		 <option  value="其他">其他 </option>
	</select>

							
					

						
			



				</div>
			

				<div class="clearfix"> </div>

<textarea name="content" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = '需求详细描述';}" required>需求详细描述</textarea>	
				


	
							
						
					<input type="submit" value="提交">

				


			
			
		</div>
</form>
	</div>
</div>

<!-- //contact -->

<!-- services -->

	<div class="services" id="services">

		<div class="container">

			<h3>我们提供的服务</h3>

			<p class="aut">我们作为互联网技术公司，提供以下服务.</p>

			<div class="wthree_services_grids">

				<div class="col-md-6 wthree_services_grid">

					<div class="col-xs-4 wthree_services_grid-left">

						<div class="wthree_services_grid-left1">

							<span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>

						</div>

					</div>

					<div class="col-xs-8 wthree_services_grid-right">

						<h4>技术咨询</h4>

						<p>我们为中小企业及商户提供信息化、网络化、智能化相关的需求调研，解决方案，给客提供户最佳性价比的技术方案.</p>

					</div>

					<div class="clearfix"> </div>

				</div>

				<div class="col-md-6 wthree_services_grid">

					<div class="col-xs-4 wthree_services_grid-left">

						<div class="wthree_services_grid-left1">

							<span class="glyphicon glyphicon-plane" aria-hidden="true"></span>

						</div>

					</div>

					<div class="col-xs-8 wthree_services_grid-right">

						<h4>技术研发</h4>

						<p>我们提供网站开发，微信公众号功能开发，淘宝生活号功能开发，各种商品售卖、服务预订等各种按照客户需求的技术研发服务.</p>

					</div>

					<div class="clearfix"> </div>

				</div>

				<div class="clearfix"> </div>

			</div>

			<div class="wthree_services_grids">

				<div class="col-md-6 wthree_services_grid">

					<div class="col-xs-4 wthree_services_grid-left">

						<div class="wthree_services_grid-left1">

							<span class="glyphicon glyphicon-retweet" aria-hidden="true"></span>

						</div>

					</div>

					<div class="col-xs-8 wthree_services_grid-right">

						<h4>互联网产品及软件产品供应商</h4>

						<p>我们自己研发及代理了一些saas、互联网技术产品、网站产品，可以提供给客户，一站式解决客户业务软件的软件安装部署和售后服务工作.</p>

					</div>

					<div class="clearfix"> </div>

				</div>

				<div class="col-md-6 wthree_services_grid">

					<div class="col-xs-4 wthree_services_grid-left">

						<div class="wthree_services_grid-left1">

							<span class="glyphicon glyphicon-briefcase" aria-hidden="true"></span>

						</div>

					</div>

					<div class="col-xs-8 wthree_services_grid-right">

						<h4>软件平台</h4>

						<p>我们目前研发了一款商家平台【预约猫】，商家可以入住，帮助商家提供在线的免费预订、收费预订服务.</p>

					</div>

					<div class="clearfix"> </div>

				</div>

				<div class="clearfix"> </div>

			</div>

		</div>

	</div>

<!-- services -->

<!--<div class="agile_map">

		<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d8149837.562720216!2d105.11989752861514!3d4.138909133998005!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3034d3975f6730af%3A0x745969328211cd8!2sMalaysia!5e0!3m2!1sen!2sin!4v1462444070193" style="border:0"></iframe>

	</div>-->



<!-- footer -->

	<div class="footer">

		<div class="container">

			<div class="footer-grids">

				<div class="col-md-4 footer-grid">

					<h3>关于我们</h3>

					<p>杭州子天科技有限公司是坐落于中国硅谷杭州市的一家新型科技公司.</span></p>

				</div>

				<div class="col-md-4 footer-grid">

					<h3>联系信息</h3>

					<ul>

						<li><i class="glyphicon glyphicon-map-marker" aria-hidden="true"></i>杭州市滨江区东信大道<span>46号4幢2楼,</span> </li>

						

						<li><i class="glyphicon glyphicon-earphone" aria-hidden="true"></i>（+86） 0571-85365720</li>

					</ul>

				</div>
				<div class="col-md-4 footer-grid">

					<h3>客服微信</h3>

					<ul>

						<li>
							<img src="images/wx.jpg" alt="" width="160px">
						</li>

					</ul>

				</div>

				

				

				<div class="clearfix"> </div>

			</div>

		</div>

	</div>

	<div class="copy-right">

		<div class="container">

			<p>Copyright &copy; 2016.杭州子天科技有限公司.<a target="_blank" href="http://beian.com.cn">浙ICP备17055585号-1</a></p>

			

		</div>

	</div>

<!-- //footer -->

<!-- for bootstrap working -->

	<script src="js/bootstrap.js"></script>

<!-- //for bootstrap working -->

<!-- here stars scrolling icon -->

	<script type="text/javascript">

		$(document).ready(function() {

			/*

				var defaults = {

				containerID: 'toTop', // fading element id

				containerHoverID: 'toTopHover', // fading element hover id

				scrollSpeed: 1200,

				easingType: 'linear' 

				};

			*/

			$("[data-toggle='tooltip']").tooltip();			

			$().UItoTop({ easingType: 'easeOutQuart' });

								

			});

	</script>

<!-- //here ends scrolling icon -->

</body>

</html>