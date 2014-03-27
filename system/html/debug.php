<style type="text/css">
	#tzn_debug *{margin:0;padding:0;}
	#tzn_debug {margin:0 10% 0 10%;font-size:12px;color:#666;}
	#tzn_debug li{list-style:none;}
	#tzn_debug div{width:100%;}
	#tzn_debug #tab1{width:100%;height:34px;border:1px #cfedff solid;border-bottom:0;}
	#tzn_debug #tab1 ul{margin:0;padding:0;}
	#tzn_debug #tab1 li{float:left;padding:0 30px;height:34px;line-height:34px;text-align:center;border-right:1px #ebf7ff solid;cursor:pointer;}
	#tzn_debug #tab1 li.now{color:#5299c4;background:#fff;font-weight:bold;}
	#tzn_debug .tablist{width:80%;padding:0 10% 0 10%;font-size:14px;line-height:24px;border:1px #cfedff solid;border-top:0;display:none;}
	#tzn_debug .block{display:block;}
	#tzn_debug td{padding-left:15px;}
</style>
<script type="text/javascript">
	function setTab(m,n){
		var menu=document.getElementById("tab"+m).getElementsByTagName("li");  
		var showdiv=document.getElementById("tablist"+m).getElementsByTagName("div");  
		for(i=0;i<menu.length;i++)
		{
		   menu[i].className=i==n?"now":""; 
		   showdiv[i].style.display=i==n?"block":"none"; 
		}
	}
</script>
</head>
<div id="tzn_debug">
	<div id="tab1">
		<ul>
		   <li onclick="setTab(1,0)" class="now">源码</li>
		   <li onclick="setTab(1,1)">时间</li>
		   <li onclick="setTab(1,2)">内存</li>
		</ul>
	</div>
	<div id="tablist1">
		<div class="tablist block"><?php echo $contents; ?></div>
		<div class="tablist">
		<table>
			<tr><td>事件</td><td>载入时间</td></tr>
			<?php foreach($this->marker['time'] as $key=>$time){
				echo "<tr><td>$key</td><td>$time</td></tr>";
			}
			?>
		</table>
		</div>
		<div class="tablist">
		<table>
		<tr><td>事件</td><td>消耗内存</td></tr>
			<?php foreach($this->marker['memory'] as $key=>$time){
				echo "<tr><td>$key</td><td>$time</td></tr>";
			}
			?>
		</table>
		</div>
	</div>
</div>
