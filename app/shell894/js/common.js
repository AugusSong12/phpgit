// JavaScript Document


//tab切换
function tabs(tabId, tabNum){
	$(tabId + " .tab-tit a").removeClass("active");
	$(tabId + " .tab-tit a").eq(tabNum).addClass("active");
	$(tabId + " .tab-con").hide();
	$(tabId + " .tab-con").eq(tabNum).show();
}
