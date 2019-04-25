$(function(){
	
	/* 页面初始化设置 */
	setSize();
	window.addEventListener("resize",setSize,false);
	window.addEventListener("orientationchange",setSize,false);
	function setSize(){
		var html = document.getElementsByTagName('html')[0];
		var pageWidth = html.getBoundingClientRect().width;
		pageWidth =pageWidth >1500?1500:pageWidth; 
		html.style.fontSize = pageWidth / 16 + 'px';
	}
	/* 收藏 */
	$(".collect").click(function(){
		$(this).toggleClass("solid");
	});
	
	
	/* 弹窗 */
	$(".qx").click(function(){
		$(".shadow").css("display","none");
	});
	$(".shadow").click(function(){
		$(this).css("display","none");
	});
	$(".tc").click(function(e){
		e.stopPropagation();
	});
	$(".area-list span").click(function(){
		$(".shadow").css("display","none");
		$(".index .name").text($(this).text());
	})
	
	/* 地区 */
	$(".index .address").click(function(){
		$(".shadow").css("display","block");
	});
	$(".more-area span").click(function(){
		window.location.href="area.html";
	});
	
	/* 后端操作 */
	$(".hdcz .in,.hdcz .out").click(function(){
		$(this).addClass("change").siblings().removeClass("change");
	});
			/* 帖子后端操作 */
	$(".hdcz .type,.hdcz .win,.hdcz .people,.hdcz .gotype").click(function(){
		$(this).find("ul").toggle();
	});
	$(".hdcz li").click(function(){
		/* alert("111"); */
		$(this).parent("ul").siblings("span").text($(this).text());
		
	});
	
	/* area页面 */
	$(".all-area .qx").click(function(){
		window.location.href="index.html";
	});

	/* 召唤峡谷 */
	$(".zhxg .first").click(function(){
	
		$(this).find("ul").toggle();
	});
	$(".zhxg .first li").click(function(){
	
		$(this).parent("ul").siblings("span").text($(this).text());
	});
	
	/* 商家列表 */
	$(".sjlist .choose01").click(function(){
		$(this).find("ul").toggle();
	});
	$(".sjlist .choose01 li").click(function(){
		$(this).parent("ul").siblings("span").text($(this).text());
	});
	
	/* 设置日期时间 */
	 var mydate=new Date();
	 var week=["星期日","星期一","星期二","星期三","星期四","星期五","星期六"]
	 var time=mydate.getFullYear()+"年"+(mydate.getMonth()+1)+"月"+mydate.getDate()+"日"+"&nbsp;&nbsp;"+week[mydate.getDay()]
   $(".date").html(time);
	 
	 /* 数字加减 */
	 var $num=$(".calculation .num").text();
	$(".calculation .subtraction").click(function(){
		$num=$num>0?(--$num):$num;
		$(".calculation .num").text($num);
	});
	$(".calculation .add").click(function(){
		++$num;
		$(".calculation .num").text($num);
	});
	
	/* 日历 */
	$(".h3Ele").click(function(){
		$("#schedule-box").show();
		var $this=$(this);
	});
	$(".schedule-bd").click(function(){
		$("#schedule-box").css("display","none");
	}); 
	
	
		
		
	
		
		
		
	
	$(".sjd-box").click(function(){
		$(".time-slot").show();
		var $this=$(this);
		$(".time-slot span").unbind("click");
		$(".time-slot span").click(function(e){
		
			$this.find(".sjd").text($(this).text());
			$(".time-slot").hide();
		})
	});
	 
		/* 轮播图 */
	 var swiper = new Swiper('.swiper-container', {
      effect: 'coverflow',
      grabCursor: true,
      centeredSlides: true,
      slidesPerView: 'auto',
	  autoplay:2000,
      coverflowEffect: {
        rotate: 50,
        stretch: 0,
        depth: 100,
        modifier: 1,
        slideShadows : true,
      },
      pagination: {
        el: '.swiper-pagination',
      },
    });
	 
		


});
